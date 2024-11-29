<?php

namespace tests\eLife\Patterns\ViewModel;

use eLife\Patterns\ViewModel\Link;
use eLife\Patterns\ViewModel\SeeMoreLink;

final class SeeMoreLinkTest extends ViewModelTest
{
    /**
     * @test
     */
    public function it_has_data()
    {
        $data = [
            'link' => [
                'name' => 'something',
                'url' => 'http://google.com',
                'ariaLabel' => 'Related articles'
            ],
            'isInline' => true,
        ];

        $link = new SeeMoreLink(new Link($data['link']['name'], $data['link']['url'], $data['link']['ariaLabel']), $data['isInline']);

        $this->assertSame($data['link']['name'], $link['link']['name'], 'The names should match');
        $this->assertSame($data['link']['url'], $link['link']['url'], 'The URLs should match');
        $this->assertSame($data['link']['ariaLabel'], $link['link']['ariaLabel'], 'The ariaLabel should match');
        $this->assertSame($data['isInline'], $link['isInline'], 'The isInline property should be true');
        $this->assertSame($data, array_merge($link->toArray(), ['isInline' => true]));
    }

    public function it_must_have_a_url()
    {
        $this->expectException(InvalidArgumentException::class);

        new SeeMoreLink(new Link('something'));
    }

    public function viewModelProvider(): array
    {
        return [
            'complete' => [new SeeMoreLink(new Link('something', 'http://google.com', 'Research article', false, ['key' => 'value']))],
            'link only' => [new SeeMoreLink(new Link('something', 'http://google.com'))],
        ];
    }

    protected function expectedTemplate(): string
    {
        return 'resources/templates/see-more-link.mustache';
    }
}
