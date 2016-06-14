<?php

namespace tests\eLife\Patterns\ViewModel;

use eLife\Patterns\ViewModel\CompactForm;
use eLife\Patterns\ViewModel\Form;
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
        ];

        $form = new CompactForm(
            new Form($data['formAction'], $data['formId'], $data['formMethod']),
            new Input($data['label'], $data['inputType'], $data['inputName'], $data['inputValue'],
                $data['inputPlaceholder']),
            $data['ctaText']
        );

        $this->assertSame($data['formAction'], $form['formAction']);
        $this->assertSame($data['formId'], $form['formId']);
        $this->assertSame($data['formMethod'], $form['formMethod']);
        $this->assertSame($data['label'], $form['label']);
        $this->assertSame($data['inputType'], $form['inputType']);
        $this->assertSame($data['inputName'], $form['inputName']);
        $this->assertSame($data['inputValue'], $form['inputValue']);
        $this->assertSame($data['inputPlaceholder'], $form['inputPlaceholder']);
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

    public function viewModelProvider() : array
    {
        return [
            [
                new CompactForm(
                    new Form('/foo', 'foo', 'GET'),
                    new Input('label', 'text', 'input', 'value', 'placeholder'),
                    'cta'
                )
            ],
        ];
    }

    protected function expectedTemplate() : string
    {
        return '/elife/patterns/templates/compact-form.mustache';
    }
}
