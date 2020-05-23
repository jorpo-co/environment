<?php

namespace Jorpo\Environment\Factory\FilterChain;

use PHPUnit\Framework\TestCase;

class RecursiveFilterChainTest extends TestCase
{
    public function testThatChainRecursesOneLevelDeep()
    {
        $chain = new RecursiveFilterChain(
            new AddMessageFilter('mushroom', 'badger'),
            new AddMessageFilter('badger', 'mushroom'),
            new AddMessageFilter('snaaake!', 'snaaake!')
        );
        $filtered = $chain->filter([
                'mushroom' => [],
                'badger' => [],
            ],
            new NullFilter
        );
        $expected = [
            'mushroom' => [
                'mushroom' => 'badger',
                'badger' => 'mushroom',
                'snaaake!' => 'snaaake!',
            ],
            'badger' => [
                'mushroom' => 'badger',
                'badger' => 'mushroom',
                'snaaake!' => 'snaaake!',
            ],
        ];

        $this->assertSame($expected, $filtered);
    }
}
