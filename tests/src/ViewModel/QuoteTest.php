<?php

namespace tests\eLife\Patterns\ViewModel;

use eLife\Patterns\ViewModel\Quote;
use PHPUnit\Framework\Attributes\Test;

final class QuoteTest extends ViewModelTest
{
    #[Test]
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

    public static function viewModelProvider() : array
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
