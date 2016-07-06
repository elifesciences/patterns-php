<?php

namespace tests\eLife\Patterns\ViewModel;

use eLife\Patterns\ViewModel\PullQuote;

class PullQuoteTest extends ViewModelTest
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
        $pullQuote = new PullQuote('quote', 'cite <a href="#">with link</a>');

        $this->assertSame($data['quote'], $pullQuote['quote']);
        $this->assertSame($data['cite'], $pullQuote['cite']);
        $this->assertSame($data, $pullQuote->toArray());
    }

    public function viewModelProvider() : array
    {
        return [
            'with quote and cite' => [new PullQuote('quote', 'cite')],
            'with links in cite' => [new PullQuote('quote', 'cite <a href="#">with link</a>')],
        ];
    }

    protected function expectedTemplate() : string
    {
        return '/elife/patterns/templates/pull-quote.mustache';
    }
}
