<?php
class Database
{
    private $connection;

    public function __construct()
    {
        $ini_array = parse_ini_file('../../config/config.ini');

        $type = $ini_array['type'];
        $host = $ini_array['host'];
        $name = $ini_array['name'];
        $user = $ini_array['user'];
        $password = $ini_array['password'];

        try {
            $this->connection = new PDO(
                "$type:host=$host;dbname=$name;charset=utf8",
                $user,
                $password,
            );



        } catch (PDOException $e) {
            echo "Connection failed: " . $e->getMessage();
        }
    }

    public function getConnection()
    {
        return $this->connection;
    }

    public function executeQuery($query, array $params = [])
    {
        $statement = $this->connection->prepare($query);

        try {
            $this->connection->beginTransaction();
            $statement->execute($params);
            $this->connection->commit();
        } catch (PDOException $e) {
            $this->connection->rollBack();
            throw $e;
        }

        return $statement;
    }
}

?>