<?php declare(strict_types=1);

namespace Jorpo\Environment\Factory\FilterChain;

use function array_replace;

class MergeArrayFilter implements Filter
{
    private array $array;

    public function __construct(array $array)
    {
        $this->array = $array;
    }

    public function filter(array $environment, Filter $chain): array
    {
        return $chain->filter(array_replace($environment, $this->array), $chain);
    }
}
