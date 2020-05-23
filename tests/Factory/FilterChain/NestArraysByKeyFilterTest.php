<?php declare(strict_types=1);

namespace Jorpo\Environment\Factory\FilterChain;

use PHPUnit\Framework\TestCase;

class NestArraysByKeyFilterTest extends TestCase
{
    public function testThatArraysAreNested()
    {
        $fixture = [
            'BADGER_BADGER_BADGER_BADGER' => 'mushroom mushroom',
            'BADGER_MUSHROOM_MUSHROOM' => 'mushroom mushroom',
            'mushroom_mushroom_mushroom' => 'snaaake!',
        ];

        $expected = [
            'BADGER' => [
                'BADGER_BADGER_BADGER' => 'mushroom mushroom',
                'MUSHROOM_MUSHROOM' => 'mushroom mushroom',
            ],
            'mushroom_mushroom_mushroom' => 'snaaake!',
        ];

        $subject = new NestArraysByKeyFilter('badger');
        $result = $subject->filter($fixture, new NullFilter);

        $this->assertSame(sort($expected), sort($result));
    }
}
