<?php
namespace app\repository;

use app\entity\Country;

class CountryRepository extends EntityRepository
{
    protected string $entityClass = Country::class;
    protected string  $tableName = 'countries';
}
