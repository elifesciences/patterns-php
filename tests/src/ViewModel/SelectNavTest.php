<?php

namespace tests\eLife\Patterns\ViewModel;

use eLife\Patterns\ViewModel\Button;
use eLife\Patterns\ViewModel\FormLabel;
use eLife\Patterns\ViewModel\Select;
use eLife\Patterns\ViewModel\SelectNav;
use eLife\Patterns\ViewModel\SelectOption;

final class SelectNavTest extends ViewModelTest
{
    /**
     * @test
     */
    public function it_has_data()
    {
        $data = [
            'route' => '#',
            'select' => [
                'id' => 'id',
                'options' => [
                    [
                        'value' => 'value 1',
                        'displayValue' => 'display value 1',
                        'selected' => false,
                    ],
                    [
                        'value' => 'value 2',
                        'displayValue' => 'display value 2',
                        'selected' => true,
                    ],
                    [
                        'value' => 'value 3',
                        'displayValue' => 'display value 3',
                        'selected' => false,
                    ],
                ],
                'label' => [
                    'labelText' => 'label',
                    'isVisuallyHidden' => false,
                ],
                'name' => 'name',
            ],
            'button' => [
                'classes' => 'button--default',
                'text' => 'Search',
                'type' => 'submit',
                'name' => 'some name',
            ],
        ];

        $selectNav = new SelectNav(
            $data['route'],
            new Select(
                $data['select']['id'],
                array_map(function ($option) {
                    return new SelectOption($option['value'], $option['displayValue'], $option['selected']);
                }, $data['select']['options']),
                new FormLabel(
                    $data['select']['label']['labelText'],
                    $data['select']['label']['isVisuallyHidden']
                ),
                $data['select']['name']
            ),
            Button::form('Search', 'submit', 'some name')
        );

        $this->assertSame($data['route'], $selectNav['route']);
        $this->assertSame($data['select'], $selectNav['select']->toArray());
        $this->assertSame($data['button'], $selectNav['button']->toArray());
        $this->assertSame($data, $selectNav->toArray());
    }

    public function viewModelProvider(): array
    {
        return [
            [
                new SelectNav('id', new Select('id', [
                    new SelectOption('value', 'display value'),
                ], new FormLabel('label', false), 'name'), Button::form('Search', 'submit', 'some name')),
            ],
        ];
    }

    protected function expectedTemplate(): string
    {
        return 'resources/templates/select-nav.mustache';
    }
}
