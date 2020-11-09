<?php


class Like
{


    private $id;
    private $username;


    /**
     * The constructor
     *
     * @param int $id
     * @param string $username

     */

    public function __construct($id=NULL, $username=NULL) {
        $this->id = $id;
        $this->username = $username;
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
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * @param string|null $username
     */
    public function setUsername($username)
    {
        $this->username = $username;
    }

    public function checkIsValidForCreate() {
        //Falta
    }


}
