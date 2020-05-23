<?php declare(strict_types=1);

namespace Jorpo\Environment\Factory\FilterChain;

use PHPUnit\Framework\TestCase;

class ParseUrlsFilterTest extends TestCase
{
    /**
     * @dataProvider dataProvider
     */
    public function testThatUrlsAreParsed(string $key, array $fixture, array $expected)
    {
        $subject = new ParseUrlsFilter($key);
        $result = $subject->filter($fixture, new NullFilter);

        $this->assertSame($expected, $result);
    }

    public function dataProvider(): array
    {
        return [
            [
                'url',
                ['something_url' => 'https://username:password@hostname:9090/path?arg=value#anchor'],
                ['something_url' => [
                    'scheme' => 'https',
                    'host' => 'hostname',
                    'port' => 9090,
                    'user' => 'username',
                    'pass' => 'password',
                    'path' => '/path',
                    'query' => 'arg=value',
                    'fragment' => 'anchor',
                    'raw' => 'https://username:password@hostname:9090/path?arg=value#anchor',
                ]
            ], [
                'uri',
                ['ELSE_URI' => '//hostname:9090/path?googleguy=googley'],
                ['ELSE_URI' => [
                    'host' => 'hostname',
                    'port' => 9090,
                    'path' => '/path',
                    'query' => 'googleguy=googley',
                    'raw' => '//hostname:9090/path?googleguy=googley',
                ]]
            ], [
                'urn',
                ['other_urn' => 'urn:uuid:6e8bc430-9c3a-11d9-9669-0800200c9a66'],
                ['other_urn' => [
                    'scheme' => 'urn',
                    'path' => 'uuid:6e8bc430-9c3a-11d9-9669-0800200c9a66',
                    'raw' => 'urn:uuid:6e8bc430-9c3a-11d9-9669-0800200c9a66',
                ]]
            ], [
                'url',
                ['snaaake!' => 'badger'],
                ['snaaake!' => 'badger']
            ]]
        ];
    }
}
