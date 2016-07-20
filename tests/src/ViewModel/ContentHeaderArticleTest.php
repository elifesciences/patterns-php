<?php

namespace tests\eLife\Patterns\ViewModel;

use eLife\Patterns\ViewModel\Author;
use eLife\Patterns\ViewModel\AuthorList;
use eLife\Patterns\ViewModel\ContentHeaderArticle;
use eLife\Patterns\ViewModel\Date;
use eLife\Patterns\ViewModel\Image;
use eLife\Patterns\ViewModel\Institution;
use eLife\Patterns\ViewModel\InstitutionList;
use eLife\Patterns\ViewModel\Link;
use eLife\Patterns\ViewModel\Meta;
use eLife\Patterns\ViewModel\Picture;
use DateTimeImmutable;
use eLife\Patterns\ViewModel\SubjectList;

class ContentHeaderArticleTest extends ViewModelTest
{
    /**
     * @test
     */
    public function it_can_create_magazine()
    {
        $data = ContentHeaderFixtures::magazineFixture();
        $magazine = ContentHeaderArticle::magazine(
            $data['title'],
            $data['strapline'],
            $data['articleType'],
            AuthorList::asList(array_map(function ($item) {
                return new Author($item['name']);
            }, $data['authors']['list'])),
            new Picture(
                $data['download']['sources'],
                new Image(
                    $data['download']['fallback']['defaultPath'],
                    $this->srcsetToArray($data['download']['fallback']['srcset']),
                    $data['download']['fallback']['altText']
                )
            ),
            new SubjectList(array_map(function ($item) {
                return new Link($item['name'], $item['url']);
            }, $data['subjects']['list'])),
            $this->metaFromData($data['meta'])
        );
        $this->assertSameWithoutOrder($data, $magazine->toArray());
    }

    /**
     * @test
     */
    public function it_can_create_magazine_with_background()
    {
        $data = ContentHeaderFixtures::magazineBackgroundFixture();
        $magazine = ContentHeaderArticle::magazine(
            $data['title'],
            $data['strapline'],
            $data['articleType'],
            AuthorList::asList(array_map(function ($item) {
                return new Author($item['name']);
            }, $data['authors']['list'])),
            new Picture(
                $data['download']['sources'],
                new Image(
                    $data['download']['fallback']['defaultPath'],
                    $this->srcsetToArray($data['download']['fallback']['srcset']),
                    $data['download']['fallback']['altText']
                )
            ),
            new SubjectList(array_map(function ($item) {
                return new Link($item['name'], $item['url']);
            }, $data['subjects']['list'])),
            $this->metaFromData($data['meta']),
            null,
            true
        );
        $this->assertSameWithoutOrder($data, $magazine->toArray());
    }

    /**
     * @test
     */
    public function it_can_create_research()
    {
        $data = ContentHeaderFixtures::researchFixture();
        $research = ContentHeaderArticle::research(
            $data['title'],
            $data['articleType'],
            AuthorList::asList(array_map(function ($item) {
                return new Author($item['name']);
            }, $data['authors']['list'])),
            new SubjectList(array_map(function ($item) {
                return new Link($item['name'], $item['url']);
            }, $data['subjects']['list'])),
            new InstitutionList(array_map(function ($item) {
                return new Institution($item['name']);
            }, $data['institutions']['list'])),
            new Picture(
                $data['download']['sources'],
                new Image(
                    $data['download']['fallback']['defaultPath'],
                    $this->srcsetToArray($data['download']['fallback']['srcset']),
                    $data['download']['fallback']['altText']
                )
            ),
            $this->metaFromData($data['meta'])
        );
        $this->assertSameWithoutOrder($data, $research->toArray());
    }
    /**
     * @test
     */
    public function it_can_create_research_with_read_more()
    {
        $data = ContentHeaderFixtures::researchReadMoreFixture();
        $research = ContentHeaderArticle::researchReadMore(
            $data['title'],
            $data['articleType'],
            AuthorList::asReadMore($data['authors']['firstAuthorOnly']),
            new SubjectList(array_map(function ($item) {
                return new Link($item['name'], $item['url']);
            }, $data['subjects']['list'])),
            null,
            $this->metaFromData($data['meta'])
        );
        $this->assertSameWithoutOrder($data, $research->toArray());
    }

    /**
     * @wiptest
     */
    public function it_can_create_magazine_with_background_image()
    {
        $this->markTestSkipped('This is waiting for background image refactoring');
    }

    public function metaFromData($data) {
        return new Meta(
            $data['type'],
            new Date(new DateTimeImmutable($data['date']['forMachine'])),
            $data['typeLink']
        );
    }

    /**
     * @test
     */
    public function it_has_data()
    {
        $data = [];
    }

    public function viewModelProvider() : array
    {
        return [
            'Magazine' => [
                ContentHeaderArticle::magazine(
                    'title',
                    'strapline',
                    'Insight',
                    AuthorList::asList(array_map(function ($item) {
                        return new Author($item['name']);
                    }, [
                        ['name' => 'name1'],
                        ['name' => 'name2'],
                    ])),
                    new Picture([
                        [
                            'srcset' => '../../assets/img/icons/download-full.svg',
                            'media' => '(min-width: 35em)',
                            'type' => 'image/svg+xml',
                        ],
                        [
                            'srcset' => '../../assets/img/icons/download-full-1x.png',
                            'media' => '(min-width: 35em)',
                        ],
                        [
                            'srcset' => '../../assets/img/icons/download.svg',
                            'type' => 'image/svg+xml',
                        ],
                    ], new Image(
                            '../../assets/img/icons/download-full-1x.png',
                            [500 => '/path/to/image/500/wide'], 'Download icon')
                    ),
                    new SubjectList([ new Link('subject', '#') ]),
                    new Meta(
                        'Insight', new Date(new DateTimeImmutable('2015-12-15')), '#'
                    )
                ),
            ],
        ];
    }

    protected function expectedTemplate() : string
    {
        return '/elife/patterns/templates/content-header-article.mustache';
    }
}
