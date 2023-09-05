<?php

require_once '../database/config.php';
require_once '../mappers/user-mapper.php';
require_once '../mappers/like-mapper.php';

class LikeRepository {
    private $db;

    public function __construct() {
        $this->db = new Database();
    }

    public function createLike($fn, $invitation_id) {
        $query = "INSERT INTO likes(fn, invitation_id)\n" .
            "VALUES (:fn, :invitation_id)";

        $params = ["fn" => $fn, "invitation_id" => $invitation_id];

        return $this->db->executeQuery($query, $params);
    }

    public function findLike($fn, $invitation_id) {
        $query = "SELECT * FROM likes WHERE fn=:fn AND invitation_id=:invitation_id";
        $params = ["fn" => $fn, "invitation_id" => $invitation_id];

        $like = $this->db->executeQuery($query, $params)->fetch();
        return $like;
    }

    public function getAllLikes() {
        $query = "SELECT * FROM likes INNER JOIN users ON likes.fn=users.fn INNER JOIN invitations ON invitations.id=likes.invitation_id";
        $rows = $this->db->executeQuery($query)->fetchAll();

        return array_map(array('LikeMapper', 'toModel'), $rows);
    }
}

?>