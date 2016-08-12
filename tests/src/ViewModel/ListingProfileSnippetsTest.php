<?php

namespace tests\eLife\Patterns\ViewModel;

use eLife\Patterns\ViewModel\Image;
use eLife\Patterns\ViewModel\Link;
use eLife\Patterns\ViewModel\ListingProfileSnippets;
use eLife\Patterns\ViewModel\Picture;
use eLife\Patterns\ViewModel\ProfileSnippet;
use eLife\Patterns\ViewModel\SeeMoreLink;

final class ListingProfileSnippetsTest extends ViewModelTest
{
    /**
     * @test
     */
    public function it_has_data()
    {
        $data = [
            'seeMoreLink' => [
                'name' => 'See more',
                'url' => '#',
            ],
            'items' => [
                self::getProfileSnippetData(),
                self::getProfileSnippetData(),
                self::getProfileSnippetData(),
            ],
        ];
        $listingProfileSnippets = ListingProfileSnippets::withSeeMoreLink(
            [
                self::getProfileSnippetFixture(),
                self::getProfileSnippetFixture(),
                self::getProfileSnippetFixture(),
            ],
            new SeeMoreLink(new Link($data['seeMoreLink']['name'], $data['seeMoreLink']['url']))
        );
        $this->assertSameWithoutOrder($data, $listingProfileSnippets);
    }

    public static function getProfileSnippetData() : array
    {
        return self::getProfileSnippetFixture()->toArray();
    }

    public static function getProfileSnippetFixture() : ProfileSnippet
    {
        return new ProfileSnippet(
            'Name McName',
            'Title McTitle',
            new Picture(
                [['srcset' => '/path/to/svg']],
                new Image(
                    '/default/path',
                    [500 => '/path/to/image/500/wide', 250 => '/default/path'],
                    'the alt text'
                )
            )
        );
    }

    public function viewModelProvider() : array
    {
        return [
            [
                ListingProfileSnippets::withSeeMoreLink(
                    [
                        self::getProfileSnippetFixture(),
                        self::getProfileSnippetFixture(),
                        self::getProfileSnippetFixture(),
                    ],
                    new SeeMoreLink(new Link('name', '#'))
                ),
            ],
            [
                ListingProfileSnippets::basic([self::getProfileSnippetFixture(), self::getProfileSnippetFixture(), self::getProfileSnippetFixture()], 'Some heading'),
            ],
        ];
    }

    protected function expectedTemplate() : string
    {
        return '/elife/patterns/templates/listing-profile-snippets.mustache';
    }
}
