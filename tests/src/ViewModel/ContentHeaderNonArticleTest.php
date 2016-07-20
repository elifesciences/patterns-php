<?php

namespace tests\eLife\Patterns\ViewModel;

use eLife\Patterns\ViewModel\Button;
use eLife\Patterns\ViewModel\ContentHeaderNonArticle;
use eLife\Patterns\ViewModel\FormLabel;
use eLife\Patterns\ViewModel\Link;
use eLife\Patterns\ViewModel\Meta;
use DateTimeImmutable;
use eLife\Patterns\ViewModel\Date;
use eLife\Patterns\ViewModel\Select;
use eLife\Patterns\ViewModel\SelectNav;
use eLife\Patterns\ViewModel\SelectOption;

final class ContentHeaderNonArticleTest extends ViewModelTest
{
    /**
     * @test
     */
    public function it_has_data()
    {
        $data = ContentHeaderFixtures::nonArticleBasicFixture();
        $header = ContentHeaderNonArticle::basic(
            $data['title'],
            $this->hasBackground($data)
        );
        $this->assertSameWithoutOrder($header, $data);
    }

    private function hasBackground($data) : bool
    {
        return (strpos($data['rootClasses'], 'content-header-nonarticle--background') !== -1);
    }

    /**
     * @test
     */
    public function it_can_create_basic_with_strapline()
    {
        $data = ContentHeaderFixtures::nonArticleBasicWithStraplineFixture();
        $header = ContentHeaderNonArticle::basic($data['title'], $this->hasBackground($data), $data['strapline']);
        $this->assertSameWithoutOrder($header, $data);
    }

    /**
     * @test
     */
    public function it_can_create_basic_with_strapline_background()
    {
        $data = ContentHeaderFixtures::nonArticleBasicWithStraplineBackgroundFixture();
        $header = ContentHeaderNonArticle::basic($data['title'], $this->hasBackground($data), $data['strapline']);
        $this->assertSameWithoutOrder($header, $data);
    }

    /**
     * @skip
     */
    public function it_can_create_basic_with_strapline_background_image()
    {
        // Waiting for background image refactor.
    }

    /**
     * @test
     */
    public function it_can_create_basic_with_strapline_cta_meta_background()
    {
        $data = ContentHeaderFixtures::nonArticleBasicWithStraplineBackgroundCtaMetaFixture();
        $header = ContentHeaderNonArticle::basic(
            $data['title'],
            $this->hasBackground($data),
            $data['strapline'],
            $this->buttonFromData($data['button']),
            $this->metaFromData($data['meta'])
        );
        $this->assertSameWithoutOrder($header, $data);
    }

    private function buttonFromData(array $data, $form = false) : Button
    {
        $style = strpos($data['classes'], 'button--outline') !== -1 ? Button::STYLE_OUTLINE : Button::STYLE_DEFAULT;
        if (strpos($data['classes'], 'button--small')) {
            $size = Button::SIZE_SMALL;
        } elseif (strpos($data['classes'], 'button--extra-small')) {
            $size = Button::SIZE_EXTRA_SMALL;
        } else {
            $size = Button::SIZE_MEDIUM;
        }
        if ($form) {
            return Button::form($data['text'], $data['type'], $size, $style);
        }

        return Button::link($data['text'], $data['path'], $size, $style);
    }

    private function metaFromData(array $data) : Meta
    {
        if (isset($data['url'])) {
            return Meta::withLink(
                new Link($data['text'], $data['url']),
                new Date(new DateTimeImmutable($data['date']['forMachine']))
            );
        }
        if (isset($data['text'])) {
            return Meta::withText(
                $data['text'],
                new Date(new DateTimeImmutable($data['date']['forMachine']))
            );
        }
        // Throw maybe? Or expected.
        return;
    }

    /**
     * @test
     */
    public function it_can_create_curated_content_listing()
    {
        $data = ContentHeaderFixtures::nonArticleCuratedContent();
        $header = ContentHeaderNonArticle::curatedContentListing(
            $data['title'],
            $this->hasBackground($data),
            $data['strapline'],
            $this->buttonFromData($data['button']),
            $this->metaFromData($data['meta']),
            Profile::asLink(new Link($data['profile']['name'], $data['profile']['link']), $data['profile']['avatar'])
        );
        $this->assertSameWithoutOrder($header, $data);
    }

    /**
     * @test
     */
    public function it_can_create_article_subject()
    {
        $data = ContentHeaderFixtures::nonArticleSubject();
        $header = ContentHeaderNonArticle::subject(
            $data['title'],
            $this->hasBackground($data),
            $this->buttonFromData($data['button'])
        );
        $this->assertSameWithoutOrder($header, $data);
    }

    /**
     * @test
     */
    public function it_can_create_archive()
    {
        $data = ContentHeaderFixtures::nonArticleArchiveFixture();
        $header = ContentHeaderNonArticle::archive(
            $data['title'],
            $this->hasBackground($data),
            new SelectNav(
                $data['selectNav']['route'],
                new Select(
                    $data['selectNav']['select']['id'],
                    array_map(function ($option) {
                        return new SelectOption($option['value'], $option['displayValue']);
                    }, $data['selectNav']['select']['options']),
                    new FormLabel(
                        $data['selectNav']['select']['label']['labelText'],
                        $data['selectNav']['select']['label']['for'],
                        $data['selectNav']['select']['label']['isVisuallyHidden']
                    )
                ),
                $this->buttonFromData($data['selectNav']['button'], true)
            )
        );
        $this->assertSameWithoutOrder($header, $data);
    }

    public function viewModelProvider() : array
    {
        return [
            [ContentHeaderNonArticle::basic('title')],
        ];
    }

    protected function expectedTemplate() : string
    {
        return '/elife/patterns/templates/content-header-non-article.mustache';
    }
}
