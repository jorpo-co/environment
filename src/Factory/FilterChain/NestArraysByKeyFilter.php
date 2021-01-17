<?php declare(strict_types=1);

namespace Jorpo\Environment\Factory\FilterChain;

use function substr;
use function strlen;
use function strtolower;

class NestArraysByKeyFilter implements Filter
{
    private string $nestingKey;

    public function __construct(string $nestingKey)
    {
        $this->nestingKey = $nestingKey;
    }

    public function filter(array $environment, Filter $chain): array
    {
        foreach ($environment as $key => $value) {
            if ($this->startsWith($key, $this->nestingKey)) {
                unset($environment[$key]);

                $key = substr($key, strlen($this->nestingKey)+1);
                $environment[$this->nestingKey] = $environment[$this->nestingKey] ?? [];
                $environment[$this->nestingKey][$key] = $value;
            }
        }

        return $chain->filter($environment, $chain);
    }

    private function startsWith(string $haystack, string $needle)
    {
        return substr(strtolower($haystack), 0, strlen(strtolower($needle))) === strtolower($needle);
    }
}
