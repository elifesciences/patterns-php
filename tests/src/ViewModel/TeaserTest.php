<?php

namespace tests\eLife\Patterns\ViewModel;

use Assert\InvalidArgumentException;
use DateTimeImmutable;
use eLife\Patterns\ViewModel\ContextLabel;
use eLife\Patterns\ViewModel\Date;
use eLife\Patterns\ViewModel\Link;
use eLife\Patterns\ViewModel\Teaser;
use eLife\Patterns\ViewModel\TeaserFooter;
use eLife\Patterns\ViewModel\TeaserImage;
use tests\eLife\Patterns\ViewModel\Partials\MetaFromData;
use tests\eLife\Patterns\ViewModel\Partials\TeaserImageFromData;

final class TeaserTest extends ViewModelTest
{
    use MetaFromData;
    use TeaserImageFromData;

    /**
     * @test
     */
    public function it_can_load_basic()
    {
        $data = TeaserFixtures::load(TeaserFixtures::BASIC);
        $actual = Teaser::basic(
            $data['title'],
            $data['url'],
            $this->teaserImageFromData($data['image'], TeaserImage::STYLE_SMALL),
            TeaserFooter::forNonArticle($this->metaFromData($data['footer']['meta']))
        );
        $this->assertSameWithoutOrder($data, $actual);
    }

    /**
     * @test
     */
    public function it_can_load_main()
    {
        $data = TeaserFixtures::load(TeaserFixtures::MAIN);
        $actual = Teaser::main(
            $data['title'],
            $data['url'],
            $data['content'],
            $data['secondaryInfo'],
            new ContextLabel(...array_map(function ($item) {
                return new Link($item['name'], $item['url']);
            }, $data['contextLabel']['list'])),
            null,
            TeaserFooter::forArticle(
                $this->metaFromData($data['footer']['meta']),
                $data['footer']['publishState']['vor'],
                '/'
            )
        );
        $this->assertSameWithoutOrder($data, $actual);
    }

    /**
     * @test
     */
    public function it_can_load_main_small_image()
    {
        $data = TeaserFixtures::load(TeaserFixtures::MAIN_SMALL_IMAGE);
        $actual = Teaser::main(
            $data['title'],
            $data['url'],
            $data['content'],
            $data['secondaryInfo'],
            new ContextLabel(...array_map(function ($item) {
                return new Link($item['name'], $item['url']);
            }, $data['contextLabel']['list'])),
            $this->teaserImageFromData($data['image'], TeaserImage::STYLE_SMALL),
            TeaserFooter::forArticle(
                $this->metaFromData($data['footer']['meta']),
                $data['footer']['publishState']['vor'],
                '/'
            )
        );
        $this->assertSameWithoutOrder($data, $actual);
    }

    /**
     * @test
     */
    public function it_can_load_main_big_image()
    {
        $data = TeaserFixtures::load(TeaserFixtures::MAIN_BIG_IMAGE);
        $actual = Teaser::main(
            $data['title'],
            $data['url'],
            $data['content'],
            $data['secondaryInfo'],
            new ContextLabel(...array_map(function ($item) {
                return new Link($item['name'], $item['url']);
            }, $data['contextLabel']['list'])),
            $this->teaserImageFromData($data['image'], TeaserImage::STYLE_BIG),
            TeaserFooter::forArticle(
                $this->metaFromData($data['footer']['meta']),
                $data['footer']['publishState']['vor'],
                '/'
            )
        );
        $this->assertSameWithoutOrder($data, $actual);
    }

    /**
     * @test
     */
    public function it_can_load_secondary()
    {
        $data = TeaserFixtures::load(TeaserFixtures::SECONDARY);
        $actual = Teaser::secondary(
            $data['title'],
            $data['url'],
            $data['secondaryInfo'],
            new ContextLabel(...array_map(function ($item) {
                return new Link($item['name'], $item['url']);
            }, $data['contextLabel']['list'])),
            null,
            TeaserFooter::forNonArticle(
                $this->metaFromData($data['footer']['meta'])
            )
        );
        $this->assertSameWithoutOrder($data, $actual);
    }

    /**
     * @test
     */
    public function it_can_load_secondary_small_image()
    {
        $data = TeaserFixtures::load(TeaserFixtures::SECONDARY_SMALL_IMAGE);
        $actual = Teaser::secondary(
            $data['title'],
            $data['url'],
            $data['secondaryInfo'],
            new ContextLabel(...array_map(function ($item) {
                return new Link($item['name'], $item['url']);
            }, $data['contextLabel']['list'])),
            $this->teaserImageFromData($data['image'], TeaserImage::STYLE_SMALL),
            TeaserFooter::forNonArticle(
                $this->metaFromData($data['footer']['meta'])
            )
        );
        $this->assertSameWithoutOrder($data, $actual);
    }

