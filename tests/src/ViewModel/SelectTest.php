<?php

namespace tests\eLife\Patterns\ViewModel;

use eLife\Patterns\ViewModel\FormLabel;
use eLife\Patterns\ViewModel\Select;
use eLife\Patterns\ViewModel\SelectOption;

final class SelectTest extends ViewModelTest
{
    /**
     * @test
     */
    public function it_has_data()
    {
        $data = [
            'id' => 'id',
            'options' => [
                [
                    'value' => 'choice-1',
                    'displayValue' => 'Choice 1',
                    'selected' => false,
                ],
                [
                    'value' => 'choice-2',
                    'displayValue' => 'Choice 2',
                    'selected' => true,
                ],
            ],
            'label' => [
                'labelText' => 'Label for form',
                'for' => 'id',
                'isVisuallyHidden' => true,
            ],
        ];
        $select = new Select($data['id'], [
            new SelectOption(
                $data['options'][0]['value'],
                $data['options'][0]['displayValue'],
                $data['options'][0]['selected']
            ),
            new SelectOption(
                $data['options'][1]['value'],
                $data['options'][1]['displayValue'],
                $data['options'][1]['selected']
            ),
        ], new FormLabel($data['label']['labelText'], $data['label']['for'], $data['label']['isVisuallyHidden']));

        $this->assertSame($data, $select->toArray());
    }

    public function viewModelProvider() : array
    {
        return [
            'Select with label' => [
                new Select('id', [
                    new SelectOption('choice-1', 'Choice 1', false),
                    new SelectOption('choice-2', 'Choice 2', true),
                ], new FormLabel('Form label', 'id')),
            ],
        ];
    }

    protected function expectedTemplate() : string
    {
        return 'resources/templates/select.mustache';
    }
}
