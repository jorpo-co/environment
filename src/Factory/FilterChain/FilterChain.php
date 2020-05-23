<?php declare(strict_types=1);

namespace Jorpo\Environment\Factory\FilterChain;

use Ds\Vector;
use function DeepCopy\deep_copy;

class FilterChain implements Filter
{
    private Vector $filters;

    public function __construct(Filter ...$filters)
    {
        $this->filters = new Vector($filters);
    }

    public function filter(array $environment, Filter $chain): array
    {
        $filtered = $environment;

        $this->pushFilter($chain);

        $filters = deep_copy($this->filters);
        $filter = $this->filters->shift();

        if ($this !== $filter) {
            $filtered = $filter->filter($environment, $this);
        }

        $this->filters = $filters;

        return $filtered;
    }

    public function pushFilter(Filter $filter)
    {
        $this->filters->push($filter);
    }
}
