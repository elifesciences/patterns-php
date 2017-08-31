<?php

namespace tests\eLife\Patterns\ViewModel;

use eLife\Patterns\ViewModel\FormLabel;
use eLife\Patterns\ViewModel\TextField;

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
            'message' => 'The text field data is invalid',
            'userInputInvalid' => true,
            'messageId' => 'theHTMLIdOfTheMessageElement'
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
            $data['message'],
            $data['messageId']
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
        $this->assertSame($data['message'], $textField['message']);
        $this->assertSame($data['userInputInvalid'], $textField['userInputInvalid']);
        $this->assertSame($data['messageId'], $textField['messageId']);
        $this->assertSame($data, $textField->toArray());
    }

    /**
     * @test
     */
    public function it_must_have_a_message_id_when_in_error_state()
    {
        $this->expectException(\InvalidArgumentException::class);

        TextField::textInput(new FormLabel('label'), 'identifier', 'identifier', 'placeholder', true, false, false, 'value', TextField::STATE_ERROR, 'some message', null);
    }

    /**
     * @test
     */
    public function it_must_not_have_a_message_id_when_in_valid_state()
    {
        $this->expectException(\InvalidArgumentException::class);

        TextField::textInput(new FormLabel('label'), 'identifier', 'identifier', 'placeholder', true, false, false, 'value', TextField::STATE_VALID, 'some message', 'messageIdThatShouldNotBeHere');
    }

    public function viewModelProvider() : array
    {
        return [
            'minimal email input' => [TextField::emailInput(new FormLabel('label'), 'id', 'some name')],
            'complete email input' => [TextField::emailInput(new FormLabel('label'), 'id', 'some name', 'placeholder', true, true, true, 'value', TextField::STATE_ERROR, 'some message', 'someHtmlIdForTheMessage')],
            'minimal password input' => [TextField::passwordInput(new FormLabel('label'), 'id', 'some name')],
            'complete password input' => [TextField::passwordInput(new FormLabel('label'), 'id', 'some name', 'placeholder', true, true, true, 'value', TextField::STATE_ERROR,'some message', 'someHtmlIdForTheMessage')],
            'minimal search input' => [TextField::searchInput(new FormLabel('label'), 'id', 'some name')],
            'complete search input' => [TextField::searchInput(new FormLabel('label'), 'id', 'some name', 'placeholder', true, true, true, 'value', TextField::STATE_ERROR,'some message', 'someHtmlIdForTheMessage')],
            'minimal tel input' => [TextField::telInput(new FormLabel('label'), 'id', 'some name')],
            'complete tel input' => [TextField::telInput(new FormLabel('label'), 'id', 'some name', 'placeholder', true, true, true, 'value', TextField::STATE_ERROR,'some message', 'someHtmlIdForTheMessage')],
            'minimal text input' => [TextField::textInput(new FormLabel('label'), 'id', 'some name')],
            'complete text input' => [TextField::textInput(new FormLabel('label'), 'id', 'some name', 'placeholder', true, true, true, 'value', TextField::STATE_ERROR,'some message', 'someHtmlIdForTheMessage')],
            'minimal url input' => [TextField::urlInput(new FormLabel('label'), 'id', 'some name')],
            'complete url input' => [TextField::urlInput(new FormLabel('label'), 'id', 'some name', 'placeholder', true, true, true, 'value', TextField::STATE_ERROR,'some message', 'someHtmlIdForTheMessage')],
        ];
    }

    protected function expectedTemplate() : string
    {
        return 'resources/templates/text-field.mustache';
    }
}
