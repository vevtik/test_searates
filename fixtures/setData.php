<?php
use app\entity\Country;
use app\entity\Port;
use app\repository\CountryRepository;
use app\repository\PortRepository;

require_once __DIR__ . '/../app/boot.php';

$input = file(__DIR__ . '/port.txt');
$countries = [];
$ports = [];
foreach ($input as $item) {
    if (preg_match('#^(.*)\s([A-Z]{2})\s([A-Z]{3})\s([A-Z]{5})\s(.*)$#isU', $item, $matches)) {
        list($all, $countryName, $countryCode, $portCode, $locode, $portName) = $matches;
        if (!isset($countries[$countryCode])) {
            $countries[$countryCode] = new Country();
            $countries[$countryCode]->setAlpha2($countryCode)
                ->setName($countryName);
        }
        $port = new Port();
        $port->setLocode($locode)
            ->setCountry($countryCode)
            ->setPortCode($portCode)
            ->setName($portName);
        $ports[] = $port;
    } else {
        echo $item;
    }
}
$countryR = new CountryRepository();
$countryR->multipleInsert($countries);

$portR = new PortRepository();
$portR->multipleInsert($ports);
