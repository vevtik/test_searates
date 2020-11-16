<?php
namespace app\repository;

use app\db\DBFactory;
use app\entity\Rate;

class RateRepository extends EntityRepository
{
    protected string $entityClass = Rate::class;
    protected string  $tableName = 'rates';

    public function updateRate(Rate $rate): void
    {
        $db = DBFactory::getInstance();
        $db->query(
            "UPDATE {$this->tableName} SET rate=:rate, currency=:currency WHERE id=:id",
            [
                'rate' => sprintf('%1.2f', $rate->getRate()),
                'currency' => $rate->getCurrency(),
                'id' => $rate->getId()
            ]
        );
    }
}
