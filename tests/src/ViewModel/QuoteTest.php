<?php

namespace tests\eLife\Patterns\ViewModel;

use eLife\Patterns\ViewModel\Quote;

final class QuoteTest extends ViewModelTest
{
    /**
     * @test
     */
    public function it_has_data()
    {
        $data = [
            'quote' => 'quote',
            'cite' => 'cite <a href="#">with link</a>',
        ];
        $quote = new Quote('quote', 'cite <a href="#">with link</a>');

        $this->assertSame($data['quote'], $quote['quote']);
        $this->assertSame($data['cite'], $quote['cite']);
        $this->assertSame($data, $quote->toArray());
    }

    public function viewModelProvider() : array
    {
        return [
            'with quote' => [new Quote('quote')],
            'with quote and cite' => [new Quote('quote', 'cite')],
            'with links in cite' => [new Quote('quote', 'cite <a href="#">with link</a>')],
        ];
    }

    protected function expectedTemplate() : string
    {
        return 'resources/templates/quote.mustache';
    }
}
