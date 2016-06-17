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
            'forHuman' => 'Oct 5, 2015',
            'forMachine' => '2015-10-05',
        ];
        $viewModelSimple = new Date(new DateTimeImmutable($dateIn), false);
        $this->assertSame('Oct 5, 2015', $viewModelSimple['forHuman']);
        $this->assertSame('2015-10-05', $viewModelSimple['forMachine']);
        $this->assertSame($dataSimple, $viewModelSimple->toArray());

        $dataExpanded = [
            'forHuman' => [
                'dayOfMonth' => '5',
                'month' => 'Oct',
                'year' => '2015'
            ],
            'forMachine' => '2015-10-05',
        ];
        $viewModelExpanded = new Date(new DateTimeImmutable($dateIn), true);
        $this->assertSame('5', $viewModelExpanded['forHuman']['dayOfMonth']);
        $this->assertSame('Oct', $viewModelExpanded['forHuman']['month']);
        $this->assertSame('2015', $viewModelExpanded['forHuman']['year']);
        $this->assertSame('2015-10-05', $viewModelExpanded['forMachine']);
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
