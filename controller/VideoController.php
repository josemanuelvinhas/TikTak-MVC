<?php

require_once(__DIR__ . "/../model/Video.php");
require_once(__DIR__ . "/../model/VideoMapper.php");

require_once(__DIR__ . "/../model/LikeMapper.php");

require_once(__DIR__ . "/../model/FollowerMapper.php");

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

    public function __construct()
    {
        parent::__construct();

        $this->videoMapper = new VideoMapper();
        $this->hashtagMapper = new HashtagMapper();
        $this->likeMapper = new LikeMapper();
        $this->followerMapper = new FollowerMapper();
    }

    public function upload()
    {

        if (isset($_SESSION["currentuser"])) {

            if (isset($_FILES['videoUpload']) && $_FILES['videoUpload']['error'] === UPLOAD_ERR_OK) {
                $fileTmpPath = $_FILES['videoUpload']['tmp_name'];
                $fileName = $_FILES['videoUpload']['name'];

                /* Informacion no usada */
                //$fileSize = $_FILES['videoUpload']['size'];
                //$fileType = $_FILES['videoUpload']['type'];


                $fileNameCmps = explode(".", $fileName);
                $fileExtension = strtolower(end($fileNameCmps));

                $newFileName = time() . '_' . $_SESSION["currentuser"] . '.' . $fileExtension;
                $dest_path = __DIR__ . "/../upload_videos/" . $newFileName;

                $isUploaded = move_uploaded_file($fileTmpPath, $dest_path);


                $video = new Video();
                $video->setVideodescription($_POST["description"]);
                $video->setVideoname($newFileName);
                $video->setAuthor($_SESSION["currentuser"]);

                $errors = $video->checkIsValidForCreate();

                if (!$isUploaded) {
                    $errors["general"] = "Error uploading video";
                }


                $this->view->setVariable("errors_upload", $errors);

                if (empty($errors)) {
                    $id = $this->videoMapper->save($video);

                    preg_match_all("/#([a-zA-Z0-9]+)/u", $video->getVideodescription(), $matches);

                    $hashtags = array_unique($matches[0]);
                    foreach ($hashtags as $hs) {
                        $hashtag = new Hashtag((int)$id, $hs);
                        $this->hashtagMapper->save($hashtag);
                    }

                    $queryString = "username=" . $_SESSION["currentuser"];
                    $this->view->redirect("user", "view", $queryString);
                } else {
                    $this->view->redirect("home", "index");
                }

            }

        } else {
            $this->view->redirect("home", "index");
        }


    }

    public function delete()
    {
        if (isset($_POST["id"])) {

            $video = $this->videoMapper->findById($_POST["id"]);

            if ($video != null && $video->getAuthor() === $_SESSION["currentuser"]) {
                $this->videoMapper->delete($video);
                $this->view->redirect("home", "index");
            } else {
                $this->view->redirectToReferer();
            }
        } else {
            $this->view->redirectToReferer();
        }
    }

    public function view()
    {

        if (isset($_GET["id"])) {

            $video = $this->videoMapper->findById($_GET["id"]);

            if ($video === null) {
                $this->view->redirectToReferer();
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
            $this->view->redirectToReferer();
        }


    }

    public function search()
    {
        if (isset($_GET["hashtag"])) {

            $nVideos = $this->videoMapper->countVideosByHashtag("#" . $_GET["hashtag"]);
            $nPags = ceil($nVideos / 6);
            $page = 0;
            if (isset($_GET["page"])) {
                if (preg_match('/^[0-9]+$/', $_GET["page"]) && ($temp = (int)$_GET["page"]) < $nPags) {
                    $page = $temp;
                } else {
                    $this->view->redirectToReferer();
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

            $this->view->render("video", "search");

        } else {
            $this->view->redirectToReferer();
        }
    }


}