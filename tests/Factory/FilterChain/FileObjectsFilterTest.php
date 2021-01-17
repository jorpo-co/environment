<?php declare(strict_types=1);

namespace Jorpo\Environment\Factory\FilterChain;

use SplFileInfo;
use PHPUnit\Framework\TestCase;

class FileObjectsFilterTest extends TestCase
{
    private const FIXTURES = __DIR__.'/../../fixtures';

    public function testThatFileObjectsAreCreated()
    {
        $path = realpath(self::FIXTURES);

        $subject = new FileObjectsFilter;
        $result = $subject->filter(['something_file' => $path.'/something_file.txt'], new NullFilter);

        $object = $result['something_file'];
        $this->assertInstanceOf(SplFileInfo::class, $object);

        $this->assertTrue($object->isFile());
        $this->assertSame('something_file.txt', $object->getFilename());
        $this->assertSame($path, $object->getPath());
    }

    public function testThatPathObjectsAreCreated()
    {
        $path = realpath(self::FIXTURES);

        $subject = new FileObjectsFilter;
        $result = $subject->filter(['SOMETHING_PATH' => $path], new NullFilter);

        $object = $result['SOMETHING_PATH'];
        $this->assertInstanceOf(SplFileInfo::class, $object);

        $this->assertTrue($object->isDir());
        $this->assertSame($path, $object->getPathName());
    }

    public function testThatFilterWillPutAnyStringIntoSplFileObject()
    {
        $subject = new FileObjectsFilter;
        $result = $subject->filter(['something' => 'badgers'], new NullFilter);

        $object = $result['something'];
        $this->assertInstanceOf(SplFileInfo::class, $object);

        $this->assertFalse($object->isDir());
        $this->assertFalse($object->isFile());
        $this->assertSame('badgers', $object->getFilename());
        $this->assertSame('', $object->getPath());
    }
}
