<?php

namespace app\parser;

use app\entity\Port;
use app\entity\Rate;

interface ParserInterface
{
    /**
     * @param Port $from
     * @param Port $to
     *
     * @return array | Rate[]
     */
    public function getRates(Port $from, Port $to): array;
}
