<?php
require_once '../database/config.php';
require_once '../mappers/user-mapper.php';

class UserRepository
{

    private $db;

    public function __construct()
    {
        $this->db = new Database();
    }
    public function getAllUsers()
    {
        $query = "SELECT * FROM users";
        $rows = $this->db->executeQuery($query)->fetchAll();

        return array_map(array('UserMapper', 'toModel'), $rows);
    }

    public function findUserByFn($fn) {
        $query = "SELECT * FROM users WHERE fn=:fn";
        $params = ["fn" => $fn];

        $user = $this->db->executeQuery($query, $params)->fetch();
        return $user;
    }

    public function findUserByEmail($email) {
        $query = "SELECT * FROM users WHERE email=:email";
        $params = ["email" => $email];

        $user = $this->db->executeQuery($query, $params)->fetch(PDO::FETCH_ASSOC);
        return $user;
    }

    public function addUser($fn, $password, $email, $first_name, $last_name, $course, $specialty)
    {
        $query = "INSERT INTO users(fn, password, email, first_name, last_name, course, specialty)\n" .
            "VALUES (:fn, :password, :email, :first_name, :last_name, :course, :specialty)";


        $params = [
            "fn" => $fn,
            "password" => $password,
            "email" => $email,
            "first_name" => $first_name,
            "last_name" => $last_name,
            "course" => $course,
            "specialty" => $specialty
        ];

        return $this->db->executeQuery($query, $params);
    }
}

?>