<?php

declare(strict_types=1);

final class Database
{
    private mysqli $mysqli;

    public function __construct()
    {
        $parameters = include(__DIR__.'/../config/parameters.php');

        $this->mysqli = new \mysqli(
            $parameters['db_server'],
            $parameters['db_user'],
            $parameters['db_pass'],
            $parameters['db_name']
        );

        if ($this->mysqli->connect_errno) {
            echo "Failed to connect to MySQL: " . $this->mysqli->connect_error;
        }
        $this->mysqli->set_charset("utf8");
    }

    function saveRequestToDatabase(string $ip, array $words): void
    {
        $ipLong = ip2long($ip);

        $userId = $this->findOrAddUser($ipLong);
        $this->saveWords($userId, $words);
    }

    private function findOrAddUser(int $ip): int
    {
       $userId = $this->findUser($ip);

        if(!$userId){
           $userId = $this->addUser($ip);
        }

        return $userId;
    }

    public function addUser(int $ip): int
    {
        $stmt = $this->mysqli->prepare("INSERT INTO users (ip) VALUES (?)");
        $stmt->bind_param("i", $ip);
        if (!$stmt->execute()) {
            throw new \Exception($stmt->error);
        }

        return $stmt->insert_id;
    }

    private function findUser(int $ip): ?int
    {
        $stmt = $this->mysqli->prepare("SELECT id FROM users WHERE ip = ?");
        $stmt->bind_param("s", $ip);
        if (!$stmt->execute()) {
            throw new \Exception($stmt->error);
        }
        $stmt->bind_result($user_id);
        $stmt->fetch();

        return $user_id;
    }

    //todo multi insert
    private function saveWords(int $userId, array $words)
    {
        foreach ($words as $word){
            $stmt = $this->mysqli->prepare("INSERT INTO words (user_id, word, count) VALUES (?,?,?)");
            $stmt->bind_param("isi", $userId,$word['word'], $word['count']);
            if (!$stmt->execute()) {
                throw new \Exception($stmt->error);
            }
        }
    }
}
