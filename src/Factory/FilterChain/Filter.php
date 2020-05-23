<?php declare(strict_types=1);

namespace Jorpo\Environment\Factory\FilterChain;

interface Filter
{
    public function filter(array $environment, Filter $chain): array;
}
