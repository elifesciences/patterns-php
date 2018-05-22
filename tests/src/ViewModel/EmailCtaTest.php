<?php

namespace tests\eLife\Patterns\ViewModel;

use eLife\Patterns\ViewModel\CompactForm;
use eLife\Patterns\ViewModel\EmailCta;
use eLife\Patterns\ViewModel\Form;
use eLife\Patterns\ViewModel\FormFieldInfoLink;
use eLife\Patterns\ViewModel\Input;
use InvalidArgumentException;

final class EmailCtaTest extends ViewModelTest
{
    /**
     * @test
     */
    public function it_has_data()
    {
        $data = [
            'headerText' => 'header text',
            'subHeader' => 'sub header text',
            'compactForm' => [
                'formAction' => '/foo',
                'formId' => 'foo',
                'formMethod' => 'GET',
                'label' => 'label',
                'inputType' => 'text',
                'inputName' => 'input',
                'inputValue' => 'value',
                'inputPlaceholder' => 'placeholder',
                'ctaText' => 'cta',
            ],
            'formFieldInfoLink' => [
                'text' => 'some text',
                'url' => 'http://example.com',
                'alignLeft' => true,
            ],
        ];
        $form = new EmailCta($data['headerText'], $data['subHeader'], new CompactForm(
            new Form(
                $data['compactForm']['formAction'],
                $data['compactForm']['formId'],
                $data['compactForm']['formMethod']
            ),
            new Input(
                $data['compactForm']['label'],
                $data['compactForm']['inputType'],
                $data['compactForm']['inputName'],
                $data['compactForm']['inputValue'],
                $data['compactForm']['inputPlaceholder']
            ),
            $data['compactForm']['ctaText']
        ), FormFieldInfoLink::alignedLeft(
            $data['formFieldInfoLink']['text'],
            $data['formFieldInfoLink']['url']
        ));

        $this->assertSame($data['headerText'], $form['headerText']);
        $this->assertSame($data['subHeader'], $form['subHeader']);
        $this->assertSame($data['compactForm']['formAction'], $form['compactForm']['formAction']);
        $this->assertSame($data['compactForm']['formAction'], $form['compactForm']['formAction']);
        $this->assertSame($data['compactForm']['formId'], $form['compactForm']['formId']);
        $this->assertSame($data['compactForm']['formMethod'], $form['compactForm']['formMethod']);
        $this->assertSame($data['compactForm']['label'], $form['compactForm']['label']);
        $this->assertSame($data['compactForm']['inputType'], $form['compactForm']['inputType']);
        $this->assertSame($data['compactForm']['inputName'], $form['compactForm']['inputName']);
        $this->assertSame($data['compactForm']['inputValue'], $form['compactForm']['inputValue']);
        $this->assertSame($data['compactForm']['inputPlaceholder'], $form['compactForm']['inputPlaceholder']);
        $this->assertSame($data['formFieldInfoLink']['text'], $form['formFieldInfoLink']['text']);
        $this->assertSame($data['formFieldInfoLink']['url'], $form['formFieldInfoLink']['url']);
        $this->assertSame($data['formFieldInfoLink']['alignLeft'], $form['formFieldInfoLink']['alignLeft']);
        $this->assertSame($data, $form->toArray());
    }

    /**
     * @test
     */
    public function it_must_have_an_info_link_aligned_left()
    {
        $this->expectException(InvalidArgumentException::class);

        new EmailCta('header text', 'sub header text',
            new CompactForm(
                new Form('/foo', 'foo', 'GET'),
                new Input('label', 'text', 'input', 'value', 'placeholder'),
                'cta'
            ), FormFieldInfoLink::alignedRight('some text', '/some-url')
        );
    }

    public function viewModelProvider() : array
    {
        return [
            [
                new EmailCta('header text', 'sub header text',
                    new CompactForm(
                    new Form('/foo', 'foo', 'GET'),
                    new Input('label', 'text', 'input', 'value', 'placeholder'),
                    'cta'
                ), FormFieldInfoLink::alignedLeft('some text', '/some-url')
),
            ],
        ];
    }

    protected function expectedTemplate() : string
    {
        return 'resources/templates/email-cta.mustache';
    }
}
