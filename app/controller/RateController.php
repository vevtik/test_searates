<?php

namespace app\controller;

use app\entity\Rate;
use app\lib\RateManager;
use app\lib\Request;
use app\repository\RateRepository;

class RateController
{
    private Request $request;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    public function get(): string
    {
        $route = $this->request->getGet()['route'] ?? 'UAODS-CNSHA';
        $manager = new RateManager();
        $result = $manager->getByRoute($route);

        return $this->prepareResponse($result);
    }

    public function post(): string
    {
        $rate = new Rate(
            json_decode($this->request->getBody(), true)
        );
        $repository = new RateRepository();
        $repository->updateRate($rate);

        return 'OK';
    }

    /**
     * @param array | Rate[] $rates
     * @return string
     */
    private function prepareResponse(array $rates): string
    {
        $result = [];
        foreach ($rates as $item) {
            $result[] = [
                $item->getId(),
                $item->getRoute(),
                $item->getContainerType(),
                $item->getRate(),
                $item->getCurrency()
            ];
        }

        return json_encode($result);
    }
}
