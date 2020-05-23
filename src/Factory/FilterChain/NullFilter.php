<?php declare(strict_types=1);

namespace Jorpo\Environment\Factory\FilterChain;

class NullFilter implements Filter
{
    public function filter(array $environment, Filter $chain): array
    {
        return $environment;
    }
}
