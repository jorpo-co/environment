<?php declare(strict_types=1);

namespace Jorpo\Environment\Factory\FilterChain;

use PHPUnit\Framework\TestCase;
use SplFileInfo;

class GetEnvFilterTest extends TestCase
{
    public function testThatFilterWillAddEnvVariable()
    {
        putenv('MUSHROOM=badger');

        $subject = new GetEnvFilter('MUSHROOM');

        $filtered = $subject->filter([], new NullFilter);

        $this->assertSame('badger', $filtered['MUSHROOM']);
    }

    public function testThatFilterWillAddEntireEnvironment()
    {
        putenv('MUSHROOM=badger');

        $subject = new GetEnvFilter;

        $filtered = $subject->filter([], new NullFilter);

        $this->assertTrue(count($filtered) > 1);    
        $this->assertSame('badger', $filtered['MUSHROOM']);
    }
}
