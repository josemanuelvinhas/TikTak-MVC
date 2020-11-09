<?php


class Hashtag
{


    private $id;
    private $hashtag;

    public function __construct($id=NULL, $hashtag=NULL) {
        $this->id = $id;
        $this->hashtag = $hashtag;
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
     * @return mixed|null
     */
    public function getHashtag()
    {
        return $this->hashtag;
    }

    /**
     * @param mixed|null $hashtag
     */
    public function setHashtag($hashtag)
    {
        $this->hashtag = $hashtag;
    }



    public function checkIsValidForCreate() {
        //Falta
    }


}
