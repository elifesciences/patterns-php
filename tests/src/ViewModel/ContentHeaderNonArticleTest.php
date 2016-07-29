<?php

namespace tests\eLife\Patterns\ViewModel;

use eLife\Patterns\ViewModel\BackgroundImage;
use eLife\Patterns\ViewModel\Button;
use eLife\Patterns\ViewModel\ContentHeaderNonArticle;
use eLife\Patterns\ViewModel\FormLabel;
use eLife\Patterns\ViewModel\Image;
use eLife\Patterns\ViewModel\Link;
use eLife\Patterns\ViewModel\Meta;
use DateTimeImmutable;
use eLife\Patterns\ViewModel\Date;
use eLife\Patterns\ViewModel\Picture;
use eLife\Patterns\ViewModel\PodcastDownload;
use eLife\Patterns\ViewModel\Select;
use eLife\Patterns\ViewModel\SelectNav;
use eLife\Patterns\ViewModel\SelectOption;
use tests\eLife\Patterns\ViewModel\Partials\MetaFromData;

final class ContentHeaderNonArticleTest extends ViewModelTest
{

    use MetaFromData;

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
        $this->assertSameWithoutOrder($data, $header);
    }

    private function hasBackground($data) : bool
    {
        return (strpos($data['rootClasses'], 'content-header-nonarticle--background') !== false);
    }

    /**
     * @test
     */
    public function it_can_create_basic_with_strapline()
    {
        $data = ContentHeaderFixtures::nonArticleBasicWithStraplineFixture();
        $header = ContentHeaderNonArticle::basic($data['title'], $this->hasBackground($data), $data['strapline']);
        $this->assertSameWithoutOrder($data, $header);
    }

    /**
     * @test
     */
    public function it_can_create_basic_with_strapline_background()
    {
        $data = ContentHeaderFixtures::nonArticleBasicWithStraplineBackgroundFixture();
        $header = ContentHeaderNonArticle::basic($data['title'], $this->hasBackground($data), $data['strapline']);
        $this->assertSameWithoutOrder($data, $header);
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
            $this->metaFromData($data['meta']),
            $this->backgroundImageFromData($data['backgroundImage'])
        );
        $this->assertSameWithoutOrder($data, $header);
    }

    /**
     * @test
     */
    public function it_can_create_basic_with_strapline_background_image()
    {
        $data = ContentHeaderFixtures::nonArticleBasicWithStraplineBackgroundImageFixture();
        $header = ContentHeaderNonArticle::basic(
            $data['title'],
            $this->hasBackground($data),
            $data['strapline'],
            null,
            null,
            $this->backgroundImageFromData($data['backgroundImage'])
        );
        $this->assertSameWithoutOrder($data, $header);
    }

    private function buttonFromData(array $data, $form = false) : Button
    {
        $style = strpos($data['classes'], 'button--outline') !== false ? Button::STYLE_OUTLINE : Button::STYLE_DEFAULT;
        if (strpos($data['classes'], 'button--small') !== false) {
            $size = Button::SIZE_SMALL;
        } elseif (strpos($data['classes'], 'button--extra-small') !== false) {
            $size = Button::SIZE_EXTRA_SMALL;
        } else {
            $size = Button::SIZE_MEDIUM;
        }
        if ($form) {
            return Button::form($data['text'], $data['type'], $size, $style);
        }

        return Button::link($data['text'], $data['path'], $size, $style);
    }

    private function backgroundImageFromData(array $data) : BackgroundImage
    {
        return new BackgroundImage(
            $data['lowResImageSource'],
            $data['highResImageSource']
        );
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
            Profile::asLink(new Link($data['profile']['name'], $data['profile']['link']), $data['profile']['avatar']),
            $this->backgroundImageFromData($data['backgroundImage'])
        );

        $this->assertSameWithoutOrder($data, $header);
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
            $this->buttonFromData($data['button']),
            $this->backgroundImageFromData($data['backgroundImage'])
        );
        $this->assertSameWithoutOrder($data, $header);
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
            ),
            $this->backgroundImageFromData($data['backgroundImage'])
        );
        $this->assertSameWithoutOrder($data, $header);
    }

    /**
     * @test
     */
    public function it_can_create_podcast()
    {
        $data = ContentHeaderFixtures::nonArticlePodcastFixture();
        $header = ContentHeaderNonArticle::podcast(
            $data['title'],
            $this->hasBackground($data),
            $data['strapline'],
            null,
            $this->metaFromData($data['meta']),
            $this->backgroundImageFromData($data['backgroundImage']),
            new PodcastDownload('#',
                new Picture(
                    $data['download']['picture']['sources'],
                    new Image(
                        $data['download']['picture']['fallback']['defaultPath'],
                        $this->srcsetToArray($data['download']['picture']['fallback']['srcset']),
                        $data['download']['picture']['fallback']['altText']
                    )
                )
            )
        );
        $this->assertSameWithoutOrder($data, $header);
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
