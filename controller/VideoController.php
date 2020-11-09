<?php

require_once(__DIR__ . "/../model/Video.php");
require_once(__DIR__ . "/../model/VideoMapper.php");

require_once(__DIR__ . "/../model/Hashtag.php");
require_once(__DIR__ . "/../model/HashtagMapper.php");

require_once(__DIR__ . "/../core/ViewManager.php");
require_once(__DIR__ . "/../controller/BaseController.php");

class VideoController extends BaseController
{

    private $videoMapper;
    private $hashtagMapper;

    public function __construct()
    {
        parent::__construct();

        $this->videoMapper = new VideoMapper();
        $this->hashtagMapper = new HashtagMapper();
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
                        $hashtag = new Hashtag((int) $id, $hs);
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

    public function view(){



    }


}