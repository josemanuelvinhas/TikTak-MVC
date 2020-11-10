<?php
require_once(__DIR__ . "/../core/PDOConnection.php");


require_once(__DIR__ . "/../model/Video.php");


class VideoMapper
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

    public function findAll($pagina = 0, $per_page = 6)
    {
        $stmt = $this->db->prepare("SELECT * FROM videos ORDER BY videos.videodate DESC LIMIT ?,?");
        $offset = $pagina * $per_page;
        $stmt->execute(array($offset,$per_page));
        $videos_db = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $videos = array();

        foreach ($videos_db as $vi) {
            array_push($videos, new Video($vi["id"], $vi["videoname"], $vi["videodescription"], $vi["videodate"], $vi["author"], $vi["nlikes"]));
        }

        return $videos;
    }

    public function countVideos(){
        $stmt = $this->db->query("SELECT COUNT(id) FROM videos");
        return $stmt->fetchColumn();
    }

    public function findById($videoid)
    {
        $stmt = $this->db->prepare("SELECT * FROM videos WHERE id=?");
        $stmt->execute(array($videoid));
        $videos = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($videos != null) {
            return new Video(
                $videos["id"],
                $videos["videoname"],
                $videos["videodescription"],
                $videos["videodate"],
                $videos["author"],
                $videos["nlikes"]);
        } else {
            return null;
        }
    }

    public function findAllByFollower($follower, $pagina = 0, $per_page = 6){
        $stmt = $this->db->prepare("SELECT videos.id, videos.videoname, videos.videodescription, videos.videodate, videos.author, videos.nlikes FROM videos, followers WHERE followers.username_follower = ? AND followers.username_following=videos.author ORDER BY videos.videodate DESC LIMIT ?,?");
        $offset = $pagina * $per_page;
        $stmt->execute(array($follower,$offset,$per_page));
        $videos_db = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $videos = array();

        foreach ($videos_db as $vi) {
            array_push($videos, new Video($vi["id"], $vi["videoname"], $vi["videodescription"], $vi["videodate"], $vi["author"], $vi["nlikes"]));
        }

        return $videos;
    }

    public function findAllByHashtag($hashtag, $pagina = 0, $per_page = 6){
        $stmt = $this->db->prepare("SELECT videos.id, videos.videoname, videos.videodescription, videos.videodate, videos.author, videos.nlikes FROM videos, hashtags WHERE hashtags.hashtag = ? AND hashtags.id=videos.id ORDER BY videos.videodate DESC LIMIT ?,?");
        $offset = $pagina * $per_page;
        $stmt->execute(array($hashtag,$offset,$per_page));
        $videos_db = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $videos = array();

        foreach ($videos_db as $vi) {
            array_push($videos, new Video($vi["id"], $vi["videoname"], $vi["videodescription"], $vi["videodate"], $vi["author"], $vi["nlikes"]));
        }

        return $videos;
    }

    public function countVideosByFollower($follower){
        $stmt = $this->db->prepare("SELECT COUNT(videos.id) FROM videos, followers WHERE followers.username_follower = ? AND followers.username_following=videos.author");
        $stmt->execute(array($follower));
        return $stmt->fetchColumn();
    }

    public function countVideosByHashtag($hashtag){
        $stmt = $this->db->prepare("SELECT COUNT(videos.id) FROM videos, hashtags WHERE hashtags.hashtag = ? AND hashtags.id=videos.id");
        $stmt->execute(array($hashtag));
        return $stmt->fetchColumn();
    }


    public function findAllByAuthor($author)
    {
        $stmt = $this->db->prepare("SELECT * FROM videos WHERE author=?");
        $stmt->execute(array($author));
        $videos_db = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $videos = array();

        foreach ($videos_db as $vi) {
            array_push($videos, new Video($vi["id"], $vi["videoname"], $vi["videodescription"], $vi["videodate"], $vi["author"], $vi["nlikes"]));
        }

        return $videos;
    }

    public function save($video)
    {
        $stmt = $this->db->prepare("INSERT INTO videos(videoname, videodescription,author) values (?,?,?)");
        $stmt->execute(array($video->getVideoname(), $video->getVideodescription(), $video->getAuthor()));

        return $this->db->lastInsertId("id");
    }

    public function delete($video)
    {
        $stmt = $this->db->prepare("DELETE from videos WHERE id=?");
        $stmt->execute(array($video->getId()));
    }

}