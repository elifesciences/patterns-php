<?php

namespace tests\eLife\Patterns\ViewModel;

use eLife\Patterns\ViewModel\CompactForm;
use eLife\Patterns\ViewModel\Form;
use eLife\Patterns\ViewModel\FormLabel;
use eLife\Patterns\ViewModel\HiddenField;
use eLife\Patterns\ViewModel\Honeypot;
use eLife\Patterns\ViewModel\Input;
use eLife\Patterns\ViewModel\TextField;
use InvalidArgumentException;

final class CompactFormTest extends ViewModelTest
{
    /**
     * @test
     */
    public function it_has_data()
    {
        $data = [
            'formAction' => '/foo',
            'formId' => 'foo',
            'formMethod' => 'GET',
            'label' => 'label',
            'inputType' => 'text',
            'inputName' => 'input',
            'inputValue' => 'value',
            'inputPlaceholder' => 'placeholder',
            'inputAutofocus' => true,
            'ctaText' => 'cta',
            'state' => 'error',
            'message' => 'message',
            'hiddenFields' => [
                [
                    'name' => 'hidden-name',
                    'id' => 'hidden-id',
                    'value' => 'hidden-value',
                ],
            ],
            'honeypot' => [
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
            ],
        ];

        $form = new CompactForm(
            new Form($data['formAction'], $data['formId'], $data['formMethod']),
            new Input($data['label'], $data['inputType'], $data['inputName'], $data['inputValue'],
                $data['inputPlaceholder'], true),
            $data['ctaText'], CompactForm::STATE_ERROR, $data['message'], [new HiddenField($data['hiddenFields'][0]['name'], $data['hiddenFields'][0]['id'], $data['hiddenFields'][0]['value'])],
            new Honeypot(TextField::emailInput(
                new FormLabel($data['honeypot']['label']['labelText']),
                $data['honeypot']['id'],
                $data['honeypot']['name'],
                $data['honeypot']['placeholder'],
                $data['honeypot']['required'],
                $data['honeypot']['disabled'],
                $data['honeypot']['autofocus'],
                $data['honeypot']['value'],
                TextField::STATE_ERROR
            ))
        );

        $this->assertSame($data['formAction'], $form['formAction']);
        $this->assertSame($data['formId'], $form['formId']);
        $this->assertSame($data['formMethod'], $form['formMethod']);
        $this->assertSame($data['label'], $form['label']);
        $this->assertSame($data['inputType'], $form['inputType']);
        $this->assertSame($data['inputName'], $form['inputName']);
        $this->assertSame($data['inputValue'], $form['inputValue']);
        $this->assertSame($data['inputPlaceholder'], $form['inputPlaceholder']);
        $this->assertSame($data['inputAutofocus'], $form['inputAutofocus']);
        $this->assertSame($data['state'], $form['state']);
        $this->assertSame($data['message'], $form['message']);
        $this->assertSame($data['hiddenFields'][0], $form['hiddenFields'][0]->toArray());
        $this->assertSame($data['honeypot'], $form['honeypot']->toArray());
        $this->assertSame($data, $form->toArray());
    }

    /**
     * @test
     */
    public function it_cannot_have_a_blank_cta_text()
    {
        $this->expectException(InvalidArgumentException::class);

        new CompactForm(
            new Form('formAction', 'formId', 'GET'),
            new Input('label', 'text', 'name'),
            ''
        );
    }

    /**
     * @test
     */
    public function it_cannot_have_a_non_hidden_field()
    {
        $this->expectException(InvalidArgumentException::class);

        new CompactForm(
            new Form('formAction', 'formId', 'GET'),
            new Input('label', 'text', 'name'),
            'foo', null, null, [$this]
        );
    }

    public function viewModelProvider() : array
    {
        return [
            'minimum' => [
                new CompactForm(
                    new Form('/foo', 'foo', 'GET'),
                    new Input('label', 'text', 'input', 'value', 'placeholder'),
                    'cta'
                ),
            ],
            'complete' => [
                new CompactForm(
                    new Form('/foo', 'foo', 'GET'),
                    new Input('label', 'text', 'input', 'value', 'placeholder', true),
                    'cta', CompactForm::STATE_ERROR, 'message', [new HiddenField('name', 'id', 'value')],
                    new Honeypot(TextField::emailInput(new FormLabel('label'), 'id', 'some name'))
                ),
            ],
        ];
    }

    protected function expectedTemplate() : string
    {
        return 'resources/templates/compact-form.mustache';
    }
}
