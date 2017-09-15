<?php

namespace tests\eLife\Patterns\ViewModel;

use eLife\Patterns\ViewModel\FormLabel;
use eLife\Patterns\ViewModel\MessageGroup;
use eLife\Patterns\ViewModel\TextArea;
use InvalidArgumentException;

class TextAreaTest extends ViewModelTest
{
    /**
     * @test
     */
    public function it_has_data()
    {
        $data = [
            'label' => [
                'labelText' => 'label text',
                'isVisuallyHidden' => false,
            ],
            'name' => 'name',
            'id' => 'someid',
            'value' => 'default value',
            'placeholder' => 'placeholder',
            'required' => true,
            'disabled' => true,
            'autofocus' => true,
            'cols' => 10,
            'rows' => 10,
            'form' => 'form',
            'state' => 'invalid',
            'messageGroup' => [
                'errorText' => 'error text',
                'infoText' => 'info text',
            ],
        ];
        $textArea = new TextArea(
            new FormLabel($data['label']['labelText']),
            $data['id'],
            $data['name'],
            $data['value'],
            $data['placeholder'],
            $data['required'],
            $data['disabled'],
            $data['autofocus'],
            $data['cols'],
            $data['rows'],
            $data['form'],
            TextArea::STATE_INVALID,
            MessageGroup::forInfoText($data['messageGroup']['infoText'], $data['messageGroup']['errorText'])
        );

        // id of messageGroup is unpredictable so must be ignored by the test
        $textAreaAsArray = $textArea->toArray();
        unset($textAreaAsArray['messageGroup']['id']);
        $this->assertSameWithoutOrder($data, $textAreaAsArray);
    }

    /**
     * @test
     */
    public function it_must_have_a_message_group_when_in_error_state()
    {
        $this->expectException(InvalidArgumentException::class);

        new TextArea(new FormLabel('label'), 'identifier', 'identifier', 'value', true, false, false, 'false', 10, 10, 'form', TextArea::STATE_INVALID, null);
    }

    /**
     * @test
     */
    public function its_message_group_must_have_an_error_message_when_in_error_state()
    {
        $this->expectException(InvalidArgumentException::class);

        new TextArea(new FormLabel('label'), 'identifier', 'identifier', 'placeholder', true, false, false, 'value', 10, 10, 'form', TextArea::STATE_INVALID, MessageGroup::forInfoText('info text'));
    }

    public function viewModelProvider() : array
    {
        return [
            [new TextArea(new FormLabel('label text'), 'someid', 'name', 'default value')],
            [
                new TextArea(
                    new FormLabel('label text', 'someid'),
                    'someid',
                    'name',
                    'default value',
                    'place holder value',
                    true, // required
                    true, // disabled
                    false, // auto-focus
                    30, // cols
                    2, // rows
                    'some_form_id',
                    TextArea::STATE_INVALID,
                    MessageGroup::forInfoText('info text', 'error text')
                ),
            ],
        ];
    }

    protected function expectedTemplate() : string
    {
        return 'resources/templates/text-area.mustache';
    }
}
