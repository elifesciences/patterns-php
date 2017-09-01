<?php

namespace tests\eLife\Patterns\ViewModel;

use eLife\Patterns\ViewModel\FormLabel;
use eLife\Patterns\ViewModel\Honeypot;
use eLife\Patterns\ViewModel\Message;
use eLife\Patterns\ViewModel\TextField;

final class HoneypotTest extends ViewModelTest
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
                'text' => 'message text',
                'id' => 'message id'
            ],
            'userInputInvalid' => true,
        ];
        $textField = new Honeypot(TextField::emailInput(
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
        ));

        $this->assertSame($data['name'], $textField['name']);
        $this->assertSame($data['id'], $textField['id']);
        $this->assertSame($data['label'], $textField['label']->toArray());
        $this->assertSame($data['placeholder'], $textField['placeholder']);
        $this->assertSame($data['required'], $textField['required']);
        $this->assertSame($data['disabled'], $textField['disabled']);
        $this->assertSame($data['autofocus'], $textField['autofocus']);
        $this->assertSame($data['value'], $textField['value']);
        $this->assertSame($data['message'], $textField['message']->toArray());
        $this->assertSame($data, $textField->toArray());
    }

    public function viewModelProvider() : array
    {
        return [
            'minimal input' => [new Honeypot(TextField::emailInput(new FormLabel('label'), 'id', 'some name'))],
            'complete input' => [new Honeypot(TextField::emailInput(new FormLabel('label'), 'id', 'some name', 'placeholder', true, true, true, 'value', TextField::STATE_ERROR, new Message('message', 'messageId')))],
        ];
    }

    protected function expectedTemplate() : string
    {
        return 'resources/templates/honeypot.mustache';
    }
}
