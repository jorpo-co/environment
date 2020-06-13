<?php declare(strict_types=1);

namespace Jorpo\Environment\Factory\FilterChain;

use PHPUnit\Framework\TestCase;
use SplFileInfo;

class DotEnvFileFilterTest extends TestCase
{
    public function testThatFactoryWillCreateEnvironmentFromSingleEnvFile()
    {
        $subject = new DotEnvFileFilter(
            new SplFileInfo(realpath(__DIR__.'/../../fixtures/.env')),
        );

        $filtered = $subject->filter([], new NullFilter);

        $this->assertSame('badger', $filtered['MUSHROOM']);
    }

    public function testThatFactoryWillOverwriteExistingValues()
    {
        $subject = new DotEnvFileFilter(
            new SplFileInfo(realpath(__DIR__.'/../../fixtures/.env')),
        );

        $filtered = $subject->filter([
            'MUSHROOM' => 'snaaake!',
        ], new NullFilter);

        $this->assertSame('badger', $filtered['MUSHROOM']);
    }

    public function testThatFilterWillIgnoreMissingFiles()
    {
        $subject = new DotEnvFileFilter(
            new SplFileInfo('cabbages'),
        );

        $filtered = $subject->filter([], new NullFilter);

        $this->assertEmpty($filtered);
    }
}
