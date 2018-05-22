<?php

namespace tests\eLife\Patterns\ViewModel;

use eLife\Patterns\ViewModel\FormFieldInfoLink;
use eLife\Patterns\ViewModel\FormLabel;
use eLife\Patterns\ViewModel\Honeypot;
use eLife\Patterns\ViewModel\MessageGroup;
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
            'formFieldInfoLink' => [
                'text' => 'some text',
                'url' => 'http://example.com',
            ],
            'placeholder' => 'placeholder',
            'required' => true,
            'disabled' => true,
            'autofocus' => true,
            'value' => 'value',
            'state' => 'invalid',
            'messageGroup' => [
                'errorText' => 'error text',
                'infoText' => 'info text',
            ],
        ];
        $textField = new Honeypot(TextField::emailInput(
            new FormLabel($data['label']['labelText']),
            $data['id'],
            $data['name'],
            FormFieldInfoLink::alignedRight($data['formFieldInfoLink']['text'], $data['formFieldInfoLink']['url']),
            $data['placeholder'],
            $data['required'],
            $data['disabled'],
            $data['autofocus'],
            $data['value'],
            TextField::STATE_INVALID,
            MessageGroup::forInfoText($data['messageGroup']['infoText'], $data['messageGroup']['errorText'])
        ));

        $this->assertSame($data['name'], $textField['name']);
        $this->assertSame($data['id'], $textField['id']);
        $this->assertSame($data['label'], $textField['label']->toArray());
        $this->assertSame($data['placeholder'], $textField['placeholder']);
        $this->assertSame($data['required'], $textField['required']);
        $this->assertSame($data['disabled'], $textField['disabled']);
        $this->assertSame($data['autofocus'], $textField['autofocus']);
        $this->assertSame($data['value'], $textField['value']);

        // id of messageGroup is unpredictable so must be ignored by the test
        $textFieldAsArray = $textField->toArray();
        unset($textFieldAsArray['messageGroup']['id']);
        $this->assertSame($data['messageGroup'], $textFieldAsArray['messageGroup']);
        $this->assertSame($data['formFieldInfoLink'], $textFieldAsArray['formFieldInfoLink']);
        $this->assertSameWithoutOrder($data, $textFieldAsArray);
    }

    public function viewModelProvider() : array
    {
        return [
            'minimal input' => [new Honeypot(TextField::emailInput(new FormLabel('label'), 'id', 'some name', FormFieldInfoLink::alignedRight('text', '/url')))],
            'complete input' => [new Honeypot(TextField::emailInput(new FormLabel('label'), 'id', 'some name', FormFieldInfoLink::alignedRight('text', '/url'), 'placeholder', true, true, true, 'value', TextField::STATE_INVALID, MessageGroup::forInfoText('info text', 'error text')))],
        ];
    }

    protected function expectedTemplate() : string
    {
        return 'resources/templates/honeypot.mustache';
    }
}
