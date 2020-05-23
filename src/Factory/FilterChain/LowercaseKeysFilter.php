<?php declare(strict_types=1);

namespace Jorpo\Environment\Factory\FilterChain;

use function strtolower;

class LowercaseKeysFilter implements Filter
{
    public function filter(array $environment, Filter $chain): array
    {
        $filtered = [];

        foreach ($environment as $key => $value) {
            $filtered[strtolower($key)] = $value;
        }

        return $chain->filter($filtered, $chain);
    }
}
