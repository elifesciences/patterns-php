<?php

namespace tests\eLife\Patterns\ViewModel;

use eLife\Patterns\ViewModel\CompactForm;
use eLife\Patterns\ViewModel\Form;
use eLife\Patterns\ViewModel\FormFieldInfoLink;
use eLife\Patterns\ViewModel\FormLabel;
use eLife\Patterns\ViewModel\HiddenField;
use eLife\Patterns\ViewModel\Honeypot;
use eLife\Patterns\ViewModel\Input;
use eLife\Patterns\ViewModel\MessageGroup;
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
            'state' => 'invalid',
            'messageGroup' => [
                'errorText' => 'error text',
                'infoText' => 'info text',
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
                'state' => 'invalid',
                'messageGroup' => [
                    'errorText' => 'honeypot error text',
                    'infoText' => 'honeypot info text',
                ],
            ],
        ];

        $form = new CompactForm(
            new Form($data['formAction'], $data['formId'], $data['formMethod']),
            new Input($data['label'], $data['inputType'], $data['inputName'], $data['inputValue'],
                $data['inputPlaceholder'], true),
            $data['ctaText'], CompactForm::STATE_INVALID, MessageGroup::forInfoText($data['messageGroup']['infoText'], $data['messageGroup']['errorText']), [new HiddenField($data['hiddenFields'][0]['name'], $data['hiddenFields'][0]['id'], $data['hiddenFields'][0]['value'])],
            new Honeypot(TextField::emailInput(
                new FormLabel($data['honeypot']['label']['labelText']),
                $data['honeypot']['id'],
                $data['honeypot']['name'],
                null,
                $data['honeypot']['placeholder'],
                $data['honeypot']['required'],
                $data['honeypot']['disabled'],
                $data['honeypot']['autofocus'],
                $data['honeypot']['value'],
                TextField::STATE_INVALID,
                MessageGroup::forInfoText($data['honeypot']['messageGroup']['infoText'], $data['honeypot']['messageGroup']['errorText'])
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
        $this->assertSame($data['hiddenFields'][0], $form['hiddenFields'][0]->toArray());

        // id of messageGroup is unpredictable so must be ignored by the test
        $formAsArray = $form->toArray();
        unset($formAsArray['messageGroup']['id']);
        unset($formAsArray['honeypot']['messageGroup']['id']);
        $this->assertSame($data['messageGroup'], $formAsArray['messageGroup']);
        $this->assertSameWithoutOrder($data['honeypot'], $formAsArray['honeypot']);
        $this->assertSameWithoutOrder($data, $formAsArray);
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
    public function it_must_have_a_message_group_when_in_error_state()
    {
        $this->expectException(InvalidArgumentException::class);

        new CompactForm(
            new Form('formAction', 'formId', 'GET'),
            new Input('label', 'text', 'name'),
            'foo', CompactForm::STATE_INVALID, null
        );
    }

    /**
     * @test
     */
    public function its_message_group_must_have_error_text_when_when_in_error_state()
    {
        $this->expectException(InvalidArgumentException::class);

        new CompactForm(
            new Form('formAction', 'formId', 'GET'),
            new Input('label', 'text', 'name'),
            'foo', CompactForm::STATE_INVALID, MessageGroup::forInfoText('info text')
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
                    'cta', CompactForm::STATE_INVALID, MessageGroup::forInfoText('info text', 'error text'), [new HiddenField('name', 'id', 'value')],
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
