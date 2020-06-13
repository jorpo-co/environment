<?php declare(strict_types=1);

namespace Jorpo\Environment\Factory\FilterChain;

class KeyStartsWithFilterChain implements Filter
{
    private string $prefix;
    private Filter $chain;

    public function __construct(string $prefix, Filter ...$filters)
    {
        $this->prefix = $prefix;
        $this->chain = new FilterChain(...$filters);
    }

    public function filter(array $environment, Filter $chain): array
    {
        foreach ($environment as $key => $value) {
            if ($this->startsWith($key, $this->prefix)) {
                $environment = array_replace($environment, $this->chain->filter([
                    $key => $value,
                ], $this->chain));
            }
        }

        return $chain->filter($environment, $chain);
    }

    private function startsWith(string $haystack, string $needle)
    {
        return substr(strtolower($haystack), 0, strlen(strtolower($needle))) === strtolower($needle);
    }
}
