<?php

namespace tests\eLife\Patterns\ViewModel;

use eLife\Patterns\ViewModel\Breadcrumb;
use eLife\Patterns\ViewModel\Link;
use InvalidArgumentException;

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

    /**
     * @test
     */
    public function items_must_be_links()
    {
        $this->expectException(InvalidArgumentException::class);

        new Breadcrumb(['foo']);
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
