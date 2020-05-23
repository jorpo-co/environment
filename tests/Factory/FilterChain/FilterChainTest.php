<?php

namespace Jorpo\Environment\Factory\FilterChain;

use PHPUnit\Framework\TestCase;

class FilterChainTest extends TestCase
{
    public function testThatChainOutputsExpectedArray()
    {
        $chain = new FilterChain(
            new AddMessageFilter('mushroom', 'badger'),
            new AddMessageFilter('badger', 'mushroom'),
            new AddMessageFilter('snaaake!', 'snaaake!')
        );

        $filtered = $chain->filter(
            [],
            new NullFilter
        );
        $expected = [
            'mushroom' => 'badger',
            'badger' => 'mushroom',
            'snaaake!' => 'snaaake!',
        ];

        $this->assertSame($expected, $filtered);
    }

    public function testThatEmptyChainUsesFinalFilter()
    {
        $chain = new FilterChain();

        $filtered = $chain->filter(
            [],
            new AddMessageFilter('snaaake!', 'snaaake!')
        );
        $expected = [
            'snaaake!' => 'snaaake!',
        ];

        $this->assertSame($expected, $filtered);
    }

    public function testThatChainCanAcceptFilterPush()
    {
        $chain = new FilterChain(
            new AddMessageFilter('mushroom', 'badger')
        );

        $chain->pushFilter(new AddMessageFilter('badger', 'mushroom'));

        $filtered = $chain->filter(
            [],
            new NullFilter
        );
        $expected = [
            'mushroom' => 'badger',
            'badger' => 'mushroom',
        ];

        $this->assertSame($expected, $filtered);
    }

    public function testThatFilterChainIsReusable()
    {
        $chain = new FilterChain(
            new AddMessageFilter('mushroom', 'badger'),
            new AddMessageFilter('badger', 'mushroom'),
            new AddMessageFilter('snaaake!', 'snaaake!')
        );

        $filteredOne = $chain->filter(
            [],
            new NullFilter
        );
        $filteredTwo = $chain->filter(
            [],
            new NullFilter
        );
        $expected = [
            'mushroom' => 'badger',
            'badger' => 'mushroom',
            'snaaake!' => 'snaaake!',
        ];

        $this->assertSame($expected, $filteredOne);
        $this->assertSame($expected, $filteredTwo);
    }
}
