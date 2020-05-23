<?php declare(strict_types=1);

namespace Jorpo\Environment\Factory\FilterChain;

use PHPUnit\Framework\TestCase;
use SplFileInfo;

class MergeArrayFilterTest extends TestCase
{
    public function testThatFilterWillMergeArray()
    {
        $subject = new MergeArrayFilter([
            'MUSHROOM' => 'badger',
        ]);

        $filtered = $subject->filter([], new NullFilter);

        $this->assertSame('badger', $filtered['MUSHROOM']);
    }
}
