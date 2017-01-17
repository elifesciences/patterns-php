<?php

namespace tests\eLife\Patterns\ViewModel;

use eLife\Patterns\ViewModel\Table;
use eLife\Patterns\ViewModel\TableFootnote;
use InvalidArgumentException;

final class TableTest extends ViewModelTest
{
    /**
     * @test
     */
    public function it_has_data()
    {
        $data = [
            'tables' => [
                '<table><tr><td>foo</td></tr></table>',
                '<table><tr><td>bar</td></tr></table>',
            ],
            'hasFootnotes' => true,
            'footnotes' => [
                [
                    'text' => 'Footnote 1',
                    'id' => 'fn1',
                ],
                [
                    'text' => 'Footnote 2',
                ],
            ],
        ];

        $table = new Table(
            $data['tables'],
            [
                new TableFootnote($data['footnotes'][0]['text'], $data['footnotes'][0]['id']),
                new TableFootnote($data['footnotes'][1]['text']),
            ]
        );

        $this->assertSame($data['tables'], $table['tables']);
        $this->assertSame($data['hasFootnotes'], $table['hasFootnotes']);
        $this->assertCount(count($data['footnotes']), $table['footnotes']);
        $this->assertSame($data['footnotes'][0], $table['footnotes'][0]->toArray());
        $this->assertSame($data['footnotes'][1], $table['footnotes'][1]->toArray());
        $this->assertSame($data['tables'], $table['tables']);
        $this->assertSame($data, $table->toArray());
    }

    /**
     * @test
     */
    public function it_must_have_a_table()
    {
        $this->expectException(InvalidArgumentException::class);

        new Table([]);
    }

    /**
     * @test
     */
    public function it_must_have_a_html_table()
    {
        $this->expectException(InvalidArgumentException::class);

        new Table(['foo']);
    }

    public function viewModelProvider() : array
    {
        return [
            'minimum' => [new Table(['<table><tr><td>foo</td></tr></table>'])],
        ];
    }

    protected function expectedTemplate() : string
    {
        return '/elife/patterns/templates/table.mustache';
    }
}
