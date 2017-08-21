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
                'isVisuallyHidden' => true,
            ],
            'name' => 'name',
            'required' => true,
            'disabled' => true,
            'status' => 'error',
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
        ], new FormLabel($data['label']['labelText'], $data['label']['isVisuallyHidden']),
            $data['name'], $data['required'], $data['disabled'], Select::STATUS_ERROR
        );

        $this->assertSame($data, $select->toArray());
    }

    public function viewModelProvider() : array
    {
        return [
            'minimum' => [
                new Select('id', [
                    new SelectOption('choice-1', 'Choice 1', false),
                    new SelectOption('choice-2', 'Choice 2', true),
                ], new FormLabel('Form label', 'id'), 'name'),
            ],
            'complete' => [
                new Select('id', [
                    new SelectOption('choice-1', 'Choice 1', false),
                    new SelectOption('choice-2', 'Choice 2', true),
                ], new FormLabel('Form label', 'id'), 'name', true,
                    true, Select::STATUS_ERROR),
            ],
        ];
    }

    protected function expectedTemplate() : string
    {
        return 'resources/templates/select.mustache';
    }
}
