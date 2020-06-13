<?php declare(strict_types=1);

namespace Jorpo\Environment\Factory\FilterChain;

use SplFileInfo;
use Throwable;
use function array_replace;
use josegonzalez\Dotenv\Loader;

class DotEnvFileFilter implements Filter
{
    private SplFileInfo $file;

    public function __construct(SplFileInfo $file)
    {
        $this->file = $file;
    }

    public function filter(array $environment, Filter $chain): array
    {
        $loader = new Loader((string) $this->file);

        try {
            $filtered = $loader->parse()->toArray();
        } catch (Throwable $e) {
            $filtered = [];
        }

        return $chain->filter(array_replace($environment, $filtered), $chain);
    }
}
