<?php declare(strict_types=1);

namespace Jorpo\Environment\Factory\FilterChain;

use PHPUnit\Framework\TestCase;

class LowercaseKeysFilterTest extends TestCase
{
    public function testThatKeysAreLowercase()
    {
        $fixture = [
            'BADGER' => 'mushroom',
            'MUSHROOM' => 'snaaake!',
        ];

        $expected = [
            'badger' => 'mushroom',
            'mushroom' => 'snaaake!',
        ];

        $subject = new LowercaseKeysFilter;
        $result = $subject->filter($fixture, new NullFilter);

        $this->assertSame($expected, $result);
    }
}
