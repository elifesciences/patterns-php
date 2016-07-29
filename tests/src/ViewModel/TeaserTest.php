<?php

namespace tests\eLife\Patterns\ViewModel;

use eLife\Patterns\ViewModel\Teaser;
use eLife\Patterns\ViewModel\TeaserFooter;
use eLife\Patterns\ViewModel\TeaserImage;
use tests\eLife\Patterns\ViewModel\Partials\MetaFromData;

final class TeaserTest extends ViewModelTest
{

    use MetaFromData;

    protected function teaserImageFromData($data, $size = TeaserImage::STYLE_SMALL) {
        $data = array_merge([
            'defaultPath' => null,
            'altText' => null,
            'url' => null,
            'srcset' => null
        ], $data);
        $size = [$size];

        return new TeaserImage(
            $data['defaultPath'],
            $data['altText'],
            $data['url'],
            $this->srcsetToArray($data['srcset']),
            $size
        );
    }

    /**
     * @test
     */
    public function it_can_load_basic() {
        $data = TeaserFixtures::load(TeaserFixtures::BASIC);
        $actual = Teaser::basic(
            $data['title'],
            $data['url'],
            $this->teaserImageFromData($data['image'], TeaserImage::STYLE_SMALL),
            new TeaserFooter($this->metaFromData($data['footer']['meta']))
        );
        $this->assertSameWithoutOrder($data, $actual);
    }


    /**
     * @test
     */
    public function it_has_data()
    {
        $data = [
            'title' => 'the title'
        ];
        $teaser = Teaser::basic($data['title']);
        $this->assertSameWithoutOrder($data, $teaser);
    }

    public function viewModelProvider() : array
    {
        return [
            [
                Teaser::basic('wat')
            ]
        ];
    }

    protected function expectedTemplate() : string
    {
        return '/elife/patterns/templates/teaser.mustache';
    }
}
