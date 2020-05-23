<?php declare(strict_types=1);

namespace Jorpo\Environment\Factory\FilterChain;

class AddMessageFilter implements Filter
{
    private string $key;
    private string $message;

    public function __construct(string $key, string $message)
    {
        $this->key = $key;
        $this->message = $message;
    }

    public function filter(array $environment, Filter $chain): array
    {
        $environment[$this->key] = $this->message;

        return $chain->filter($environment, $chain);
    }
}
