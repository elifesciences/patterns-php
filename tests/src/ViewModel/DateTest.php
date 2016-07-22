<?php

namespace tests\eLife\Patterns\ViewModel;

use DateTimeImmutable;
use eLife\Patterns\ViewModel\Date;

final class DateTest extends ViewModelTest
{
    /**
     * @test
     */
    public function it_has_data()
    {
        $dateIn = '2015-10-05';
        $dataSimple = [
            'isExpanded' => false,
            'forHuman' => [
                'dayOfMonth' => 5,
                'month' => 'Oct',
                'year' => 2015,
            ],
            'forMachine' => '2015-10-05',
        ];
        $viewModelSimple = new Date(new DateTimeImmutable($dateIn), false);
        $this->assertSame($dataSimple['isExpanded'], $viewModelSimple['isExpanded']);
        $this->assertSame($dataSimple['forHuman'], $viewModelSimple['forHuman']);
        $this->assertSame($dataSimple['forMachine'], $viewModelSimple['forMachine']);
        $this->assertSame($dataSimple, $viewModelSimple->toArray());

        $dataExpanded = [
            'isExpanded' => true,
            'forHuman' => [
                'dayOfMonth' => 5,
                'month' => 'Oct',
                'year' => 2015,
            ],
            'forMachine' => '2015-10-05',
        ];
        $viewModelExpanded = new Date(new DateTimeImmutable($dateIn), true);
        $this->assertSame($dataExpanded['isExpanded'], $viewModelExpanded['isExpanded']);
        $this->assertSame($dataExpanded['forHuman'], $viewModelExpanded['forHuman']);
        $this->assertSame($dataExpanded['forMachine'], $viewModelExpanded['forMachine']);
        $this->assertSame($dataExpanded, $viewModelExpanded->toArray());
    }

    public function viewModelProvider() : array
    {
        return [

            'simple' => [new Date(new DateTimeImmutable(), false)],
            'expanded' => [new Date(new DateTimeImmutable(), true)],
        ];
    }

    protected function expectedTemplate() : string
    {
        return '/elife/patterns/templates/date.mustache';
    }
}
