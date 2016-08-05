<?php
/**
 * Created by PhpStorm.
 * User: Stephen
 * Date: 05/08/16
 * Time: 11:02
 */

namespace tests\eLife\Patterns\ViewModel;


use eLife\Patterns\ViewModel\Button;
use eLife\Patterns\ViewModel\Image;
use eLife\Patterns\ViewModel\Listing;
use eLife\Patterns\ViewModel\ListingItem;
use eLife\Patterns\ViewModel\Picture;
use eLife\Patterns\ViewModel\ProfileSnippet;
use eLife\Patterns\ViewModel\Teaser;
use eLife\Patterns\ViewModel\TeaserFooter;
use eLife\Patterns\ViewModel\TeaserImage;
use tests\eLife\Patterns\ViewModel\Partials\MetaFromData;
use tests\eLife\Patterns\ViewModel\Partials\TeaserImageFromData;

class ListingTest extends ViewModelTest
{
    use MetaFromData;
    use TeaserImageFromData;

    /**
     * @test
     */
    public function it_has_data()
    {
        $data = array(
            'loadMore' =>
                array(
                    'classes' => 'button--default',
                    'path' => '#',
                    'text' => 'load more',
                    'templateName' => 'load-more',
                ),
            'heading' => 'heading',
            'items' => self::getProfileSnippetSource()
        );
        $listing = Listing::withProfileSnippets(
            'heading',
            ListingItem::asLoadMoreLink(Button::loadMoreLink('load more', '#')),
            ...self::getProfileSnippets()
        );

        $this->assertSameWithoutOrder($data, $listing);
    }

    public static function getProfileSnippetSource()
    {
        return [
            [
                'picture' =>
                    [
                        'fallback' =>
                            [
                                'altText' => 'the alt text',
                                'defaultPath' => '/default/path',
                                'srcset' => '/path/to/image/500/wide 500w, /default/path 250w',
                                'classes' => 'profile-snippet__image',
                            ],
                        'sources' =>
                            [
                                [
                                    'srcset' => '/path/to/svg',
                                ],
                            ],
                        'pictureClasses' => 'profile-snippet__picture',
                    ],
                'title' => 'Title McTitle',
                'name' => 'Name McName',
            ],
            [
                'picture' =>
                    [
                        'fallback' =>
                            [
                                'altText' => 'the alt text',
                                'defaultPath' => '/default/path',
                                'srcset' => '/path/to/image/500/wide 500w, /default/path 250w',
                                'classes' => 'profile-snippet__image',
                            ],
                        'sources' =>
                            [
                                [
                                    'srcset' => '/path/to/svg',
                                ],
                            ],
                        'pictureClasses' => 'profile-snippet__picture',
                    ],
                'title' => 'Title McTitle',
                'name' => 'Name McName',
            ],
            [
                'picture' =>
                    [
                        'fallback' =>
                            [
                                'altText' => 'the alt text',
                                'defaultPath' => '/default/path',
                                'srcset' => '/path/to/image/500/wide 500w, /default/path 250w',
                                'classes' => 'profile-snippet__image',
                            ],
                        'sources' =>
                            [
                                [
                                    'srcset' => '/path/to/svg',
                                ],
                            ],
                        'pictureClasses' => 'profile-snippet__picture',
                    ],
                'title' => 'Title McTitle',
                'name' => 'Name McName',
            ],
        ];
    }

    public static function getProfileSnippets()
    {
        return [
            new ProfileSnippet(
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
            ),
            new ProfileSnippet(
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
            ),
            new ProfileSnippet(
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
            )
        ];
    }

    public function getTeasers() {
        $data = TeaserFixtures::load(TeaserFixtures::BASIC);
        $actual = Teaser::basic(
            $data['title'],
            $data['url'],
            $this->teaserImageFromData($data['image'], TeaserImage::STYLE_SMALL),
            TeaserFooter::forNonArticle($this->metaFromData($data['footer']['meta']))
        );
        return [$actual, $actual, $actual];
    }

    public function viewModelProvider() : array
    {
        return [
            [
                Listing::withProfileSnippets(
                    'heading',
                    ListingItem::asLoadMoreLink(Button::loadMoreLink('load more', '#')),
                    ...self::getProfileSnippets()
                )
            ],
            [
                Listing::withTeasers(
                    'heading',
                    ListingItem::asLoadMoreLink(Button::loadMoreLink('load more', '#')),
                    ...$this->getTeasers()
                )
            ]
        ];
    }

    protected function expectedTemplate() : string
    {
        return '/elife/patterns/templates/listing.mustache';
    }
}
