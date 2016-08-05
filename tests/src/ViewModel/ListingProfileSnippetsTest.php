<?php

namespace tests\eLife\Patterns\ViewModel;

use eLife\Patterns\ViewModel\Image;
use eLife\Patterns\ViewModel\Link;
use eLife\Patterns\ViewModel\ListingProfileSnippets;
use eLife\Patterns\ViewModel\Picture;
use eLife\Patterns\ViewModel\ProfileSnippet;
use eLife\Patterns\ViewModel\SeeMoreLink;

class ListingProfileSnippetsTest extends ViewModelTest
{
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

    public static function getProfileSnippetData() : array
    {
        return self::getProfileSnippetFixture()->toArray();
    }

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
        $listingProfileSnippets = ListingProfileSnippets::withoutHeading(
            new SeeMoreLink(new Link($data['seeMoreLink']['name'], $data['seeMoreLink']['url'])),
            self::getProfileSnippetFixture(),
            self::getProfileSnippetFixture(),
            self::getProfileSnippetFixture()
        );
        $this->assertSameWithoutOrder($data, $listingProfileSnippets);
    }

    public function viewModelProvider() : array
    {
        return [
            [
                ListingProfileSnippets::withoutHeading(new SeeMoreLink(new Link('name', '#')), self::getProfileSnippetFixture(), self::getProfileSnippetFixture(), self::getProfileSnippetFixture()),
            ],
            [
                ListingProfileSnippets::withHeading('Some heading', new SeeMoreLink(new Link('name', '#')), self::getProfileSnippetFixture(), self::getProfileSnippetFixture(), self::getProfileSnippetFixture()),
            ],
        ];
    }

    protected function expectedTemplate() : string
    {
        return '/elife/patterns/templates/listing-profile-snippets.mustache';
    }
}
