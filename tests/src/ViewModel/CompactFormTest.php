<?php

namespace tests\eLife\Patterns\ViewModel;

use eLife\Patterns\ViewModel\CompactForm;
use eLife\Patterns\ViewModel\Form;
use eLife\Patterns\ViewModel\HiddenField;
use eLife\Patterns\ViewModel\Input;
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
            'ctaText' => 'cta',
            'hiddenFields' => [
                [
                    'name' => 'hidden-name',
                    'id' => 'hidden-id',
                    'value' => 'hidden-value',
                ],
            ],
        ];

        $form = new CompactForm(
            new Form($data['formAction'], $data['formId'], $data['formMethod']),
            new Input($data['label'], $data['inputType'], $data['inputName'], $data['inputValue'],
                $data['inputPlaceholder']),
            $data['ctaText'], [new HiddenField($data['hiddenFields'][0]['name'], $data['hiddenFields'][0]['id'], $data['hiddenFields'][0]['value'])]
        );

        $this->assertSame($data['formAction'], $form['formAction']);
        $this->assertSame($data['formId'], $form['formId']);
        $this->assertSame($data['formMethod'], $form['formMethod']);
        $this->assertSame($data['label'], $form['label']);
        $this->assertSame($data['inputType'], $form['inputType']);
        $this->assertSame($data['inputName'], $form['inputName']);
        $this->assertSame($data['inputValue'], $form['inputValue']);
        $this->assertSame($data['inputPlaceholder'], $form['inputPlaceholder']);
        $this->assertSame($data['hiddenFields'][0], $form['hiddenFields'][0]->toArray());
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
            'foo', [$this]
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
                    new Input('label', 'text', 'input', 'value', 'placeholder'),
                    'cta', [new HiddenField('name', 'id', 'value')]
                ),
            ],
        ];
    }

    protected function expectedTemplate() : string
    {
        return 'resources/templates/compact-form.mustache';
    }
}
