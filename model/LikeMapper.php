<?php
require_once(__DIR__ . "/../core/PDOConnection.php");


require_once(__DIR__ . "/../model/Like.php");


class LikeMapper
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

    public function findByUsername($username)
    {
        $stmt = $this->db->prepare("SELECT id FROM likes WHERE username=?");
        $stmt->execute(array($username));
        return $stmt->fetchAll(PDO::FETCH_COLUMN);

    }

    public function save($like)
    {
        $stmt = $this->db->prepare("INSERT INTO likes(id,username) values (?,?)");
        $stmt->execute(array($like->getId(), $like->getUsername()));
        return $this->db->lastInsertId();
    }

    public function delete($like)
    {
        $stmt = $this->db->prepare("DELETE from likes WHERE id=? AND username=?");
        $stmt->execute(array($like->getId(), $like->getUsername()));
    }

}