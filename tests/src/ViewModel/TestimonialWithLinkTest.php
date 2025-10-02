<?php

namespace src\ViewModel;

use eLife\Patterns\ViewModel\Link;
use eLife\Patterns\ViewModel\SimpleImage;
use eLife\Patterns\ViewModel\TestimonialWithLink;
use tests\eLife\Patterns\ViewModel\ViewModelTest;

final class TestimonialWithLinkTest extends ViewModelTest
{
    /**
     * @test
     */
    public function it_has_data()
    {
        $testimonialWithLink = new TestimonialWithLink(
            new SimpleImage('/foo.png', 'altText'),
            'quotation of the day.',
            'attribution',
            new Link('Link name', '#')
        );

        $data = [
            'image' => [
                'path' => '/foo.png',
                'altText' => 'altText',
            ],
            'quotation' => 'quotation of the ',
            'quotationLastWord' => 'day.',
            'attribution' => 'attribution',
            'link' => [
                'name' => 'Link name',
                'url' => '#',
            ],
        ];

        $this->assertSame($data, $testimonialWithLink->toArray());
    }

    /**
     * @test
     */
    public function it_may_have_a_one_word_quotation()
    {
        $testimonialWithLink = new TestimonialWithLink(
            new SimpleImage('/foo.png', 'altText'),
            'quotation',
            'attribution',
            new Link('Link name', '#')
        );

        $data = $testimonialWithLink->toArray();
        $this->assertSame('quotation', $data['quotationLastWord']);
        $this->assertArrayNotHasKey('quotation', $data);
    }

    public function viewModelProvider() : array
    {
        return [
            'complete' => [new TestimonialWithLink(new SimpleImage('/foo.png', 'altText'), 'quotation of the day', 'attribution', new Link('#', 'Link name'))],
        ];
    }

    protected function expectedTemplate() : string
    {
        return 'resources/templates/testimonial-with-link.mustache';
    }
}
