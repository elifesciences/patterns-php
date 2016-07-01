<?php

namespace tests\eLife\Patterns\ViewModel;

use eLife\Patterns\ViewModel\Author;
use eLife\Patterns\ViewModel\Link;
use eLife\Patterns\ViewModel\Reference;

final class ReferenceTest extends ViewModelTest
{
    /**
     * @test
     */
    public function it_has_data()
    {
        $data = [
            'abstracts' => [
                ['name' => 'Download', 'url' => '/download'],
                ['name' => 'View', 'url' => '/view'],
            ],
            'authors' => [
                ['authorName' => 'Person Foo'],
                ['authorName' => 'Person Bar', 'authorLink' => '/bar'],
            ],
            'origin' => 'the origin',
            'secondaryLinkText' => 'the secondary',
            'title' => 'title of reference',
            'titleLink' => '/',
        ];

        $reference = new Reference($data['title'], $data['titleLink'], $data['secondaryLinkText'], $data['origin'], [
            new Author($data['authors'][0]['authorName']),
            new Author($data['authors'][1]['authorName'], $data['authors'][1]['authorLink']),
        ], [
            new Link($data['abstracts'][0]['name'], $data['abstracts'][0]['url']),
            new Link($data['abstracts'][1]['name'], $data['abstracts'][1]['url']),
        ]);

        $this->assertSame($data, $reference->toArray());
    }

    public function viewModelProvider() : array
    {
        return [
            [new Reference('title of reference', '/', 'the secondary', 'the origin', [
                new Author('Person Foo'),
                new Author('Person Bar', '/bar'),
            ], [
                new Link('Download', '/download'),
                new Link('View', '/view'),
            ])],
        ];
    }

    protected function expectedTemplate() : string
    {
        return '/elife/patterns/templates/reference.mustache';
    }
}
