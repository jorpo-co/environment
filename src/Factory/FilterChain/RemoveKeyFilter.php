<?php declare(strict_types=1);

namespace Jorpo\Environment\Factory\FilterChain;

class RemoveKeyFilter implements Filter
{
    private string $key;

    public function __construct(string $key)
    {
        $this->key = $key;
    }

    public function filter(array $environment, Filter $chain): array
    {
        foreach ($environment as $key => $value) {
            if ($key === $this->key) {
                unset($environment[$key]);
            }
        }

        return $chain->filter($environment, $chain);
    }
}
