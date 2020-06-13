<?php declare(strict_types=1);

namespace Jorpo\Environment\Factory\FilterChain;

use function parse_url;
use function substr_compare;
use function strtolower;
use function strlen;

class ParseUrlsFilter implements Filter
{
    public function filter(array $environment, Filter $chain): array
    {
        foreach ($environment as $key => $value) {
            $environment[$key] = parse_url($value) ?? $value;
            $environment[$key]['raw'] = $value;
        }

        return $chain->filter($environment, $chain);
    }
}
