<?php

require_once(__DIR__ . "/../model/Follower.php");
require_once(__DIR__ . "/../model/FollowerMapper.php");

require_once(__DIR__ . "/../core/ViewManager.php");
require_once(__DIR__ . "/../controller/BaseController.php");

class FollowerController extends BaseController
{

    private $followerMapper;

    public function __construct()
    {
        parent::__construct();

        $this->followerMapper = new FollowerMapper();
    }

    public function follow()
    {
        if (isset($_POST["username"])) {
            $follower = new Follower($_SESSION["currentuser"], $_POST["username"]);
            $this->followerMapper->save($follower);
        }

        $this->view->redirect("home", "index");
    }

    public function unfollow()
    {
        if (isset($_POST["username"])) {
            $follower = new Follower($_SESSION["currentuser"], $_POST["username"]);
            $this->followerMapper->delete($follower);
        }

        $this->view->redirect("home", "index");
    }

}