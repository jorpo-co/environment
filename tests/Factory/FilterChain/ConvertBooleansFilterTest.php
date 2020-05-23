<?php declare(strict_types=1);

namespace Jorpo\Environment\Factory\FilterChain;

use PHPUnit\Framework\TestCase;

class ConvertBooleansFilterTest extends TestCase
{
    public function testBooleansAreConverted()
    {
        $fixture = [
            'BADGER' => 'true',
            'mushroom' => 'yes',
            'BADGER_MUSHROOM' => true,
            'snaaake' => 'false',
            'MUSHROOM_BADGER' => 'no',
            'badger_snaaake' => false,
            'ignore' => 'mushroom',
        ];

        $expected = [
            'BADGER' => true,
            'mushroom' => true,
            'BADGER_MUSHROOM' => true,
            'snaaake' => false,
            'MUSHROOM_BADGER' => false,
            'badger_snaaake' => false,
            'ignore' => 'mushroom',
        ];

        $subject = new ConvertBooleansFilter;
        $result = $subject->filter($fixture, new NullFilter);

        $this->assertSame($expected, $result);
    }
}
