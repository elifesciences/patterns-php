<?php

namespace src\ViewModel;

use eLife\Patterns\ViewModel\Link;
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
            'quotation',
            'attribution',
            new Link('Link name', '#')
        );

        $data = [
            'quotation' => 'quotation',
            'attribution' => 'attribution',
            'link' => [
                'name' => 'Link name',
                'url' => '#',
            ],
        ];

        $this->assertSame($data, $testimonialWithLink->toArray());
    }

    public function viewModelProvider() : array
    {
        return [
            'complete' => [new TestimonialWithLink('quotation', 'attribution', new Link('#', 'Link name'))],
        ];
    }

    protected function expectedTemplate() : string
    {
        return 'resources/templates/testimonial-with-link.mustache';
    }
}
