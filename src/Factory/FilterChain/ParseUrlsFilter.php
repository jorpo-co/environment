<?php declare(strict_types=1);

namespace Jorpo\Environment\Factory\FilterChain;

use function parse_url;
use function substr_compare;
use function strtolower;
use function strlen;

class ParseUrlsFilter implements Filter
{
    private string $key;

    public function __construct(string $key)
    {
        $this->key = $key;
    }

    public function filter(array $environment, Filter $chain): array
    {
        foreach ($environment as $key => $value) {
            if ($this->endsWith($key, $this->key)) {
                $environment[$key] = parse_url($value) ?? $value;
                $environment[$key]['raw'] = $value;
            }
        }

        return $chain->filter($environment, $chain);
    }

    private function endsWith(string $haystack, string $needle)
    {
        return substr_compare(strtolower($haystack), $needle, -strlen($needle)) === 0;
    }
}
