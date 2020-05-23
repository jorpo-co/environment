<?php declare(strict_types=1);

namespace Jorpo\Environment;

use StdClass;
use PHPUnit\Framework\TestCase;

class EnvironmentTest extends TestCase
{
    public function testThatEnvironmentAcceptsArray()
    {
        $subject = new Environment([
            'mushroom' => 'badger',
        ]);

        $this->assertInstanceOf(Environment::class, $subject);
        $this->assertSame('badger', $subject->mushroom);
    }

    public function testThatEnvironmentAcceptsNestedArrays()
    {
        $subject = new Environment([
            'mushroom' => [
                'badger' => 'snaaake!',
            ],
        ]);

        $mushroom = $subject->mushroom;

        $this->assertInstanceOf(Environment::class, $mushroom);
        $this->assertSame('snaaake!', $mushroom->badger);
    }

    public function testThatExistingValuesCannotBeChanged()
    {
        $subject = new Environment([
            'mushroom' => 'badger',
        ]);

        $subject->mushroom = 'snaaake!';

        $this->assertSame('badger', $subject->mushroom);
    }

    public function testThatKeysCannotBeRemoved()
    {
        $subject = new Environment([
            'mushroom' => 'badger',
        ]);

        unset($subject->mushroom);

        $this->assertSame('badger', $subject->mushroom);
    }

    public function testThatKeysAreCreated()
    {
        $subject = new Environment([
            'mushroom' => [
                'badger' => 'snaaake!',
            ],
        ]);

        $this->assertTrue(isset($subject->mushroom));
        $this->assertFalse(isset($subject->snaaake));

        $this->assertTrue(isset($subject->mushroom->badger));
        $this->assertFalse(isset($subject->mushroom->snaaake));
    }

    public function testThatNonExistentKeysReturnNull()
    {
        $subject = new Environment([]);

        $this->assertNull($subject->mushroom);
    }

    public function testThatEnvironmentCanBeAddedTo()
    {
        $subject = new Environment([
            'mushroom' => 'badger',
        ]);

        $subject->snaaake = 'mushroom badger';

        $this->assertSame('mushroom badger', $subject->snaaake);
    }

    public function testThatEnvironmentReturnsCloneFromRequestedKey()
    {
        $subject = new Environment([
            'mushroom' => $stdClass = new StdClass,
        ]);
        $clone = $subject->mushroom;

        $this->assertNotSame($stdClass, $clone);
    }

    public function testThatEnvironmentReturnsNestedEnvironmentWithoutClone()
    {
        $subject = new Environment([
            'mushroom' => $nested = new Environment([]),
        ]);
        $storedEnvironment = $subject->mushroom;

        $this->assertSame($nested, $storedEnvironment);
    }

    public function testThatEnvironmentIsIterable()
    {
        $subject = new Environment([
            'mushroom' => 'badger',
            'badger' => 'mushroom'
        ]);
        $result = '';

        foreach ($subject as $key => $value) {
            $result .= $key . $value;
        }

        $this->assertSame('mushroombadgerbadgermushroom', $result);
    }

    public function testThatEnvironmentIteratesOverClones()
    {
        $subject = new Environment([
            'mushroom' => $stdClassOne = new StdClass,
            'badger' => $stdClassTwo = new StdClass
        ]);
        $result = [];

        foreach ($subject as $key => $value) {
            $result[$key] = $value;
        }

        $this->assertNotSame($stdClassOne, $result['mushroom']);
        $this->assertNotSame($stdClassTwo, $result['badger']);
    }
}
