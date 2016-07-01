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
            'hasAuthors' => true,
            'hasAbstracts' => true,
        ];

        $reference = new Reference($data['title'], $data['titleLink'], $data['origin'], $data['secondaryLinkText'], [
            new Author($data['authors'][0]['authorName']),
            new Author($data['authors'][1]['authorName'], $data['authors'][1]['authorLink']),
        ], [
            new Link($data['abstracts'][0]['name'], $data['abstracts'][0]['url']),
            new Link($data['abstracts'][1]['name'], $data['abstracts'][1]['url']),
        ]);

        $this->assertSame($data, $reference->toArray());
    }

    /**
     * @test
     */
    public function it_can_be_provided_without_secondary_link_text()
    {
        $reference = new Reference('some title', '/', 'origin');

        $this->assertSame('', $reference['secondaryLinkText']);
    }

    /**
     * @test
     */
    public function it_can_be_provided_an_empty_author_list()
    {
        $reference = new Reference('some title', '/', 'origin', 'secondary', [],
            [
                new Link('Download', '/download'),
                new Link('View', '/view'),
            ]);

        $this->assertSame([], $reference['authors'], 'Authors appears empty');
        $this->assertSame(false, $reference['hasAuthors'], 'hasAuthor property updated correctly');
    }

    /**
     * @test
     */
    public function it_can_be_provided_an_empty_abstract_list()
    {
        $reference = new Reference('some title', '/', 'origin', 'secondary',[
            new Author('Person Foo'),
            new Author('Person Bar', '/bar'),
        ], []);

        $this->assertSame([], $reference['abstracts'], 'Abstracts appears empty');
        $this->assertSame(false, $reference['hasAbstracts'], 'hasAbstract property updated correctly');
    }

    public function viewModelProvider() : array
    {
        return [
            [new Reference('title of reference', '/', 'the origin', 'the secondary', [
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
