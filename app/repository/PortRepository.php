<?php
namespace app\repository;

use app\entity\Port;

class PortRepository extends EntityRepository
{
    protected string $entityClass = Port::class;
    protected string  $tableName = 'ports';
}
