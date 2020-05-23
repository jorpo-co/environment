<?php declare(strict_types=1);

namespace Jorpo\Environment\Factory;

use Jorpo\Environment\Factory\FilterChain\Filter;
use Jorpo\Environment\Factory;
use Jorpo\Environment\Environment;
use Jorpo\Environment\Factory\FilterChain\NullFilter;

class FilterChainFactory implements Factory
{
    private Filter $chain;
    private array $data;

    public function __construct(Filter $chain, array $data = [])
    {
        $this->chain = $chain;
        $this->data = $data;
    }

    public function make(): Environment
    {
        return new Environment($this->chain->filter($this->data, new NullFilter));
    }
}
