<?php

namespace tests\eLife\Patterns\ViewModel;

use eLife\Patterns\ViewModel\Checkboxes;
use eLife\Patterns\ViewModel\CheckboxesOption;
use eLife\Patterns\ViewModel\FormLabel;
use eLife\Patterns\ViewModel\MessageGroup;

final class CheckboxesTest extends ViewModelTest
{
    /**
     * @test
     */
    public function it_has_data()
    {
        $data = [
            'id' => 'id',
            'checkboxes' => [
                [
                    'id' => 'choice-id-1',
                    'value' => 'choice-1',
                    'displayValue' => 'Choice 1',
                    'checked' => false,
                ],
                [
                    'id' => 'choice-id-2',
                    'value' => 'choice-2',
                    'displayValue' => 'Choice 2',
                    'checked' => true,
                ],
            ],
            'label' => [
                'labelText' => 'Label for form',
                'isVisuallyHidden' => true,
            ],
            'name' => 'choice[]',
            'required' => true,
            'disabled' => true,
            'state' => 'invalid',
            'messageGroup' => [
                'errorText' => 'error text',
                'infoText' => 'info text',
            ],
        ];
        $checkboxes = new Checkboxes($data['id'], [
            new CheckboxesOption(
                $data['checkboxes'][0]['id'],
                $data['checkboxes'][0]['value'],
                $data['checkboxes'][0]['displayValue'],
                $data['checkboxes'][0]['checked']
            ),
            new CheckboxesOption(
                $data['checkboxes'][1]['id'],
                $data['checkboxes'][1]['value'],
                $data['checkboxes'][1]['displayValue'],
                $data['checkboxes'][1]['checked']
            ),
        ], new FormLabel($data['label']['labelText'], $data['label']['isVisuallyHidden']),
            $data['name'], $data['required'], $data['disabled'], Checkboxes::STATE_INVALID,
                MessageGroup::forInfoText($data['messageGroup']['infoText'], $data['messageGroup']['errorText'])
        );

        // id of messageGroup is unpredictable so must be ignored by the test
        $checkboxesAsArray = $checkboxes->toArray();
        unset($checkboxesAsArray['messageGroup']['id']);
        $this->assertSame($data, $checkboxesAsArray);
    }

    public function viewModelProvider() : array
    {
        return [
            'minimum' => [
                new Checkboxes('id', [
                    new CheckboxesOption('choice-id-1', 'choice-1', 'Choice 1', false),
                    new CheckboxesOption('choice-id-2', 'choice-2', 'Choice 2', true),
                ], new FormLabel('Form label', 'id'), 'choice[]'),
            ],
            'complete' => [
                new Checkboxes('id', [
                    new CheckboxesOption('choice-id-1', 'choice-1', 'Choice 1', false),
                    new CheckboxesOption('choice-id-2', 'choice-2', 'Choice 2', true),
                ], new FormLabel('Form label', 'id'), 'choice[]', true,
                    true, Checkboxes::STATE_INVALID, MessageGroup::forInfoText('info text', 'error text')),
            ],
        ];
    }

    protected function expectedTemplate() : string
    {
        return 'resources/templates/checkboxes.mustache';
    }
}
