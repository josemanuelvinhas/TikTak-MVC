<?php

require_once(__DIR__ . "/../model/Video.php");
require_once(__DIR__ . "/../model/VideoMapper.php");

require_once(__DIR__ . "/../model/LikeMapper.php");

require_once(__DIR__ . "/../model/FollowerMapper.php");

require_once(__DIR__ . "/../model/UserMapper.php");

require_once(__DIR__ . "/../model/Hashtag.php");
require_once(__DIR__ . "/../model/HashtagMapper.php");

require_once(__DIR__ . "/../core/ViewManager.php");
require_once(__DIR__ . "/../controller/BaseController.php");

class VideoController extends BaseController
{

    private $videoMapper;
    private $hashtagMapper;
    private $likeMapper;
    private $followerMapper;
    private $userMapper;

    public function __construct()
    {
        parent::__construct();

        $this->videoMapper = new VideoMapper();
        $this->hashtagMapper = new HashtagMapper();
        $this->likeMapper = new LikeMapper();
        $this->followerMapper = new FollowerMapper();
        $this->userMapper = new UserMapper();
    }

    public function upload()
    {
        if (!isset($_SESSION["currentuser"])) {
            $this->view->redirect("home", "index");
        }

        try {
            $uploadVideo = $this->videoMapper->uploadVideo();

            $video = new Video();
            $video->setVideodescription($_POST["description"]);
            $video->setVideoname($uploadVideo["fileName"]);
            $video->setAuthor($_SESSION["currentuser"]);

            $video->checkIsValidForUpload();
        } catch (ValidationException $ex) {
            if (isset($video)) {
                unlink($video->getVideoname());
            }
            $errors = $ex->getErrors();
            $this->view->setVariable("errors_upload", $errors);
        }

        if (empty($errors)) {
            $id = $this->videoMapper->save($video);

            preg_match_all(Hashtag::$regexpHashtag . "u", $video->getVideodescription(), $matches);

            $hashtags = array_unique($matches[0]);
            foreach ($hashtags as $hs) {
                $hashtag = new Hashtag((int)$id, $hs);
                $this->hashtagMapper->save($hashtag);
            }

            //TODO redirigir a pagina de video
            $queryString = "is=" . $id;
            $this->view->redirect("video", "view", $queryString);
        } else {

            $videos = $this->videoMapper->findAll(0);
            if (isset($this->currentUser)) {
                $idLikes = $this->likeMapper->findByUsername($_SESSION["currentuser"]);
                $this->view->setVariable("idLikes", $idLikes);

                $followers = $this->followerMapper->findFollowingByUsername($_SESSION["currentuser"]);
                $this->view->setVariable("followers", $followers);
            }
            $nVideos = $this->videoMapper->countVideos();
            $nPags = ceil($nVideos / 6);
            $videos = $this->videoMapper->findAll(0);
            if ($nPags > 1) {
                $this->view->setVariable("next", 1);
            }
            $this->view->setVariable("page", 0);
            $this->view->setVariable("videos", $videos);

            $this->view->render("video", "upload");
        }


    }

    public function delete()
    {

        if (!isset($_SESSION["currentuser"])) {
            $this->view->redirect("home", "index");
        }

        if (isset($_POST["id"])) {

            $video = $this->videoMapper->findById($_POST["id"]);

            if ($video != null && $video->getAuthor() === $_SESSION["currentuser"]) {
                $this->videoMapper->delete($video);
                $this->view->redirect("home", "index");
            } else {
                if (isset($_SERVER["HTTP_REFERER"])) {
                    $this->view->redirectToReferer();
                } else {
                    $this->view->redirect("home", "index");
                }
            }
        } else {
            if (isset($_SERVER["HTTP_REFERER"])) {
                $this->view->redirectToReferer();
            } else {
                $this->view->redirect("home", "index");
            }
        }
    }

    public function view()
    {

        if (isset($_GET["id"])) {

            $video = $this->videoMapper->findById($_GET["id"]);

            if ($video === null) {
                if (isset($_SERVER["HTTP_REFERER"])) {
                    $this->view->redirectToReferer();
                } else {
                    $this->view->redirect("home", "index");
                }
            } else {
                $this->view->setVariable("video", $video);

                if (isset($_SESSION["currentuser"])) {
                    $isLike = $this->likeMapper->isLike($_SESSION["currentuser"], $_GET["id"]);
                    $this->view->setVariable("isLike", $isLike);

                    $isFollow = $this->followerMapper->isFollowing($_SESSION["currentuser"], $video->getAuthor());
                    $this->view->setVariable("isFollow", $isFollow);
                }

                $this->view->render("video", "view");
            }
        } else {
            if (isset($_SERVER["HTTP_REFERER"])) {
                $this->view->redirectToReferer();
            } else {
                $this->view->redirect("home", "index");
            }
        }


    }

    public function search()
    {
        if (isset($_GET["hashtag"]) && Hashtag::isValidContentHashtag($_GET["hashtag"])) {

            $nVideos = $this->videoMapper->countVideosByHashtag("#" . $_GET["hashtag"]);
            $nPags = ceil($nVideos / 6);
            $page = 0;
            if (isset($_GET["page"])) {
                if (preg_match('/^[0-9]+$/', $_GET["page"]) && ($temp = (int)$_GET["page"]) < $nPags) {
                    $page = $temp;
                } else {
                    if (isset($_SERVER["HTTP_REFERER"])) {
                        $this->view->redirectToReferer();
                    } else {
                        $this->view->redirect("home", "index");
                    }
                }
            }

            $videos = $this->videoMapper->findAllByHashtag("#" . $_GET["hashtag"], $page);
            $this->view->setVariable("videos", $videos);

            if (isset($_SESSION["currentuser"])) {
                $idLikes = $this->likeMapper->findByUsername($_SESSION["currentuser"]);
                $this->view->setVariable("idLikes", $idLikes);

                $followers = $this->followerMapper->findFollowingByUsername($_SESSION["currentuser"]);
                $this->view->setVariable("followers", $followers);
            }

            if ($nPags > 1) {
                $pagePrevious = $page - 1;
                $pageNext = $page + 1;
                if ($page == 0) {
                    $this->view->setVariable("next", $pageNext);
                } elseif ($page == ($nPags - 1)) {
                    $this->view->setVariable("previous", $pagePrevious);
                } else {
                    $this->view->setVariable("next", $pageNext);
                    $this->view->setVariable("previous", $pagePrevious);
                }
            }
            $this->view->setVariable("page", $page);

            $this->view->setVariable("hashtag", $_GET["hashtag"]);
            $topUsuarios = $this->userMapper->findTop5ByFollowers();
            $this->view->setVariable("topUsuarios", $topUsuarios);
            $trends = $this->hashtagMapper->findTop5Hashtag();
            $this->view->setVariable("trends", $trends);


            $this->view->render("video", "search");

        } else {
            if (isset($_SERVER["HTTP_REFERER"])) {
                $this->view->redirectToReferer();
            } else {
                $this->view->redirect("home", "index");
            }
        }
    }


}