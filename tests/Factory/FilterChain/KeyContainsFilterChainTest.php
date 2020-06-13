<?php

namespace Jorpo\Environment\Factory\FilterChain;

use PHPUnit\Framework\TestCase;

class KeyBasedFilterChainTest extends TestCase
{
    public function testThatChainActsOnKeyThatContainsValue()
    {
        $chain = new KeyContainsFilterChain(
            'badger',
            new ChangeValueFilter('changed!'),
        );
        $filtered = $chain->filter([
                'mushroom_mushroom' => 'snaaake!',
                'mushroom_badger' => 'snaaake!',
                'badger_badger' => [],
            ],
            new NullFilter
        );
        $expected = [
            'mushroom_mushroom' => 'snaaake!',
            'mushroom_badger' => 'changed!',
            'badger_badger' => 'changed!',
        ];

        $this->assertSame($expected, $filtered);
    }

    public function testThatChainActsOnKeyThatStartsWithPrefix()
    {
        $chain = new KeyStartsWithFilterChain(
            'badger',
            new ChangeValueFilter('changed!'),
        );
        $filtered = $chain->filter([
                'mushroom_mushroom' => 'snaaake!',
                'mushroom_badger' => 'snaaake!',
                'badger_badger' => 'snaaake!',
            ],
            new NullFilter
        );
        $expected = [
            'mushroom_mushroom' => 'snaaake!',
            'mushroom_badger' => 'snaaake!',
            'badger_badger' => 'changed!',
        ];

        $this->assertSame($expected, $filtered);
    }

    public function testThatChainActsOnKeyThatEndsWithPrefix()
    {
        $chain = new KeyEndsWithFilterChain(
            'mushroom',
            new ChangeValueFilter('changed!'),
        );
        $filtered = $chain->filter([
                'mushroom_mushroom' => 'snaaake!',
                'mushroom_badger' => 'snaaake!',
                'badger_badger' => 'snaaake!',
            ],
            new NullFilter
        );
        $expected = [
            'mushroom_mushroom' => 'changed!',
            'mushroom_badger' => 'snaaake!',
            'badger_badger' => 'snaaake!',
        ];

        $this->assertSame($expected, $filtered);
    }
}
