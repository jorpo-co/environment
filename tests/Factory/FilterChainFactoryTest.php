<?php declare(strict_types=1);

namespace Jorpo\Environment\Factory;

use PHPUnit\Framework\TestCase;
use Jorpo\Environment\Environment;
use Jorpo\Environment\Factory\FilterChain\AddMessageFilter;
use Jorpo\Environment\Factory\FilterChain\FilterChain;

class FilterChainFactoryTest extends TestCase
{
    public function testThatFactoryProducesEnvironment()
    {
        $subject = new FilterChainFactory(new FilterChain(
            new AddMessageFilter('badger', 'mushroom')
        ));

        $environment = $subject->make();

        $this->assertSame('mushroom', $environment->badger);
    }
}
