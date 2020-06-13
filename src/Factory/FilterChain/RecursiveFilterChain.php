<?php declare(strict_types=1);

namespace Jorpo\Environment\Factory\FilterChain;

use function is_array;

class RecursiveFilterChain implements Filter
{
    private Filter $chain;

    public function __construct(Filter ...$filters)
    {
        $this->chain = new FilterChain(...$filters);
    }

    public function filter(array $environment, Filter $chain): array
    {
        foreach ($environment as $key => $value) {
            if (is_array($value)) {
                $environment[$key] = $this->chain->filter($value, $this->chain);
            }
        }

        return $environment;
    }
}
