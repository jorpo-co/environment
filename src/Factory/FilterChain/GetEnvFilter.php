<?php declare(strict_types=1);

namespace Jorpo\Environment\Factory\FilterChain;

use function array_replace;
use function getenv;

class GetEnvFilter implements Filter
{
    private ?string $variable;

    public function __construct(string $variable = null)
    {
        $this->variable = $variable;
    }

    public function filter(array $environment, Filter $chain): array
    {
        if (null !== $this->variable) {
            return $chain->filter(array_replace($environment, [
                $this->variable => getenv($this->variable)
            ]), $chain);
        }

        return $chain->filter(array_replace($environment, getenv()), $chain);
    }
}
