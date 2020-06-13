<?php declare(strict_types=1);

namespace Jorpo\Environment\Factory\FilterChain;

class LimitByKeyFilterChain implements Filter
{
    private string $key;
    private Filter $chain;

    public function __construct(string $key, Filter ...$filters)
    {
        $this->key = $key;
        $this->chain = new FilterChain(...$filters);
    }

    public function filter(array $environment, Filter $chain): array
    {
        foreach ($environment as $key => $value) {
            if ($key === $this->key) {
                $environment[$key] = $this->chain->filter([
                    $key => $value,
                ], $this->chain);
            }
        }

        return $chain->filter($environment, $chain);
    }
}
