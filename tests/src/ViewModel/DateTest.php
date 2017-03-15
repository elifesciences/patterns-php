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
            'isUpdated' => true,
            'forHuman' => [
                'dayOfMonth' => 5,
                'month' => 'Oct',
                'year' => 2015,
            ],
            'forMachine' => '2015-10-05',
        ];
        $viewModelSimple = Date::simple(new DateTimeImmutable($dateIn), $dataSimple['isUpdated']);
        $this->assertSame($dataSimple['isExpanded'], $viewModelSimple['isExpanded']);
        $this->assertSame($dataSimple['isUpdated'], $viewModelSimple['isUpdated']);
        $this->assertSame($dataSimple['forHuman'], $viewModelSimple['forHuman']);
        $this->assertSame($dataSimple['forMachine'], $viewModelSimple['forMachine']);
        $this->assertSame($dataSimple, $viewModelSimple->toArray());

        $dataExpanded = [
            'isExpanded' => true,
            'isUpdated' => false,
            'forHuman' => [
                'dayOfMonth' => 5,
                'month' => 'Oct',
                'year' => 2015,
            ],
            'forMachine' => '2015-10-05',
        ];
        $viewModelExpanded = Date::expanded(new DateTimeImmutable($dateIn));
        $this->assertSame($dataExpanded['isExpanded'], $viewModelExpanded['isExpanded']);
        $this->assertSame($dataExpanded['forHuman'], $viewModelExpanded['forHuman']);
        $this->assertSame($dataExpanded['forMachine'], $viewModelExpanded['forMachine']);
        $this->assertSame($dataExpanded, $viewModelExpanded->toArray());
    }

    public function viewModelProvider() : array
    {
        return [
            'simple' => [Date::simple(new DateTimeImmutable())],
            'simple updated' => [Date::simple(new DateTimeImmutable(), true)],
            'expanded' => [Date::expanded(new DateTimeImmutable())],
        ];
    }

    protected function expectedTemplate() : string
    {
        return 'resources/templates/date.mustache';
    }
}
