<?php

namespace app\db;

use \PDO;
use \PDOStatement;

class MySQL implements DBAdapterInterface
{
    private PDO $connection;

    public function connect(string $host, string $port, string $user, string $pass, string $dbName): void
    {
        $this->connection = new PDO(
            sprintf('mysql:dbname=%s;host=%s;port=%s', $dbName, $host, $port),
            $user,
            $pass
        );
    }

    public function query(string $sql, array $parameters = []): void
    {
        $this->execute($sql, $parameters);
    }

    public function fetchAll(string $sql, array $parameters = []): array
    {
        $stmt = $this->execute($sql, $parameters);
        $res = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return $res ?? [];
    }

    public function fetchOne(string $sql, array $parameters = []): array
    {
        $res = $this->fetchAll($sql, $parameters);

        return $res[0] ?? [];
    }

    private function execute(string $sql, array $parameters = []): PDOStatement
    {
        $stmt = $this->connection->prepare($sql);
        foreach ($parameters as $key => $value) {
            $stmt->bindParam($key, $value);
        }
        $stmt->execute($parameters);

        return $stmt;
    }

    public function quote(string $value): string
    {
        return $this->connection->quote($value);
    }
}
