<?php

namespace tests\eLife\Patterns\ViewModel;


use eLife\Patterns\ViewModel\Button;
use eLife\Patterns\ViewModel\FormLabel;
use eLife\Patterns\ViewModel\Select;
use eLife\Patterns\ViewModel\SelectNav;
use eLife\Patterns\ViewModel\SelectOption;

class SelectNavTest extends ViewModelTest
{

    /**
     * @test
     */
    public function it_has_data()
    {
        $data = [
            'route' => '#',
            'select' =>
                [
                    'id' => 'id',
                    'options' =>
                        [
                            [
                                'value' => 'value 1',
                                'displayValue' => 'display value 1',
                            ],
                            [
                                'value' => 'value 2',
                                'displayValue' => 'display value 2',
                            ],
                            [
                                'value' => 'value 3',
                                'displayValue' => 'display value 3',
                            ],
                        ],
                    'label' =>
                        [
                            'labelText' => 'label',
                            'for' => 'id',
                            'isVisuallyHidden' => false,
                        ],
                ],
            'button' =>
                [
                    'classes' => 'button--default',
                    'text' => 'Search',
                    'type' => 'submit',
                ],
        ];
        $selectNav = new SelectNav(
            $data['route'],
            new Select(
                $data['select']['id'],
                array_map(function($option){
                    return new SelectOption($option['value'], $option['display_value']);
                }, $data['select']['options']),
                new FormLabel(
                    $data['select']['label']['labelText'],
                    $data['select']['label']['for'],
                    $data['select']['label']['isVisuallyHidden']
                )
            ),
            Button::form('Search', 'submit')
        );

        $this->assertSame($data, $selectNav->toArray());
    }

    public function viewModelProvider() : array
    {
        // TODO: Implement viewModelProvider() method.
    }

    protected function expectedTemplate() : string
    {
        // TODO: Implement expectedTemplate() method.
    }
}
