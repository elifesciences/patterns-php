<?php

namespace tests\eLife\Patterns\ViewModel;

use eLife\Patterns\ViewModel\Author;
use eLife\Patterns\ViewModel\Doi;
use eLife\Patterns\ViewModel\Link;
use eLife\Patterns\ViewModel\Reference;
use eLife\Patterns\ViewModel\ReferenceAuthorList;

final class ReferenceTest extends ViewModelTest
{
    /**
     * @test
     */
    public function it_has_data()
    {
        $data = [
            'bibId' => 'full id 1',
            'abstracts' => [
                ['name' => 'Download', 'url' => '/download'],
            ],
            'authorLists' => [
                [
                    'authors' => [
                        ['name' => 'Person Foo', 'url' => false],
                        ['name' => 'Person Bar', 'url' => '/bar'],
                    ],
                    'suffix' => 'suffix',
                ],
            ],
            'origin' => 'origin 1. origin 2.',
            'label' => 'label',
            'doi' => [
                'doi' => '10.7554/eLife.10181.001',
            ],
            'title' => 'title of reference',
            'hasAuthors' => true,
            'hasAbstracts' => true,
        ];

        $reference = Reference::withDoi($data['title'], new Doi($data['doi']['doi']), $data['bibId'], $data['label'], ['origin 1', 'origin 2'], [
            new ReferenceAuthorList([
                Author::asText($data['authorLists'][0]['authors'][0]['name']),
                Author::asLink(new Link($data['authorLists'][0]['authors'][1]['name'], $data['authorLists'][0]['authors'][1]['url'])),
            ], $data['authorLists'][0]['suffix']),
        ], [new Link($data['abstracts'][0]['name'], $data['abstracts'][0]['url'])]);

        $this->assertCount(1, $reference['abstracts']);
        $this->assertSame($data['abstracts'][0], $reference['abstracts'][0]->toArray());
        $this->assertCount(1, $reference['authorLists']);
        $this->assertSame($data['authorLists'][0], $reference['authorLists'][0]->toArray());
        $this->assertSame($data['label'], $reference['label']);
        $this->assertSame($data['origin'], $reference['origin']);
        $this->assertSame($data['doi'], $reference['doi']->toArray());
        $this->assertSame($data['title'], $reference['title']);
        $this->assertSame($data['hasAuthors'], $reference['hasAuthors']);
        $this->assertSame($data['hasAbstracts'], $reference['hasAbstracts']);
        $this->assertSame($data, $reference->toArray());

        $data = [
            'bibId' => 'full id 1',
            'abstracts' => [
                ['name' => 'Download', 'url' => '/download'],
            ],
            'authorLists' => [
                [
                    'authors' => [
                        ['name' => 'Person Foo', 'url' => '/foo'],
                        ['name' => 'Person Bar', 'url' => false],
                    ],
                    'suffix' => 'suffix',
                ],
            ],
            'origin' => 'origin 1. origin 2.',
            'label' => 'label',
            'title' => 'title of reference',
            'titleLink' => 'link',
            'hasAuthors' => true,
            'hasAbstracts' => true,
        ];

        $reference = Reference::withOutDoi(new Link($data['title'], $data['titleLink']), $data['bibId'], $data['label'], ['origin 1', 'origin 2'], [
            new ReferenceAuthorList([
                Author::asLink(new Link($data['authorLists'][0]['authors'][0]['name'], $data['authorLists'][0]['authors'][0]['url'])),
                Author::asText($data['authorLists'][0]['authors'][1]['name']),
            ], $data['authorLists'][0]['suffix']),
        ], [new Link($data['abstracts'][0]['name'], $data['abstracts'][0]['url'])]);

        $this->assertCount(1, $reference['abstracts']);
        $this->assertSame($data['abstracts'][0], $reference['abstracts'][0]->toArray());
        $this->assertCount(1, $reference['authorLists']);
        $this->assertSame($data['authorLists'][0], $reference['authorLists'][0]->toArray());
        $this->assertSame($data['label'], $reference['label']);
        $this->assertSame($data['origin'], $reference['origin']);
        $this->assertSame($data['bibId'], $reference['bibId']);
        $this->assertSame($data['title'], $reference['title']);
        $this->assertSame($data['titleLink'], $reference['titleLink']);
        $this->assertSame($data['hasAuthors'], $reference['hasAuthors']);
        $this->assertSame($data['hasAbstracts'], $reference['hasAbstracts']);
        $this->assertSame($data, $reference->toArray());
    }

    public function viewModelProvider() : array
    {
        return [
            'minimum with DOI' => [Reference::withDoi('title', new Doi('10.7554/eLife.10181.001'))],
            'complete with DOI' => [Reference::withDoi('title', new Doi('10.7554/eLife.10181.001'), 'id', 'label', ['origin'], [new ReferenceAuthorList([Author::asText('author')], 'suffix')], [new Link('abstract', 'link')])],
            'minimum without DOI' => [Reference::withOutDoi(new Link('title', 'title-link'))],
            'complete without DOI' => [Reference::withOutDoi(new Link('title', 'title-link'), 'id', 'label', ['origin'], [new ReferenceAuthorList([Author::asText('author')], 'suffix')], [new Link('abstract', 'link')])],
        ];
    }

    protected function expectedTemplate() : string
    {
        return 'resources/templates/reference.mustache';
    }
}
