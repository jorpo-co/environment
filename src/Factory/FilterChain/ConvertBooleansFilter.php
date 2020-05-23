<?php declare(strict_types=1);

namespace Jorpo\Environment\Factory\FilterChain;

use function array_map;
use function is_string;
use function filter_var;

class ConvertBooleansFilter implements Filter
{
    public function filter(array $environment, Filter $chain): array
    {
        return $chain->filter(array_map(function ($value) {
            if (is_string($value) && null !== ($boolean = filter_var($value, FILTER_VALIDATE_BOOLEAN, FILTER_NULL_ON_FAILURE))) {
                $value = $boolean;
            }

            return $value;
        }, $environment), $chain);
    }
}
