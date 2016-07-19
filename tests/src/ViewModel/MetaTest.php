<?php

namespace tests\eLife\Patterns\ViewModel;

use eLife\Patterns\ViewModel\Date;
use DateTimeImmutable;
use eLife\Patterns\ViewModel\Meta;

final class MetaTest extends ViewModelTest
{
    /**
     * @test
     */
    public function it_has_data()
    {
        $data = [
            'type' => 'Research article',
            'date' => [
                'isExpanded' => false,
                'forHuman' => [
                    'dayOfMonth' => 15,
                    'month' => 'May',
                    'year' => 2015,
                ],
                'forMachine' => '2015-05-15',
            ],
            'typeLink' => '#',
        ];
        $meta = new Meta($data['type'], new Date(new DateTimeImmutable('2015-05-15')), $data['typeLink']);

        $this->assertSame($data, $meta->toArray());
        $this->assertSame($data['type'], $meta['type']);
        $this->assertSame($data['date'], $meta['date']->toArray());
        $this->assertSame($data['typeLink'], $meta['typeLink']);
    }

    public static function getDateStub()
    {
        return new Date(new DateTimeImmutable(), false);
    }

    public function viewModelProvider() : array
    {
        return [
            [new Meta('Research article with link', self::getDateStub(), '#')],
            [new Meta('Research article without link', self::getDateStub())],
        ];
    }

    protected function expectedTemplate() : string
    {
        return '/elife/patterns/templates/meta.mustache';
    }
}
