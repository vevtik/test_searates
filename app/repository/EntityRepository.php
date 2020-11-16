<?php

namespace app\repository;

use app\db\DBFactory;
use app\entity\BaseEntity;
use \LogicException;

class EntityRepository
{
    protected string $entityClass;
    protected string  $tableName;

    public function getBy(array $params = []): array
    {
        $db = DBFactory::getInstance();
        $sql = "SELECT * FROM {$this->tableName}";
        if (!empty($params)) {
            $where = [];
            foreach ($params as $key => $value) {
                $where[] = "{$key}=:{$key}";
            }
            $sql .= ' WHERE ' . implode(' AND ', $where);
        }

        $result = $db->fetchAll($sql, $params);
        foreach ($result as $key => $item) {
            $result[$key] = new $this->entityClass($item);
        }

        return $result;
    }

    public function getOneBy(array $params = []):? BaseEntity
    {
        $result = $this->getBy($params);

        return $result[0] ?? null;
    }

    /**
     * @param array | BaseEntity[] $data
     */
    public function multipleInsert(array $data): void
    {
        $db = DBFactory::getInstance();
        list($fields, $values) = $this->getInsertData($data);
        $db->query("INSERT IGNORE INTO {$this->tableName} ({$fields}) VALUES {$values}");
    }

    /**
     * @param array | BaseEntity[] $data
     *
     * @return array
     */
    private function getInsertData(array $data): array
    {
        $db = DBFactory::getInstance();
        $result = [];
        $keys = [];
        foreach ($data as $item) {
            if (!$item instanceof BaseEntity) {
                throw new LogicException("Bad Entity format.");
            }
            $values = $item->toArray();
            if (empty($values['id'])) {
                unset($values['id']);
            }
            if (empty($keys)) {
                $keys = array_keys($values);
            }
            foreach ($values as $key => $value) {
                $values[$key] = $db->quote($value);
            }
            $result[] = '(' . implode(',', $values) . ')';
        }

        return [
            implode(', ', $keys),
            implode(',', $result)
        ];
    }
}

