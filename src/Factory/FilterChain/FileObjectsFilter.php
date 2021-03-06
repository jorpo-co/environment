<?php declare(strict_types=1);

namespace Jorpo\Environment\Factory\FilterChain;

use SplFileInfo;

class FileObjectsFilter implements Filter
{
    public function filter(array $environment, Filter $chain): array
    {
        foreach ($environment as $key => $value) {
            $environment[$key] =  new SplFileInfo($value);
        }

        return $chain->filter($environment, $chain);
    }
}
