<?php

namespace tests\eLife\Patterns\ViewModel;

use eLife\Patterns\ViewModel\FormLabel;
use eLife\Patterns\ViewModel\Message;
use eLife\Patterns\ViewModel\TextField;
use Prophecy\Exception\Doubler\InterfaceNotFoundException;

final class TextFieldTest extends ViewModelTest
{
    /**
     * @test
     */
    public function it_has_data()
    {
        $data = [
            'inputType' => 'email',
            'label' => [
                'labelText' => 'label',
                'isVisuallyHidden' => false,
            ],
            'name' => 'someName',
            'id' => 'id',
            'placeholder' => 'placeholder',
            'required' => true,
            'disabled' => true,
            'autofocus' => true,
            'value' => 'value',
            'state' => 'error',
            'message' => [
                'text' => 'The text field data is invalid',
                'id' => 'theHTMLIdOfTheMessageElement',
            ],
            'userInputInvalid' => true,
            'variant' => 'error'
        ];
        $textField = TextField::emailInput(
            new FormLabel($data['label']['labelText']),
            $data['id'],
            $data['name'],
            $data['placeholder'],
            $data['required'],
            $data['disabled'],
            $data['autofocus'],
            $data['value'],
            TextField::STATE_ERROR,
            new Message($data['message']['text'], $data['message']['id'])

        );

        $this->assertSame($data['name'], $textField['name']);
        $this->assertSame($data['id'], $textField['id']);
        $this->assertSame($data['label'], $textField['label']->toArray());
        $this->assertSame($data['placeholder'], $textField['placeholder']);
        $this->assertSame($data['required'], $textField['required']);
        $this->assertSame($data['disabled'], $textField['disabled']);
        $this->assertSame($data['autofocus'], $textField['autofocus']);
        $this->assertSame($data['value'], $textField['value']);
        $this->assertSame($data['state'], $textField['state']);
        $this->assertSame($data['userInputInvalid'], $textField['userInputInvalid']);
        $this->assertSame($data['variant'], $textField['variant']);
        $this->assertSame($data['message'], $textField['message']->toArray());
        $this->assertSame($data, $textField->toArray());
    }

    /**
     * @test
     */
    public function it_must_have_a_message_when_in_error_state()
    {
        $this->expectException(\InvalidArgumentException::class);

        TextField::textInput(new FormLabel('label'), 'identifier', 'identifier', 'placeholder', true, false, false, 'value', TextField::STATE_ERROR, null);
    }

    /**
     * @test
     */
    public function it_must_set_userInputInvalid_when_in_error_state()
    {
        $textField = TextField::textInput(new FormLabel('label'), 'identifier', 'identifier', 'placeholder', true, false, false, 'value', TextField::STATE_ERROR, new Message('message text', 'messgeId'));

        $this->assertTrue($textField['userInputInvalid']);
    }

    /**
     * @test
     */
    public function it_must_not_set_userInputInvalid_when_not_in_error_state()
    {
        $textField_1 = TextField::textInput(new FormLabel('label'), 'identifier', 'identifier', 'placeholder', true, false, false, 'value', TextField::STATE_VALID, null);

        $this->assertNotTrue($textField_1['userInputInvalid']);

        $textField_2 = TextField::textInput(new FormLabel('label'), 'identifier', 'identifier', 'placeholder', true, false, false, 'value', null, null);

        $this->assertNotTrue($textField_2['userInputInvalid']);
    }

    /**
     * @test
     */
    public function it_must_have_a_variant_of_error_when_in_error_state()
    {
        $textField = TextField::textInput(new FormLabel('label'), 'identifier', 'identifier', 'placeholder', true, false, false, 'value', TextField::STATE_ERROR, new Message('message text', 'messgeId'));

        $this->assertSame(TextField::VARIANT_ERROR, $textField['variant']);
    }

    /**
     * @test
     */
    public function it_must_have_variant_of_valid_when_in_valid_state()
    {
        $textField = TextField::textInput(new FormLabel('label'), 'identifier', 'identifier', 'placeholder', true, false, false, 'value', TextField::STATE_VALID, null);

        $this->assertSame(TextField::VARIANT_VALID, $textField['variant']);
    }

    /**
     * @test
     */
    public function it_must_have_variant_of_info_when_it_has_a_message_and_no_state()
    {
        $textField = TextField::textInput(new FormLabel('label'), 'identifier', 'identifier', 'placeholder', true, false, false, 'value', null, new Message('an info message', 'messageId'));

        $this->assertSame(TextField::VARIANT_INFO, $textField['variant']);
    }

    /**
     * @test
     */
    public function it_must_have_no_variant_when_it_has_no_message_and_no_state()
    {
        $textField = TextField::textInput(new FormLabel('label'), 'identifier', 'identifier', 'placeholder', true, false, false, 'value', null, null);

        $this->assertNull($textField['variant']);
    }

    public function viewModelProvider() : array
    {
        return [
            'minimal email input' => [TextField::emailInput(new FormLabel('label'), 'id', 'some name')],
            'complete email input' => [TextField::emailInput(new FormLabel('label'), 'id', 'some name', 'placeholder', true, true, true, 'value', TextField::STATE_ERROR, new Message('error message', 'someHtmlIdForTheMessage'))],
            'minimal password input' => [TextField::passwordInput(new FormLabel('label'), 'id', 'some name')],
            'complete password input' => [TextField::passwordInput(new FormLabel('label'), 'id', 'some name', 'placeholder', true, true, true, 'value', TextField::STATE_ERROR, new Message('error message', 'someHtmlIdForTheMessage'))],
            'minimal search input' => [TextField::searchInput(new FormLabel('label'), 'id', 'some name')],
            'complete search input' => [TextField::searchInput(new FormLabel('label'), 'id', 'some name', 'placeholder', true, true, true, 'value', TextField::STATE_ERROR, new Message('error message', 'someHtmlIdForTheMessage'))],
            'minimal tel input' => [TextField::telInput(new FormLabel('label'), 'id', 'some name')],
            'complete tel input' => [TextField::telInput(new FormLabel('label'), 'id', 'some name', 'placeholder', true, true, true, 'value', TextField::STATE_ERROR, new Message('error message', 'someHtmlIdForTheMessage'))],
            'minimal text input' => [TextField::textInput(new FormLabel('label'), 'id', 'some name')],
            'complete text input' => [TextField::textInput(new FormLabel('label'), 'id', 'some name', 'placeholder', true, true, true, 'value', TextField::STATE_ERROR, new Message('error message', 'someHtmlIdForTheMessage'))],
            'minimal url input' => [TextField::urlInput(new FormLabel('label'), 'id', 'some name')],
            'complete url input' => [TextField::urlInput(new FormLabel('label'), 'id', 'some name', 'placeholder', true, true, true, 'value', TextField::STATE_ERROR, new Message('error message', 'someHtmlIdForTheMessage'))],
        ];
    }

    protected function expectedTemplate() : string
    {
        return 'resources/templates/text-field.mustache';
    }
}
