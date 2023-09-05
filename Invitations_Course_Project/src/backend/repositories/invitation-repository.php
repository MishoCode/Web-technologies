<?php
require_once '../database/config.php';
require_once '../mappers/user-mapper.php';
require_once '../mappers/invitation-mapper.php';

class InvitationRepository
{
    private $db;

    public function __construct()
    {
        $this->db = new Database();
    }

    public function createInvitation($title, $place, $date, $time, $endTime, $presenter_fn, $filename)
    {
        $query = "INSERT INTO invitations(title, place, date, time, end_time, presenter_fn, filename)\n" .
            "VALUES (:title, :place, :date, :time, :end_time, :presenter_fn, :filename)";

        $params = [
            "title" => $title,
            "place" => $place,
            "date" => $date,
            "time" => $time,
            "end_time" => $endTime,
            "presenter_fn" => $presenter_fn,
        ];

        if ($filename !== '') {
            $params["filename"] = $filename;
        } else {
            $params["filename"] = 'NULL';
        }

        return $this->db->executeQuery($query, $params);
    }

    public function findInvitationByTitle($title)
    {
        $query = "SELECT * FROM invitations WHERE title=:title";
        $params = ["title" => $title];

        $invitation = $this->db->executeQuery($query, $params)->fetch(PDO::FETCH_ASSOC);
        return $invitation;
    }

    public function getAllInvitations()
    {
        $query = "SELECT * FROM invitations INNER JOIN users ON fn = presenter_fn ORDER BY date, time";
        $rows = $this->db->executeQuery($query)->fetchAll();

        return array_map(array('InvitationMapper', 'toModel'), $rows);
    }

    public function getUpcomingInvitations()
    {
        $query = "SELECT * FROM invitations INNER JOIN users ON fn = presenter_fn WHERE date>=CURDATE() ORDER BY date, time";
        $rows = $this->db->executeQuery($query)->fetchAll();

        return array_map(array('InvitationMapper', 'toModel'), $rows);
    }
    public function findInvitationByDateAndTime($date, $time)
    {
        $query = "SELECT * FROM invitations WHERE date=:date AND :time>=time AND :time<end_time";
        $params = ["date" => $date, "time" => $time];

        $invitation = $this->db->executeQuery($query, $params)->fetch();
        return $invitation;
    }

    public function findInvitationByPresenter($presenter_fn)
    {
        $query = "SELECT * FROM invitations WHERE presenter_fn=:presenter_fn";
        $params = ["presenter_fn" => $presenter_fn];

        $invitation = $this->db->executeQuery($query, $params)->fetch();
        return $invitation;
    }

    public function deleteInvitationByPresenter($presenter_fn)
    {
        $query = "DELETE FROM invitations WHERE presenter_fn=:presenter_fn";
        $params = ["presenter_fn" => $presenter_fn];

        return $this->db->executeQuery($query, $params);
    }
}

?>