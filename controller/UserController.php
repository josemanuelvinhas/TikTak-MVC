<?php
//file: controller/UserController.php

require_once(__DIR__ . "/../model/User.php");
require_once(__DIR__ . "/../model/UserMapper.php");

require_once(__DIR__ . "/../model/VideoMapper.php");
require_once(__DIR__ . "/../model/LikeMapper.php");
require_once(__DIR__ . "/../model/FollowerMapper.php");
require_once(__DIR__ . "/../model/HashtagMapper.php");

require_once(__DIR__ . "/../core/ViewManager.php");
require_once(__DIR__ . "/../controller/BaseController.php");

class UserController extends BaseController
{

    private $videoMapper;
    private $userMapper;
    private $likeMapper;
    private $followerMapper;
    private $hashtagMapper;

    public function __construct()
    {
        parent::__construct();

        $this->videoMapper = new VideoMapper();
        $this->userMapper = new UserMapper();
        $this->likeMapper = new LikeMapper();
        $this->followerMapper = new FollowerMapper();
        $this->hashtagMapper = new HashtagMapper();

    }

    public function view()
    {
        if (!isset($_GET["username"])) {
            $this->view->redirect("home", "index");
        }
        $userid = $_GET["username"];

        if (isset($this->currentUser)) {
            $isFollowing = $this->followerMapper->isFollowing($_SESSION["currentuser"], $userid);
            $this->view->setVariable("isFollowing", $isFollowing);
        }

        $videos = $this->videoMapper->findAllByAuthor($userid);
        $user = $this->userMapper->findByUsername($userid);

        $this->view->setVariable("videos", $videos);
        $this->view->setVariable("usuario", $user);


        $this->view->render("user", "view");
    }

    public function home()
    {
        if (!isset($_SESSION["currentuser"])) {
            $this->view->redirect("home", "index");
        }

        $user = $this->userMapper->findByUsername($_SESSION["currentuser"]);
        if ((int)$user->getNfollowings() > 0) {
            $nVideos = $this->videoMapper->countVideosByFollower($_SESSION["currentuser"]);
        } else {
            $nVideos = $this->videoMapper->countVideos();
        }


        $nPags = ceil($nVideos / 6);

        $page = 0;

        if (isset($_GET["page"])) {
            if (preg_match('/^[0-9]+$/', $_GET["page"]) && ($temp = (int)$_GET["page"]) < $nPags) {
                $page = $temp;
            } else {
                $this->view->redirect("user", "home");
            }
        }


        $idLikes = $this->likeMapper->findByUsername($_SESSION["currentuser"]);
        $this->view->setVariable("idLikes", $idLikes);

        $followers = $this->followerMapper->findFollowingByUsername($_SESSION["currentuser"]);
        $this->view->setVariable("followers", $followers);

        if ((int)$user->getNfollowings() > 0) {
            $videos = $this->videoMapper->findAllByFollower($_SESSION["currentuser"], $page);
        } else {
            $videos = $this->videoMapper->findAll($page);
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

        // put the array containing Video object to the view
        $this->view->setVariable("videos", $videos);

        $topUsuarios = $this->userMapper->findTop5ByFollowers();
        $this->view->setVariable("topUsuarios", $topUsuarios);
        $trends = $this->hashtagMapper->findTop5Hashtag();
        $this->view->setVariable("trends", $trends);


        // render the view (/view/posts/index.php)

        $this->view->render("user", "home");


    }

    public function login()
    {
        $user = new User();

        if (isset($_POST["username"])) {
            $user->setUsername($_POST["username"]);
            $user->setPasswd($_POST["passwd"]);
            try {
                $user->checkIsValidForLogin();

                if ($this->userMapper->isValidUser($_POST["username"], $_POST["passwd"])) {

                    $_SESSION["currentuser"] = $_POST["username"];

                    // send user to the restricted area (HTTP 302 code)

                    $this->view->redirect("user", "home");

                } else {
                    $errors = array();
                    $errors["general"] = "Invalid credentials";
                    $this->view->setVariable("errors_log", $errors);
                }

            } catch (ValidationException $ex) {
                $errors = $ex->getErrors();
                $this->view->setVariable("errors_log", $errors);
            }
        }

        $nVideos = $this->videoMapper->countVideos();
        $nPags = ceil($nVideos / 6);
        $videos = $this->videoMapper->findAll(0);
        if ($nPags > 1) {
            $this->view->setVariable("next", 1);
        }
        $this->view->setVariable("page", 0);
        $this->view->setVariable("videos", $videos);

        $topUsuarios = $this->userMapper->findTop5ByFollowers();
        $this->view->setVariable("topUsuarios", $topUsuarios);
        $trends = $this->hashtagMapper->findTop5Hashtag();
        $this->view->setVariable("trends", $trends);

        $this->view->setVariable("user", $user);
        $this->view->render("user", "login");

    }

    public function register()
    {
        $user = new User();

        if (isset($_POST["username"])) {
            $user->setUsername($_POST["username"]);
            $user->setEmail($_POST["email"]);
            $user->setPasswd($_POST["passwd"]);

            try {
                $user->checkIsValidForRegister();


                $usernameExists = $this->userMapper->usernameExists($_POST["username"]);
                $emailExists = $this->userMapper->emailExists($_POST["email"]);


                if (!$usernameExists & !$emailExists) {
                    $this->userMapper->save($user);

                    $this->view->redirect("user", "login");

                } else {
                    $errors = array();
                    if ($usernameExists) {
                        $errors["username"] = "Username already exists";
                    }
                    if ($emailExists) {
                        $errors["email"] = "Email already exists";
                    }
                    $this->view->setVariable("errors_reg", $errors);
                }

            } catch (ValidationException $ex) {
                $errors = $ex->getErrors();
                $this->view->setVariable("errors_reg", $errors);
            }
        }

        $nVideos = $this->videoMapper->countVideos();
        $nPags = ceil($nVideos / 6);
        $videos = $this->videoMapper->findAll(0);
        if ($nPags > 1) {
            $this->view->setVariable("next", 1);
        }
        $this->view->setVariable("page", 0);
        $this->view->setVariable("videos", $videos);

        $topUsuarios = $this->userMapper->findTop5ByFollowers();
        $this->view->setVariable("topUsuarios", $topUsuarios);

        $trends = $this->hashtagMapper->findTop5Hashtag();
        $this->view->setVariable("trends", $trends);

        $this->view->setVariable("user", $user);
        $this->view->render("user", "register");

    }

    public function logout()
    {
        session_destroy();
        if (isset($_SERVER["HTTP_REFERER"])) {
            $this->view->redirectToReferer();
        } else {
            $this->view->redirect("home", "index");
        }

    }
}