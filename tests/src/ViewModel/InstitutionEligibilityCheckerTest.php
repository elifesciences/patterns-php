<?php

namespace tests\eLife\Patterns\ViewModel;

use eLife\Patterns\ViewModel\CompactForm;
use eLife\Patterns\ViewModel\Form;
use eLife\Patterns\ViewModel\Input;
use eLife\Patterns\ViewModel\InstitutionEligibilityChecker;
use eLife\Patterns\ViewModel\InstitutionEligibilityOutcome;
use eLife\Patterns\ViewModel\InstitutionSearchResults;
use eLife\Patterns\ViewModel\Link;

final class InstitutionEligibilityCheckerTest extends ViewModelTest
{
    private function compactForm() : CompactForm
    {
        return new CompactForm(
            new Form('/eligibility/search', 'searchBox', 'GET'),
            new Input('Choose your institution:', 'search', 'institution', '', "Start typing your institution's name"),
            'Search'
        );
    }

    /**
     * @test
     */
    public function it_has_data()
    {
        $checker = new InstitutionEligibilityChecker($this->compactForm());

        $this->assertSame('/eligibility/search', $checker['compactForm']['formAction']);
    }

    /**
     * @test
     */
    public function it_has_an_institutions_url()
    {
        $checker = new InstitutionEligibilityChecker(
            $this->compactForm(),
            null,
            null,
            '/institutions.json'
        );

        $this->assertSame('/institutions.json', $checker['institutionsUrl']);
    }

    public function viewModelProvider() : array
    {
        return [
            'basic' => [new InstitutionEligibilityChecker($this->compactForm())],
            'with search results' => [new InstitutionEligibilityChecker(
                $this->compactForm(),
                new InstitutionSearchResults([new Link('The University of Sheffield', '/eligibility/check?institution=the-university-of-sheffield')])
            )],
            'with outcome' => [new InstitutionEligibilityChecker(
                $this->compactForm(),
                null,
                new InstitutionEligibilityOutcome(InstitutionEligibilityOutcome::TYPE_AGREED, 'The University of Sheffield')
            )],
            'with institutions url' => [new InstitutionEligibilityChecker(
                $this->compactForm(),
                null,
                null,
                '/institutions.json'
            )],
        ];
    }

    protected function expectedTemplate() : string
    {
        return 'resources/templates/eligibility-tool-checker.mustache';
    }
}
