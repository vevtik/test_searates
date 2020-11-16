<?php

namespace app\db;

interface DBAdapterInterface
{
    public function connect(string $host, string $port, string $user, string $pass, string $dbName): void;
    public function fetchAll(string $sql, array $parameters = []): array;
    public function fetchOne(string $sql, array $parameters = []): array;
    public function query(string $sql, array $parameters = []): void;
    public function quote(string $value): string;
}
