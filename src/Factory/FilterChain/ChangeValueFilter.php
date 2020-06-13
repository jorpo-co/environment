<?php declare(strict_types=1);

namespace Jorpo\Environment\Factory\FilterChain;

class ChangeValueFilter implements Filter
{
    private $newValue;

    public function __construct($newValue)
    {
        $this->newValue = $newValue;
    }

    public function filter(array $environment, Filter $chain): array
    {
        foreach ($environment as $key => $value) {
            $environment[$key] = $this->newValue;
        }

        return $chain->filter($environment, $chain);
    }
}
