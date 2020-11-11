<?php
require_once(__DIR__ . "/../core/ValidationException.php");

class Video
{

    /**
     * The id of this post
     * id	videoname	videodescription
     * 	videodate	author	nlikes
     * @var int
     */
    private $id;
    private $videoname;
    private $videodescription;
    private $videodate;
    private $author;
    private $nlikes;

    /**
     * The constructor
     *
     * @param int $id
     * @param string $videoname
     * @param string $videodescription
     * @param Date $videodate
     * @param String $author
     * @param int $nlikes
     */

    public function __construct($id=NULL, $videoname=NULL,$videodescription=NULL,$videodate=NULL,$author=NULL,$nlikes=NULL) {
        $this->id = $id;
        $this->videoname = $videoname;
        $this->videodescription = $videodescription;
        $this->videodate = $videodate;
        $this->author = $author;
        $this->nlikes = $nlikes;

    }



    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param int $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return string|null
     */
    public function getVideoname()
    {
        return $this->videoname;
    }

    /**
     * @param string|null $videoname
     */
    public function setVideoname($videoname)
    {
        $this->videoname = $videoname;
    }

    /**
     * @return string|null
     */
    public function getVideodescription()
    {
        return $this->videodescription;
    }

    /**
     * @param string|null $videodescription
     */
    public function setVideodescription($videodescription)
    {
        $this->videodescription = $videodescription;
    }

    /**
     * @return Date|null
     */
    public function getVideodate()
    {
        return $this->videodate;
    }

    /**
     * @param Date|null $videodate
     */
    public function setVideodate($videodate)
    {
        $this->videodate = $videodate;
    }

    /**
     * @return String|null
     */
    public function getAuthor()
    {
        return $this->author;
    }

    /**
     * @param String|null $author
     */
    public function setAuthor($author)
    {
        $this->author = $author;
    }

    /**
     * @return int|null
     */
    public function getNlikes()
    {
        return $this->nlikes;
    }

    /**
     * @param int|null $nlikes
     */
    public function setNlikes($nlikes)
    {
        $this->nlikes = $nlikes;
    }

    public function checkIsValidForUpload()
    {
        $errors = array();

        $tempErr = $this->checkDescription();
        if (!empty($tempErr)) {
            $errors["videodescription"] = $tempErr;
        }

        if (sizeof($errors) > 0) {
            throw new ValidationException($errors, "video is not valid");
        }
    }

    private function checkDescription()
    {
        $var = $this->getVideodescription();
        $message = "Insert between 0 and 320 numbers, letters or #";
        $pattern = "/^[a-zA-Z0-9À-ÿñÑ #]{0,320}$/";

        $errors = array();
        if (!preg_match($pattern, $var)) {
            array_push($errors, $message);
        }
        return $errors;
    }


}