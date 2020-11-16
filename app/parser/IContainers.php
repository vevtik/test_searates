<?php

namespace app\parser;

use app\entity\Port;
use app\entity\Rate;
use GuzzleHttp\Client;
use GuzzleHttp\RequestOptions;

class IContainers implements ParserInterface
{
    private static ?string $token;
    private Client $client;

    public function __construct()
    {
        $this->client = new Client();
    }

    /**
     * @param Port $from
     * @param Port $to
     *
     * @return array | Rate
     */
    public function getRates(Port $from, Port $to): array
    {
        $token = $this->getToken();
        if (empty($token)) {
            return [];
        }
        $containers = ['DV20', 'DV40', 'DV40HC'];
        $data = [
            'containers' => [
                ['quantity' => 1]
            ],
            'currency' => 'USD',
            'destination' => $this->getPortData($to),
            'lang' => 'en_US',
            'origin' => $this->getPortData($from),
            'type' => 'FCL'
        ];
        $result = [[]];
        foreach ($containers as $type) {
            $data['containers'][0]['type'] = $type;
            $result[] = $this->parseRateResponse(
                $this->getRatesRequest($data)
            );
        }

        return array_merge(...$result);
    }

    private function getRatesRequest(array $data)
    {
        $response = $this->client->post(
            'https://easy-booking.icontainers.com/api/v1/quotes/fcl/rates',
            [
                RequestOptions::JSON => $data,
                'headers' => [
                    'authorization' => 'Bearer ' . self::$token
                ]

            ]
        );

        return json_decode($response->getBody(), true);
    }

    /**
     * @param array $data
     * @return array | Rate[]
     */
    private function parseRateResponse(array $data): array
    {
        $rateData = array_filter([
            'port_from' => $data['data']['origin']['custom_code'] ?? null,
            'port_to' => $data['data']['destination']['custom_code'] ?? null,
            'container_type' => $data['data']['items'][0]['type'] ?? null,
            'currency' => 'USD'
        ]);
        $rates = $data['data']['rates'] ?? [];
        $result = [];
        foreach ($rates as $item) {
            $billingItems = $item['billing_items'] ?? [];
            foreach ($billingItems as $rate) {
                $name = $rate['name'] ?? null;
                if ('Ocean Freight' === $name) {
                    $rateData['rate'] = $rate['price']['total'];
                    $result[] = new Rate($rateData);
                }
            }
        }

        return $result;
    }

    private function getToken()
    {
        if (empty(self::$token)) {
            $data = [
                'login' => ICONTEINERS_LOGIN,
                'password' => ICONTEINERS_PASS,
            ];
            $response = $this->client->post(
                'https://easy-booking.icontainers.com/api/v1/auth/customers/login',
                [
                    RequestOptions::JSON => $data
                ]
            );
            $response = json_decode($response->getBody(), true);
            self::$token = $response['data']['jwt'] ?? null;
        }

        return self::$token;
    }

    private function getPortData(Port $port): array
    {
        return [
            'country_iso_code' => $port->getCountry(),
            'custom_code' => $port->getLocode(),
            'type' => 'PORT'
        ];
    }
}
