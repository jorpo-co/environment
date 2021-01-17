<?php declare(strict_types=1);

namespace Jorpo\Environment\Factory\FilterChain;

use function parse_url;

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
