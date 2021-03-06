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
            'name' => 'something',
            'url' => 'http://google.com',
            'isInline' => true,
        ];

        $link = new SeeMoreLink(new Link($data['name'], $data['url']), $data['isInline']);

        $this->assertSame($data['name'], $link['name'], 'The names should match');
        $this->assertSame($data['url'], $link['url'], 'The URLs should match');
        $this->assertSame($data['isInline'], $link['isInline'], 'The isInline property should be true');
        $this->assertSame($data, array_merge($link->toArray(), ['isInline' => true]));
    }

    public function viewModelProvider() : array
    {
        return [
            [new SeeMoreLink(new Link('something', 'http://google.com'))],
        ];
    }

    protected function expectedTemplate() : string
    {
        return 'resources/templates/see-more-link.mustache';
    }
}
