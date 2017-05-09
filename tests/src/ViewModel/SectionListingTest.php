<?php

namespace tests\eLife\Patterns\ViewModel;

use eLife\Patterns\ViewModel\Link;
use eLife\Patterns\ViewModel\ListHeading;
use eLife\Patterns\ViewModel\SectionListing;
use InvalidArgumentException;

final class SectionListingTest extends ViewModelTest
{
    /**
     * @test
     */
    public function it_has_data()
    {
        $data = [
            'id' => 'id',
            'sections' => [
                [
                    'name' => 'subject 1',
                    'url' => '#',
                ],
                [
                    'name' => 'subject 2',
                    'url' => '#',
                ],
            ],
            'listHeading' => [
                'heading' => 'heading',
            ],
            'singleLine' => true,
            'labelledBy' => 'labelledBy',
        ];

        $siteLinksList = new SectionListing(
            $data['id'],
            [
                new Link($data['sections'][0]['name'], $data['sections'][0]['url']),
                new Link($data['sections'][1]['name'], $data['sections'][1]['url']),
            ],
            new ListHeading($data['listHeading']['heading']),
            $data['singleLine'],
            $data['labelledBy']
        );

        $this->assertSame($data, $siteLinksList->toArray());
    }

    /**
     * @test
     */
    public function it_must_have_an_id()
    {
        $this->expectException(InvalidArgumentException::class);

        new SectionListing('', [new Link('subject', 'url')], new ListHeading('heading'));
    }

    public function viewModelProvider() : array
    {
        return [
            'minimum' => [new SectionListing('id', [new Link('subject', 'url')], new ListHeading('heading'))],
            'complete' => [new SectionListing('id', [new Link('subject', 'url')], new ListHeading('heading'), true, 'labelledBy')],
        ];
    }

    protected function expectedTemplate() : string
    {
        return 'resources/templates/section-listing.mustache';
    }
}
