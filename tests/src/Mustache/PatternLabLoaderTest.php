<?php

namespace tests\eLife\Patterns\Mustache;

use eLife\Patterns\Mustache\PatternLabLoader;
use Mustache_Exception_UnknownTemplateException;
use Mustache_Loader;
use PHPUnit_Framework_TestCase;

final class PatternLabLoaderTest extends PHPUnit_Framework_TestCase
{
    /**
     * @test
     */
    public function it_is_a_mustache_loader()
    {
        $loader = new PatternLabLoader(__DIR__ . '/../../resources');

        $this->assertInstanceOf(Mustache_Loader::class, $loader);
    }

    /**
     * @test
     */
    public function it_loads_a_resource()
    {
        $loader = new PatternLabLoader(__DIR__ . '/../../resources');

        $this->assertStringEqualsFile(__DIR__ . '/../../resources/foo.mustache', $loader->load('/atom-foo.mustache'));
    }

    /**
     * @test
     * @depends it_loads_a_resource
     */
    public function it_fails_to_load_a_non_existent_resource()
    {
        $loader = new PatternLabLoader(__DIR__ . '/../../resources');

        $this->expectException(Mustache_Exception_UnknownTemplateException::class);

        $loader->load('/foobar.mustache');
    }
}
