<?php declare(strict_types=1);

namespace Jorpo\Environment\Factory\FilterChain;

class KeyEndsWithFilterChain implements Filter
{
    private string $suffix;
    private Filter $chain;

    public function __construct(string $suffix, Filter ...$filters)
    {
        $this->suffix = $suffix;
        $this->chain = new FilterChain(...$filters);
    }

    public function filter(array $environment, Filter $chain): array
    {
        foreach ($environment as $key => $value) {
            if ($this->endsWith($key, $this->suffix)) {
                $environment = array_replace($environment, $this->chain->filter([
                    $key => $value,
                ], $this->chain));
            }
        }

        return $chain->filter($environment, $chain);
    }

    private function endsWith(string $haystack, string $needle): bool
    {
        return substr_compare(strtolower($haystack), strtolower($needle), -strlen($needle)) === 0;
    }
}
