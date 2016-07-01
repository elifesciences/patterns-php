<?php

/**
 * Created by PhpStorm.
 * User: Stephen
 * Date: 01/07/16
 * Time: 09:08.
 */

namespace tests\eLife\Patterns\ViewModel;

use eLife\Patterns\ViewModel\Link;
use eLife\Patterns\ViewModel\SeeMoreLink;

class SeeMoreLinkTest extends ViewModelTest
{
    /**
     * @test
     */
    public function it_has_data()
    {
        $data = [
            'name' => 'something',
            'url' => 'http://google.com',
        ];

        $link = new SeeMoreLink(new Link($data['name'], $data['url']));

        $this->assertSame($data['name'], $link['name'], 'The names should match');
        $this->assertSame($data['url'], $link['url'], 'The URLs should match');
        $this->assertSame($data, $link->toArray());
    }

    public function viewModelProvider() : array
    {
        return [
            [new SeeMoreLink(new Link('something', 'http://google.com'))],
        ];
    }

    protected function expectedTemplate() : string
    {
        return '/elife/patterns/templates/see-more-link.mustache';
    }
}
