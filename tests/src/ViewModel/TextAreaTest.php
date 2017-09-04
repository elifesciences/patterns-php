<?php

namespace tests\eLife\Patterns\ViewModel;

use eLife\Patterns\ViewModel\FormLabel;
use eLife\Patterns\ViewModel\Message;
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
            'state' => 'error',
            'message' => [
                'text' => 'The text field data is invalid',
                'id' => 'theHTMLIdOfTheMessageElement',
            ],
            'userInputInvalid' => true,
            'variant' => 'error'
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
            TextArea::STATE_ERROR,
            new Message($data['message']['text'], $data['message']['id'])
        );

        $this->assertSameWithoutOrder($data, $textArea);
    }



    /**
     * @test
     */
    public function it_must_have_a_message_when_in_error_state()
    {
        $this->expectException(\InvalidArgumentException::class);

        new TextArea(new FormLabel('label'), 'identifier', 'identifier', 'value', true, false, false, 'false', 10, 10, 'form', TextArea::STATE_ERROR, null);
    }

    /**
     * @test
     */
    public function it_must_set_userInputInvalid_when_in_error_state()
    {
        $textArea = new TextArea(new FormLabel('label'), 'identifier', 'identifier', 'value', 'placeholder', true, false, false, 10, 10, 'form', TextArea::STATE_ERROR, new Message('message text', 'messgeId'));

        $this->assertTrue($textArea['userInputInvalid']);
    }

    /**
     * @test
     */
    public function it_must_not_set_userInputInvalid_when_not_in_error_state()
    {
        $textArea_1 = new TextArea(new FormLabel('label'), 'identifier', 'identifier', 'value', 'placeholder', true, false, false, 10, 10, 'form', TextArea::STATE_VALID, new Message('message text', 'messgeId'));

        $this->assertNotTrue($textArea_1['userInputInvalid']);

        $textArea_2 = new TextArea(new FormLabel('label'), 'identifier', 'identifier', 'value', 'placeholder', true, false, false, 10, 10, 'form', null, new Message('message text', 'messgeId'));


        $this->assertNotTrue($textArea_2['userInputInvalid']);
    }

    /**
     * @test
     */
    public function it_must_have_a_variant_of_error_when_in_error_state()
    {
        $textArea = new TextArea(new FormLabel('label'), 'identifier', 'identifier', 'value', 'placeholder', true, false, false, 10, 10, 'form', TextArea::STATE_ERROR, new Message('message text', 'messgeId'));

        $this->assertSame(TextArea::VARIANT_ERROR, $textArea['variant']);
    }

    /**
     * @test
     */
    public function it_must_have_variant_of_valid_when_in_valid_state()
    {
        $textArea = new TextArea(new FormLabel('label'), 'identifier', 'identifier', 'value', 'placeholder', true, false, false, 10, 10, 'form', TextArea::STATE_VALID, new Message('message text', 'messgeId'));

        $this->assertSame(TextArea::VARIANT_VALID, $textArea['variant']);
    }

    /**
     * @test
     */
    public function it_must_have_variant_of_info_when_it_has_a_message_and_no_state()
    {
        $textArea = new TextArea(new FormLabel('label'), 'identifier', 'identifier', 'value', 'placeholder', true, false, false, 10, 10, 'form', null, new Message('message text', 'messgeId'));

        $this->assertSame(TextArea::VARIANT_INFO, $textArea['variant']);
    }

    /**
     * @test
     */
    public function it_must_have_no_variant_when_it_has_no_message_and_no_state()
    {
        $textArea = new TextArea(new FormLabel('label'), 'identifier', 'identifier', 'value', 'placeholder', true, false, false, 10, 10, 'form', null, null);

        $this->assertNull($textArea['variant']);
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
                    TextArea::STATE_ERROR,
                    new Message('message text', 'another id')
                ),
            ],
        ];
    }

    protected function expectedTemplate() : string
    {
        return 'resources/templates/text-area.mustache';
    }
}
