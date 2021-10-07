<?php

namespace tests\eLife\Patterns\ViewModel;

use eLife\Patterns\ViewModel\Checkboxes;
use eLife\Patterns\ViewModel\CheckboxesGroup;
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
                    'value' => 'choice-1',
                    'label' => 'Choice 1',
                    'id' => 'choice-id-1',
                    'checked' => false,
                ],
                [
                    'value' => 'choice-2',
                    'label' => 'Choice 2',
                    'id' => 'choice-id-2',
                    'checked' => true,
                ],
                [
                    'children' => [
                        [
                            'value' => 'choice-3',
                            'label' => 'Choice 3',
                            'id' => 'choice-id-3',
                            'checked' => false,
                        ],
                        [
                            'value' => 'choice-4',
                            'label' => 'Choice 4',
                            'id' => 'choice-id-4',
                            'checked' => true,
                        ],
                    ],
                    'groupLabel' => 'Group 1',
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
                $data['checkboxes'][0]['value'],
                $data['checkboxes'][0]['label'],
                $data['checkboxes'][0]['id'],
                $data['checkboxes'][0]['checked']
            ),
            new CheckboxesOption(
                $data['checkboxes'][1]['value'],
                $data['checkboxes'][1]['label'],
                $data['checkboxes'][1]['id'],
                $data['checkboxes'][1]['checked']
            ),
            new CheckboxesGroup([
                new CheckboxesOption(
                    $data['checkboxes'][2]['children'][0]['value'],
                    $data['checkboxes'][2]['children'][0]['label'],
                    $data['checkboxes'][2]['children'][0]['id'],
                    $data['checkboxes'][2]['children'][0]['checked']
                ),
                new CheckboxesOption(
                    $data['checkboxes'][2]['children'][1]['value'],
                    $data['checkboxes'][2]['children'][1]['label'],
                    $data['checkboxes'][2]['children'][1]['id'],
                    $data['checkboxes'][2]['children'][1]['checked']
                ),
            ], 'Group 1'),
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
                    new CheckboxesOption('choice-1', 'Choice 1'),
                    new CheckboxesOption('choice-2', 'Choice 2'),
                ], new FormLabel('Form label', 'id'), 'choice[]'),
            ],
            'complete' => [
                new Checkboxes('id', [
                    new CheckboxesOption('choice-1', 'Choice 1', 'choice-id-1', false),
                    new CheckboxesOption('choice-2', 'Choice 2', 'choice-id-2', true),
                    new CheckboxesGroup([
                        new CheckboxesOption('choice-3', 'Choice 3', 'choice-id-3', false),
                        new CheckboxesOption('choice-4', 'Choice 4', 'choice-id-4', true),
                    ], 'Group 1')
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