    /**
     * @test
     */
    public function it_can_load_secondary_big_image()
    {
        $data = TeaserFixtures::load(TeaserFixtures::SECONDARY_BIG_IMAGE);
        $actual = Teaser::secondary(
            $data['title'],
            $data['url'],
            $data['secondaryInfo'],
            new ContextLabel(...array_map(function ($item) {
                return new Link($item['name'], $item['url']);
            }, $data['contextLabel']['list'])),
            $this->teaserImageFromData($data['image'], TeaserImage::STYLE_BIG),
            TeaserFooter::forNonArticle(
                $this->metaFromData($data['footer']['meta'])
            )
        );
        $this->assertSameWithoutOrder($data, $actual);
    }

    /**
     * @test
     */
    public function it_can_load_related_item()
    {
        $data = TeaserFixtures::load(TeaserFixtures::RELATED_ITEM);
        $actual = Teaser::relatedItem(
            $data['title'],
            $data['url'],
            $data['secondaryInfo'],
            new ContextLabel(...array_map(function ($item) {
                return new Link($item['name'], $item['url']);
            }, $data['contextLabel']['list'])),
            null,
            TeaserFooter::forNonArticle(
                $this->metaFromData($data['footer']['meta'])
            )
        );
        $this->assertSameWithoutOrder($data, $actual);
    }

    /**
     * @test
     */
    public function it_can_load_main_event()
    {
        $data = TeaserFixtures::load(TeaserFixtures::MAIN_EVENT);
        $actual = Teaser::event(
            $data['title'],
            $data['url'],
            $data['secondaryInfo'],
            new Date(new DateTimeImmutable($data['eventDate']['forMachine']))
        );
        $this->assertSameWithoutOrder($data, $actual);
    }

    /**
     * @test
     */
    public function it_can_load_secondary_event()
    {
        $data = TeaserFixtures::load(TeaserFixtures::SECONDARY_EVENT);
        $actual = Teaser::event(
            $data['title'],
            $data['url'],
            $data['secondaryInfo'],
            new Date(new DateTimeImmutable($data['eventDate']['forMachine'])),
            true
        );
        $this->assertSameWithoutOrder($data, $actual);
    }

    /**
     * @test
     */
    public function it_can_load_chapter_listing_item()
    {
        $data = TeaserFixtures::load(TeaserFixtures::CHAPTER_LISTING_ITEM);
        $actual = Teaser::chapterListingItem(
            $data['title'],
            $data['url'],
            $data['content'],
            new ContextLabel(...array_map(function ($item) {
                return new Link($item['name'], $item['url']);
            }, $data['contextLabel']['list'])),
            TeaserFooter::forNonArticle(
                $this->metaFromData($data['footer']['meta'])
            )
        );
        $this->assertSameWithoutOrder($data, $actual);
    }

    /**
     * @test
     */
    public function it_can_load_grid_style_labs()
    {
        $data = TeaserFixtures::load(TeaserFixtures::GRID_STYLE_LABS);
        $actual = Teaser::withGrid(
            $data['title'],
            $data['url'],
            $data['content'],
            null,
            $this->teaserImageFromData($data['image'], TeaserImage::STYLE_PROMINENT),
            TeaserFooter::forNonArticle(
                $this->metaFromData($data['footer']['meta'])
            )
        );
        $this->assertSameWithoutOrder($data, $actual);
    }

    /**
     * @test
     */
    public function it_can_load_grid_style_podcast()
    {
        $data = TeaserFixtures::load(TeaserFixtures::GRID_STYLE_PODCAST);
        $actual = Teaser::withGrid(
            $data['title'],
            $data['url'],
            $data['content'],
            $data['secondaryInfo'],
            $this->teaserImageFromData($data['image'], TeaserImage::STYLE_PROMINENT),
            TeaserFooter::forNonArticle(
                $this->metaFromData($data['footer']['meta'])
            )
        );
        $this->assertSameWithoutOrder($data, $actual);
    }

    /**
     * @test
     */
    public function it_cant_load_context_label_without_arguments()
    {
        $this->expectException(InvalidArgumentException::class);
        new ContextLabel();
    }

    /**
     * @test
     */
    public function it_has_data()
    {
        $data = [
            'title' => 'the title',
        ];
        $teaser = Teaser::basic($data['title']);
        $this->assertSameWithoutOrder($data, $teaser);
    }

    public function viewModelProvider() : array
    {
        return [
            [
                Teaser::basic('wat'),
            ],
        ];
    }

    protected function expectedTemplate() : string
    {
        return '/elife/patterns/templates/teaser.mustache';
    }
}
