<?php declare(strict_types=1);

namespace Jorpo\Environment\Factory\FilterChain;

class KeyContainsFilterChain implements Filter
{
    private string $value;
    private Filter $chain;

    public function __construct(string $value, Filter ...$filters)
    {
        $this->value = $value;
        $this->chain = new FilterChain(...$filters);
    }

    public function filter(array $environment, Filter $chain): array
    {
        foreach ($environment as $key => $value) {
            if ($this->contains($key, $this->value)) {
                $environment = array_replace($environment, $this->chain->filter([
                    $key => $value,
                ], $this->chain));
            }
        }

        return $chain->filter($environment, $chain);
    }

    private function contains(string $haystack, string $needle)
    {
        return strpos(strtolower($haystack), strtolower($needle)) !== false;
    }
}
