<?php

namespace tests\eLife\Patterns\ViewModel;

use eLife\Patterns\ViewModel\FormLabel;
use eLife\Patterns\ViewModel\MessageGroup;
use eLife\Patterns\ViewModel\TextArea;

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
                'id' => 'theHTMLIdOfTheMessageGroupElement',
                'errorText' => 'error text',
                'infoText' => 'info text',
            ],
            'isInvalid' => true,
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
            new MessageGroup($data['messageGroup']['id'], $data['messageGroup']['errorText'], $data['messageGroup']['infoText'])
        );

        $this->assertSameWithoutOrder($data, $textArea);
    }

    /**
     * @test
     */
    public function it_must_have_a_message_group_when_in_error_state()
    {
        $this->expectException(\InvalidArgumentException::class);

        new TextArea(new FormLabel('label'), 'identifier', 'identifier', 'value', true, false, false, 'false', 10, 10, 'form', TextArea::STATE_INVALID, null);
    }

    /**
     * @test
     */
    public function its_message_group_must_have_an_error_message_when_in_error_state()
    {
        $this->expectException(\InvalidArgumentException::class);

        new TextArea(new FormLabel('label'), 'identifier', 'identifier', 'placeholder', true, false, false, 'value', 10, 10, 'form', TextArea::STATE_INVALID, new MessageGroup('id', null, 'info text'));
    }

    /**
     * @test
     */
    public function it_must_set_isInvalid_when_in_error_state()
    {
        $textArea = new TextArea(new FormLabel('label'), 'identifier', 'identifier', 'value', 'placeholder', true, false, false, 10, 10, 'form', TextArea::STATE_INVALID, new MessageGroup('id', 'error text', 'info text'));

        $this->assertTrue($textArea['isInvalid']);
    }

    /**
     * @test
     */
    public function it_must_not_set_isInvalid_when_not_in_error_state()
    {
        $textArea_state_valid = new TextArea(new FormLabel('label'), 'identifier', 'identifier', 'value', 'placeholder', true, false, false, 10, 10, 'form', TextArea::STATE_VALID);

        $this->assertNotTrue($textArea_state_valid['isInvalid']);

        $textArea_state_null = new TextArea(new FormLabel('label'), 'identifier', 'identifier', 'value', 'placeholder', true, false, false, 10, 10, 'form', null);

        $this->assertNotTrue($textArea_state_null['isInvalid']);
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
                    new MessageGroup('id', 'error text', 'info text')
                ),
            ],
        ];
    }

    protected function expectedTemplate() : string
    {
        return 'resources/templates/text-area.mustache';
    }
}
