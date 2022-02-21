<?php

namespace tests\eLife\Patterns\ViewModel;

use eLife\Patterns\ViewModel\Breadcrumb;
use eLife\Patterns\ViewModel\Link;

final class BreadcrumbTest extends ViewModelTest
{
    /**
     * @test
     */
    public function it_has_data()
    {
        $data = [
            'items' => [['name' => 'name', 'url' => 'url']],
        ];

        $breadcrumb = new Breadcrumb($items = [
            new Link($data['items'][0]['name'], $data['items'][0]['url']),
        ]);

        $this->assertEquals($items, $breadcrumb['items']);
        $this->assertSame($data, $breadcrumb->toArray());
    }

    public function viewModelProvider() : array
    {
        return [
            [new Breadcrumb([new Link('name', 'url')])],
        ];
    }

    protected function expectedTemplate() : string
    {
        return 'resources/templates/breadcrumb.mustache';
    }
}
