<?php

namespace tests\eLife\Patterns\ViewModel;

use eLife\Patterns\ViewModel\CompactForm;
use eLife\Patterns\ViewModel\Form;
use eLife\Patterns\ViewModel\FormLabel;
use eLife\Patterns\ViewModel\HiddenField;
use eLife\Patterns\ViewModel\Honeypot;
use eLife\Patterns\ViewModel\Input;
use eLife\Patterns\ViewModel\Message;
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
            'message' => [
                'text' => 'message text',
                'id' => 'messageElementId',
            ],
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
                'message' => [
                    'text' => 'honeypot message text',
                    'id' => 'honeypotMessageElementId',
                ],
                'userInputInvalid' => true,
                'variant' => 'error'
            ],
            'userInputInvalid' => true,
            'variant' => 'error'
        ];

        $form = new CompactForm(
            new Form($data['formAction'], $data['formId'], $data['formMethod']),
            new Input($data['label'], $data['inputType'], $data['inputName'], $data['inputValue'],
                $data['inputPlaceholder'], true),
            $data['ctaText'], CompactForm::STATE_ERROR, new Message($data['message']['text'], $data['message']['id']), [new HiddenField($data['hiddenFields'][0]['name'], $data['hiddenFields'][0]['id'], $data['hiddenFields'][0]['value'])],
            new Honeypot(TextField::emailInput(
                new FormLabel($data['honeypot']['label']['labelText']),
                $data['honeypot']['id'],
                $data['honeypot']['name'],
                $data['honeypot']['placeholder'],
                $data['honeypot']['required'],
                $data['honeypot']['disabled'],
                $data['honeypot']['autofocus'],
                $data['honeypot']['value'],
                TextField::STATE_ERROR,
                new Message($data['honeypot']['message']['text'], $data['honeypot']['message']['id'])

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
        $this->assertSame($data['message'], $form['message']->toArray());
        $this->assertSame($data['hiddenFields'][0], $form['hiddenFields'][0]->toArray());
        $this->assertSame($data['honeypot'], $form['honeypot']->toArray());
        $this->assertSame($data['userInputInvalid'], $form['userInputInvalid']);
        $this->assertSame($data['variant'], $form['variant']);
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

    /**
     * @test
     */
    public function it_must_have_a_message_when_in_error_state()
    {
        $this->expectException(\InvalidArgumentException::class);

        new CompactForm(
            new Form('formAction', 'formId', 'GET'),
            new Input('label', 'text', 'name'),
            'foo', CompactForm::STATE_ERROR, null
        );
    }

    /**
     * @test
     */
    public function it_must_set_userInputInvalid_when_in_error_state()
    {
        $compactForm = new CompactForm(
            new Form('formAction', 'formId', 'GET'),
            new Input('label', 'text', 'name'),
            'foo', CompactForm::STATE_ERROR, new Message('message text', 'messageId')
        );

        $this->assertTrue($compactForm['userInputInvalid']);
    }

    /**
     * @test
     */
    public function it_must_not_set_userInputInvalid_when_not_in_error_state()
    {
        $compactForm_1 = new CompactForm(
            new Form('formAction', 'formId', 'GET'),
            new Input('label', 'text', 'name'),
            'foo', CompactForm::STATE_VALID, null
        );

        $this->assertNotTrue($compactForm_1['userInputInvalid']);

        $compactForm_2 = new CompactForm(
            new Form('formAction', 'formId', 'GET'),
            new Input('label', 'text', 'name'),
            'foo', null, new Message('message text', 'messageId')
        );

        $this->assertNotTrue($compactForm_2['userInputInvalid']);
    }

    /**
     * @test
     */
    public function it_must_have_a_variant_of_error_when_in_error_state()
    {
        $compactForm = new CompactForm(
            new Form('formAction', 'formId', 'GET'),
            new Input('label', 'text', 'name'),
            'foo', CompactForm::STATE_ERROR, new Message('message text', 'messageId')
        );
        $this->assertSame(TextField::VARIANT_ERROR, $compactForm['variant']);
    }

    /**
     * @test
     */
    public function it_must_have_variant_of_valid_when_in_valid_state()
    {
        $compactForm = new CompactForm(
            new Form('formAction', 'formId', 'GET'),
            new Input('label', 'text', 'name'),
            'foo', CompactForm::STATE_VALID, null
        );

        $this->assertSame(TextField::VARIANT_VALID, $compactForm['variant']);
    }

    /**
     * @test
     */
    public function it_must_have_variant_of_info_when_it_has_a_message_and_no_state()
    {
        $compactForm = new CompactForm(
            new Form('formAction', 'formId', 'GET'),
            new Input('label', 'text', 'name'),
            'foo', null, new Message('message text', 'messageId')
        );

        $this->assertSame(TextField::VARIANT_INFO, $compactForm['variant']);
    }

    /**
     * @test
     */
    public function it_must_have_no_variant_when_it_has_no_message_and_no_state()
    {
        $compactForm = new CompactForm(
            new Form('formAction', 'formId', 'GET'),
            new Input('label', 'text', 'name'),
            'foo', null, null
        );

        $this->assertNull($compactForm['variant']);
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
                    'cta', CompactForm::STATE_ERROR, new Message('message text', 'message id'), [new HiddenField('name', 'id', 'value')],
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
