<?php

namespace tests\eLife\Patterns\ViewModel;

use eLife\Patterns\ViewModel\Listing;
use InvalidArgumentException;

final class ListingTest extends ViewModelTest
{
    /**
     * @test
     */
    public function it_has_data()
    {
        $data = [
            'isOrdered' => true,
            'prefix' => 'roman-upper',
            'items' => ['foo', 'bar'],
        ];

        $listing = Listing::ordered(['foo', 'bar'], 'roman-upper');

        $this->assertSame($data['isOrdered'], $listing['isOrdered']);
        $this->assertSame($data['prefix'], $listing['prefix']);
        $this->assertSame($data['items'], $listing['items']);
        $this->assertSame($data, $listing->toArray());

        $data = [
            'isOrdered' => false,
            'items' => ['foo', 'bar'],
        ];

        $listing = Listing::unordered(['foo', 'bar']);

        $this->assertSame($data['isOrdered'], $listing['isOrdered']);
        $this->assertSame($data['items'], $listing['items']);
        $this->assertSame($data, $listing->toArray());

        $data = [
            'isOrdered' => false,
            'prefix' => 'bullet',
            'items' => ['foo', 'bar'],
            'classes' => 'list--teaser',
        ];

        $listing = Listing::forTeaser(['foo', 'bar'], 'bullet');

        $this->assertSame($data['isOrdered'], $listing['isOrdered']);
        $this->assertSame($data['items'], $listing['items']);
        $this->assertSame($data, $listing->toArray());
    }

    /**
     * @test
     */
    public function it_must_have_a_valid_prefix()
    {
        $this->expectException(InvalidArgumentException::class);

        Listing::unordered(['foo'], 'bar');
    }

    /**
     * @test
     */
    public function it_must_have_items()
    {
        $this->expectException(InvalidArgumentException::class);

        Listing::unordered([]);
    }

    /**
     * @test
     */
    public function it_must_have_string_items()
    {
        $this->expectException(InvalidArgumentException::class);

        Listing::unordered([$this]);
    }

    public function viewModelProvider() : array
    {
        return [
            'ordered' => [Listing::ordered(['foo', 'bar'], 'roman-upper')],
            'unordered' => [Listing::unordered(['foo', 'bar'], 'bullet')],
            'no prefix' => [Listing::unordered(['foo', 'bar'])],
            'for teaser' => [Listing::forTeaser(['foo', 'bar'])],
        ];
    }

    protected function expectedTemplate() : string
    {
        return 'resources/templates/list.mustache';
    }
}
