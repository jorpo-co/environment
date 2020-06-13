<?php declare(strict_types=1);

namespace Jorpo\Environment\Factory\FilterChain;

use SplFileInfo;
use PHPUnit\Framework\TestCase;

class FileObjectsFilterTest extends TestCase
{
    public function testThatFileObjectsAreCreated()
    {
        $subject = new FileObjectsFilter;
        $result = $subject->filter(['something_file' => 'fixtures/something_file.txt'], new NullFilter);

        $object = $result['something_file'];
        $this->assertInstanceOf(SplFileInfo::class, $object);

        $this->assertSame('something_file.txt', $object->getFilename());
        $this->assertSame('fixtures', $object->getPath());
    }

    public function testThatPathObjectsAreCreated()
    {
        $subject = new FileObjectsFilter('path');
        $result = $subject->filter(['SOMETHING_PATH' => 'fixtures'], new NullFilter);

        $object = $result['SOMETHING_PATH'];
        $this->assertInstanceOf(SplFileInfo::class, $object);

        $this->assertSame('fixtures', $object->getPathName());
    }

    public function testThatFilterWillPutAnyStringIntoSplFileObject()
    {
        $subject = new FileObjectsFilter;
        $result = $subject->filter(['something' => 'badgers'], new NullFilter);

        $object = $result['something'];
        $this->assertInstanceOf(SplFileInfo::class, $object);

        $this->assertSame('badgers', $object->getFilename());
        $this->assertSame('', $object->getPath());
    }
}
