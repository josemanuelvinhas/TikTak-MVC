<?php

require_once(__DIR__ . "/../model/Like.php");
require_once(__DIR__ . "/../model/LikeMapper.php");

require_once(__DIR__ . "/../core/ViewManager.php");
require_once(__DIR__ . "/../controller/BaseController.php");

class LikeController extends BaseController
{

    private $likeMapper;

    public function __construct()
    {
        parent::__construct();

        $this->likeMapper = new LikeMapper();
    }

    public function like()
    {

        if(isset($_POST["username"]) & isset($_POST["id"])){
            $like = new Like($_POST["id"],$_POST["username"]);
            $this->likeMapper->save($like);
        }

        $this->view->redirect("home", "index");
    }

    public function dislike()
    {

        if(isset($_POST["username"]) & isset($_POST["id"])){
            $like = new Like($_POST["id"],$_POST["username"]);
            $this->likeMapper->delete($like);
        }

        $this->view->redirect("home", "index");
    }

}