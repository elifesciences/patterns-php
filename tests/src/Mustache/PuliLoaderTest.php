<?php

namespace tests\eLife\Patterns\Mustache;

use eLife\Patterns\Mustache\PuliLoader;
use Mustache_Exception_UnknownTemplateException;
use Mustache_Loader;
use PHPUnit_Framework_TestCase;
use Puli\Repository\FilesystemRepository;
use Puli\Repository\InMemoryRepository;

final class PuliLoaderTest extends PHPUnit_Framework_TestCase
{
    /**
     * @test
     */
    public function it_is_a_mustache_loader()
    {
        $repo = new InMemoryRepository();
        $loader = new PuliLoader($repo);

        $this->assertInstanceOf(Mustache_Loader::class, $loader);
    }

    /**
     * @test
     */
    public function it_loads_a_resource()
    {
        $repo = new FilesystemRepository(__DIR__.'/../../resources');
        $loader = new PuliLoader($repo);

        $this->assertStringEqualsFile(__DIR__.'/../../resources/foo.mustache', $loader->load('/foo.mustache'));
    }

    /**
     * @test
     * @depends it_loads_a_resource
     */
    public function it_fails_to_load_a_non_existent_resource()
    {
        $repo = new FilesystemRepository(__DIR__.'/../../resources');
        $loader = new PuliLoader($repo);

        $this->expectException(Mustache_Exception_UnknownTemplateException::class);

        $loader->load('/foobar.mustache');
    }

    /**
     * @test
     * @depends it_loads_a_resource
     */
    public function it_fails_to_load_a_non_body_resource()
    {
        $repo = new FilesystemRepository(__DIR__.'/../../resources');
        $loader = new PuliLoader($repo);

        $this->expectException(Mustache_Exception_UnknownTemplateException::class);

        $loader->load('/');
    }
}
