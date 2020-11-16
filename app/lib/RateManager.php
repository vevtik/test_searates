<?php

namespace app\lib;

use app\entity\Port;
use app\entity\Rate;
use app\parser\ParserInterface;
use app\repository\PortRepository;
use app\repository\RateRepository;
use \InvalidArgumentException;

class RateManager
{
    public function getByRoute(string $route): array
    {
        try {
            list($portFrom, $portTo) = $this->getRoutePorts($route);

        } catch (InvalidArgumentException $e) {
            return [];
        }

        return $this->getByPorts($portFrom, $portTo);
    }

    /**
     * @param Port $portFrom
     * @param Port $portTo
     *
     * @return array | Port[]
     */
    public function getByPorts(Port $portFrom, Port $portTo): array
    {
        $rates = new RateRepository();

        return $rates->getBy([
            'port_from' => $portFrom->getLocode(),
            'port_to' => $portTo->getLocode(),
        ]);
    }

    public function parseRates(ParserInterface $parser, Port $portFrom, Port $portTo)
    {
        $result = $parser->getRates($portFrom, $portTo);
        $this->saveRates($result);

        return $result;
    }

    /**
     * @param array | Rate[] $data
     */
    public function saveRates(array $data): void
    {
        if (empty($data)) {
            return;
        }
        $repository = new RateRepository();
        $repository->multipleInsert($data);
    }

    /**
     * @param string $route
     *
     * @return Port[]
     */
    public function getRoutePorts(string $route): array
    {
        if (!preg_match('#^([A-Z]{5})-([A-Z]{5})$#', $route, $matches)) {
            throw new InvalidArgumentException('Route format don\'t match.');
        }
        $ports = new PortRepository();
        $portFrom = $ports->getOneBy(['locode'=>$matches[1]]);
        if (empty($portFrom)) {
            throw new InvalidArgumentException('Sender port not found');
        }
        /**
         * @var Port $portFrom
         * @var Port $portTo
         */
        $portTo = $ports->getOneBy(['locode'=>$matches[2]]);
        if (empty($portTo)) {
            throw new InvalidArgumentException('Destination port not found');
        }

        return [$portFrom, $portTo];
    }
}
