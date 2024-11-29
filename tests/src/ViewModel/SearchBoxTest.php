<?php

namespace tests\eLife\Patterns\ViewModel;

use eLife\Patterns\ViewModel\CompactForm;
use eLife\Patterns\ViewModel\Form;
use eLife\Patterns\ViewModel\Input;
use eLife\Patterns\ViewModel\SearchBox;
use eLife\Patterns\ViewModel\SubjectFilter;

final class SearchBoxTest extends ViewModelTest
{
    /**
     * @test
     */
    public function it_has_data()
    {
        $data = [
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
            'subjectFilter' => [
                'name' => 'name',
                'value' => 'value',
                'text' => 'text',
            ],
        ];

        $searchBox = new SearchBox(
            $compactForm = new CompactForm(
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
            ),
            $subjectFilter = new SubjectFilter(...array_values($data['subjectFilter']))
        );

        $this->assertEquals($compactForm, $searchBox['compactForm']);
        $this->assertEquals($subjectFilter, $searchBox['subjectFilter']);
        $this->assertSame($data, $searchBox->toArray());
    }

    public function viewModelProvider(): array
    {
        return [
            'without subject filter' => [
                new SearchBox(
                    new CompactForm(
                        new Form('/foo', 'foo', 'GET'),
                        new Input('label', 'text', 'input', 'value', 'placeholder'),
                        'cta'
                    )
                ),
            ],
            'with subject filter' => [
                new SearchBox(
                    new CompactForm(
                        new Form('/foo', 'foo', 'GET'),
                        new Input('label', 'text', 'input', 'value', 'placeholder'),
                        'cta'
                    ),
                    new SubjectFilter('name', 'value', 'text')
                ),
            ],
        ];
    }

    protected function expectedTemplate(): string
    {
        return 'resources/templates/search-box.mustache';
    }
}
