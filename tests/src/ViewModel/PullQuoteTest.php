<?php

namespace tests\eLife\Patterns\ViewModel;

use eLife\Patterns\ViewModel\PullQuote;

final class PullQuoteTest extends ViewModelTest
{
    /**
     * @test
     */
    public function it_has_data()
    {
        $data = [
            'quote' => 'quote',
            'cite' => 'cite <a href="#">with link</a>',
            'asPara' => true,
        ];
        $pullQuote = new PullQuote('quote', 'cite <a href="#">with link</a>');

        $this->assertSame($data['quote'], $pullQuote['quote']);
        $this->assertSame($data['cite'], $pullQuote['cite']);
        $this->assertSame($data, $pullQuote->toArray());
    }

    public function viewModelProvider() : array
    {
        return [
            'with quote' => [new PullQuote('quote')],
            'with quote and cite' => [new PullQuote('quote', 'cite')],
            'with links in cite' => [new PullQuote('quote', 'cite <a href="#">with link</a>')],
            'with links in cite not paragraph' => [new PullQuote('quote', 'cite <a href="#">with link</a>', false)],
        ];
    }

    protected function expectedTemplate() : string
    {
        return 'resources/templates/pull-quote.mustache';
    }
}
