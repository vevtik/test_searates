<?php
require_once __DIR__ . '/config.php';

require_once ROOT_PATH . '/vendor/autoload.php';

function toPascalCase(string $str): string
{
    return str_replace(
        ' ',
        '',
        ucwords(
            trim(
                str_replace("_", " ", $str)
            )
        )
    );
}
