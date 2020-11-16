<?php

namespace app\parser;

use app\entity\Port;
use app\entity\Rate;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\RequestOptions;
use Psr\Http\Message\ResponseInterface;

class CmaCgnParser implements ParserInterface
{
    private Client $client;

    public function __construct()
    {
        $this->client = new Client();
    }


    /**
     * @param Port $from
     * @param Port $to
     *
     * @return array | Rate[]
     */
    public function getRates(Port $from, Port $to): array
    {
        try {
            $response = $this->prepare($from, $to);
            if (empty($response['PerfectMatch'])) {
                return [];
            }
            $result = [[]];
            foreach ($response['PerfectMatch'] as $item) {
                $data = [
                    'detailUid' => $item['QuoteLineId'],
                    'pol' => $item['Origin'],
                    'pod' => $item['Destination'],
                    'simulation' => date('Y-m-d'),
                    'equipment' => $item['Equipments']
                ];
                $response = $this->client->post(
                    'https://www.cma-cgm.com/ebusiness/prices-finder/GetChargeDetail',
                    [
                        RequestOptions::JSON => $data
                    ]
                );
                $result[] = $this->parseResponse($response);

            }
            $result = array_merge(...$result);
            array_walk(
                $result,
                static function (Rate $item) use ($from, $to)
                {
                    $item->setPortFrom($from->getLocode())
                        ->setPortTo($to->getLocode());
                }
            );

            return $result;
        } catch (GuzzleException $e) {
            return [];
        }
    }

    /**
     * @param ResponseInterface $response
     * @return array | Rate[]
     */
    private function parseResponse(ResponseInterface $response): array
    {
        $data = json_decode($response->getBody(), true);
        $result = [];
        if (empty($data)) {
            return [];
        }

        foreach ($data as $row) {
            if (!is_array($row)) {
                return [];
            }
            $result[] = $this->parseItem($row);
        }

        return $result;
    }

    private function parseItem(array $item): Rate
    {
        $data = array_filter([
            'container_type' => $item['SizeType'] ?? null,
            'rate' => $item['OceanFreight']['Price']['Amount'] ?? null,
            'currency' => $item['OceanFreight']['Price']['Currency']['Code'] ?? null
        ]);

        return new Rate($data);
    }

    /**
     * @param Port $from
     * @param Port $to
     *
     * @return array
     * @throws GuzzleException
     */
    private function prepare(Port $from, Port $to): array
    {
        $url = sprintf(
            'https://www.cma-cgm.com/ebusiness/prices-finder/GetQuoteLines/ST/%s?%s',
            date('Y-m-d'),
            http_build_query(
                [
                    'pol' => $from->getLocode(),
                    'pod' => $to->getLocode(),
                ]
            )
        );
        $response = $this->client->request('GET', $url);

        return json_decode($response->getBody(), true);
    }
}

