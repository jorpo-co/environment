<?php declare(strict_types=1);

namespace Jorpo\Environment;

use Ds\Map;
use Traversable;
use IteratorAggregate;
use function DeepCopy\deep_copy;
use function is_array;

final class Environment implements IteratorAggregate
{
    private Map $contents;

    public function __construct(array $contents)
    {
        $this->contents = new Map($this->mapNestedArrays($contents));
    }

    public function __get(string $name)
    {
        $value = $this->contents->get($name, null);

        return is_a($value, Environment::class) ? $value : deep_copy($value);
    }

    public function __set(string $name, $value)
    {
        if (!$this->contents->hasKey($name)) {
            $contents = $this->mapNestedArrays([$name => $value]);
            $this->contents->put($name, $contents[$name]);
        }
    }

    public function __unset(string $name)
    {
    }

    public function __isset(string $name): bool
    {
        return $this->contents->hasKey($name);
    }

    public function getIterator(): Traversable
    {
        return new Map(deep_copy($this->contents->toArray()));
    }

    private function mapNestedArrays(array $contents): array
    {
        foreach ($contents as $key => $item) {
            $contents[$key] = !is_array($item) ? $item : new self($item);
        }

        return $contents;
    }
}
