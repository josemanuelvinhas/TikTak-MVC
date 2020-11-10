<?php
require_once(__DIR__."/../core/PDOConnection.php");


require_once(__DIR__."/../model/Hashtag.php");


class HashtagMapper
{

    /**
     * Reference to the PDO connection
     * @var PDO
     */
    private $db;

    public function __construct()
    {
        $this->db = PDOConnection::getInstance();
    }

    public function save($hashtag) {
        $stmt = $this->db->prepare("INSERT INTO hashtags(id,hashtag) values (?,?)");
        $stmt->execute(array($hashtag->getId(), $hashtag->getHashtag()));
    }

    public function delete($hashtag) {
        $stmt = $this->db->prepare("DELETE from hashtags WHERE id=? AND hashtag=?");
        $stmt->execute(array($hashtag->getId(), $hashtag->getHashtag()));
    }

}