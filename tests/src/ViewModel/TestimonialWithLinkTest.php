<?php

namespace src\ViewModel;

use eLife\Patterns\ViewModel\TestimonialWithLink;
use tests\eLife\Patterns\ViewModel\ViewModelTest;

final class TestimonialWithLinkTest extends ViewModelTest
{
    /**
     * @test
     */
    public function it_has_data()
    {
        $testimonialWithLink = new TestimonialWithLink();

        $data = [];

        $this->assertSame($data, $testimonialWithLink->toArray());
    }

    public function viewModelProvider() : array
    {
        return [
            'complete' => [new TestimonialWithLink()],
        ];
    }

    protected function expectedTemplate() : string
    {
        return 'resources/templates/testimonial-with-link.mustache';
    }
}
