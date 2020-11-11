<?php
//file: controller/PostController.php

require_once(__DIR__ . "/../model/Video.php");
require_once(__DIR__ . "/../model/VideoMapper.php");
require_once(__DIR__ . "/../model/LikeMapper.php");
require_once(__DIR__ . "/../model/FollowerMapper.php");

require_once(__DIR__ . "/../model/UserMapper.php");
require_once(__DIR__ . "/../model/HashtagMapper.php");

require_once(__DIR__ . "/../core/ViewManager.php");
require_once(__DIR__ . "/../controller/BaseController.php");

/**
 * Class PostsController
 *
 * Controller to make a CRUDL of Posts entities
 *
 * @author lipido <lipido@gmail.com>
 */
class HomeController extends BaseController
{

    /**
     * Reference to the VideoMapper to interact
     * with the database
     *
     * @var VideoMapper
     */
    private $videoMapper;
    private $likeMapper;
    private $followerMapper;
    private $userMapper;
    private $hashtagMapper;

    public function __construct()
    {
        parent::__construct();

        $this->userMapper = new UserMapper();
        $this->hashtagMapper = new HashtagMapper();
        $this->videoMapper = new VideoMapper();
        $this->likeMapper = new LikeMapper();
        $this->followerMapper = new FollowerMapper();
    }

    public function index()
    {
        $nVideos = $this->videoMapper->countVideos();
        $nPags = ceil($nVideos / 6);

        $page = 0;

        if (isset($_GET["page"])) {
            if (preg_match('/^[0-9]+$/', $_GET["page"]) && ($temp = (int)$_GET["page"]) < $nPags) {
                $page = $temp;
            } else {
                $this->view->redirect("home", "index");
            }
        }

        $videos = $this->videoMapper->findAll($page);


        if (isset($this->currentUser)) {
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

        $topUsuarios = $this->userMapper->findTop5ByFollowers();
        $this->view->setVariable("topUsuarios", $topUsuarios);
        $trends = $this->hashtagMapper->findTop5Hashtag();
        $this->view->setVariable("trends", $trends);

        // put the array containing Video object to the view
        $this->view->setVariable("videos", $videos);


        // render the view (/view/posts/index.php)

        $this->view->render("home", "index");
    }


}
