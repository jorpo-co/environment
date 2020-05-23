# Environment

Example:

```
<?php declare(strict_types=1);

use Jorpo\Environment\Factory\FilterChain\ConvertBooleansFilter;
use Jorpo\Environment\Factory\FilterChain\DotEnvFileFilter;
use Jorpo\Environment\Factory\FilterChain\FileObjectsFilter;
use Jorpo\Environment\Factory\FilterChain\FilterChain;
use Jorpo\Environment\Factory\FilterChain\GetEnvFilter;
use Jorpo\Environment\Factory\FilterChain\LimitByKeyFilterChain;
use Jorpo\Environment\Factory\FilterChain\LowercaseKeysFilter;
use Jorpo\Environment\Factory\FilterChain\MergeArrayFilter;
use Jorpo\Environment\Factory\FilterChain\NestArraysByKeyFilter;
use Jorpo\Environment\Factory\FilterChain\ParseUrlsFilter;
use Jorpo\Environment\Factory\FilterChainFactory;

$factory = new FilterChainFactory(new FilterChain(

    // Load all env variables from selected sources
    new FilterChain(
        new DotEnvFileFilter(new SplFileInfo(__DIR__ . '/../.env.defaults')),
        new DotEnvFileFilter(new SplFileInfo(__DIR__ . '/../.env')),
        new MergeArrayFilter($_SERVER),
        new GetEnvFilter
    ),

    // Apply some basic transformations
    new LowercaseKeysFilter,
    new ConvertBooleansFilter,

    // Deal with paths and files
    new FilterChain(
        new FileObjectsFilter('path'),
        new FileObjectsFilter('file'),
        new LimitByKeyFilterChain(
            'paths',
            new FileObjectsFilter('path'),
            new FileObjectsFilter('file')
        )
    ),

    // Deal with URLs and URIs etc
    new FilterChain(
        new ParseUrlsFilter('url'),
        new ParseUrlsFilter('uri'),
        new ParseUrlsFilter('urn'),
    ),

    // Nest known keys for tidier access
    new NestArraysByKeyFilter(
        'amqp',
        'auth',
        'database',
        'logging',
        'slim'
    ),

    // For database access nest again
    new LimitByKeyFilterChain(
        'database',
        new NestArraysByKeyFilter(
            'system', 'tenant',
        )
    )
));

$environment = $factory->make();
```

