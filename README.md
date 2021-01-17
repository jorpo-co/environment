# Environment

This package can be used as simply as `new Environment($_SERVER);` to allow configurations to be passed around inside an OOP application with ease.

However, we all know that application configurations can be a little more challenging than that. To allow as much flexibility as possible, this package implements a Chain of Responsibility pattern to allow multiple layers of simple or complex data manipulation to forge an application environment to suit any need.

Here's a thorough Example:

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

    // Load all env variables from selected .env sources
    // This filter chain set will merge and overwrite values from previous fiters
    new FilterChain(
        new DotEnvFileFilter(new SplFileInfo(__DIR__ . '/../.env.defaults')),
        new DotEnvFileFilter(new SplFileInfo(__DIR__ . '/../.env')),
        new MergeArrayFilter($_SERVER),
        new GetEnvFilter
    ),

    // Apply some basic transformations
    new LowercaseKeysFilter,
    new ConvertBooleansFilter,

    // Deal with paths and files.
    // You could use these example filters to implement Flysystem file loading!
    new FilterChain(
        $pathFilter = new KeyEndsWithFilterChain('path', new FileObjectsFilter),
        $fileFilter = new KeyEndsWithFilterChain('file', new FileObjectsFilter),
        new LimitByKeyFilterChain(
            'paths',
            $pathFilter,
            $fileFilter
        )
    ),

    // Deal with URLs and URIs etc
    new FilterChain(
        new KeyEndsWithFilterChain('url', new ParseUrlsFilter),
        new KeyEndsWithFilterChain('uri', new ParseUrlsFilter),
        new KeyEndsWithFilterChain('urn', new ParseUrlsFilter),
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
    new KeyStartsWithFilterChain(
        'database',
        new NestArraysByKeyFilter(
            'system', 'tenant',
        )
    )
));

$environment = $factory->make();
```

## Todo

- Add support for Yaml?
- ini file support?

Sure, there's better, more clean and more generic ways of doing some of these filters, and it will be tackled some day.
