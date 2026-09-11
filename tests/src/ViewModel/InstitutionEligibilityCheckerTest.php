<?php

namespace tests\eLife\Patterns\ViewModel;

use eLife\Patterns\ViewModel\InstitutionEligibilityChecker;
use eLife\Patterns\ViewModel\InstitutionEligibilityOutcome;
use eLife\Patterns\ViewModel\InstitutionSearchResults;
use eLife\Patterns\ViewModel\Link;
use InvalidArgumentException;

final class InstitutionEligibilityCheckerTest extends ViewModelTest
{
    /**
     * @test
     */
    public function it_has_data()
    {
        $checker = new InstitutionEligibilityChecker(
            'Search for your institution',
            "Start typing your institution's name",
            'Search',
            '/eligibility/search'
        );

        $this->assertSame('Search for your institution', $checker['label']);
        $this->assertSame('/eligibility/search', $checker['searchUrl']);
    }

    /**
     * @test
     */
    public function it_has_an_institutions_url_and_no_results_message()
    {
        $checker = new InstitutionEligibilityChecker(
            'Search for your institution',
            "Start typing your institution's name",
            'Search',
            '/eligibility/search',
            '',
            null,
            null,
            null,
            '/institutions.json',
            'No matching institution found.'
        );

        $this->assertSame('/institutions.json', $checker['institutionsUrl']);
        $this->assertSame('No matching institution found.', $checker['noResultsMessage']);
    }

    /**
     * @test
     */
    public function it_cannot_have_blank_label()
    {
        $this->expectException(InvalidArgumentException::class);

        new InstitutionEligibilityChecker('', "Start typing your institution's name", 'Search', '/eligibility/search');
    }

    public function viewModelProvider() : array
    {
        return [
            'basic' => [new InstitutionEligibilityChecker(
                'Search for your institution',
                "Start typing your institution's name",
                'Search',
                '/eligibility/search'
            )],
            'with results' => [new InstitutionEligibilityChecker(
                'Search for your institution',
                "Start typing your institution's name",
                'Search',
                '/eligibility/search',
                'Sheffield',
                new InstitutionSearchResults([new Link('The University of Sheffield', '/eligibility/check?institution=the-university-of-sheffield')])
            )],
            'with outcome' => [new InstitutionEligibilityChecker(
                'Search for your institution',
                "Start typing your institution's name",
                'Search',
                '/eligibility/search',
                'The University of Sheffield',
                null,
                new InstitutionEligibilityOutcome(InstitutionEligibilityOutcome::TYPE_AGREED)
            )],
            'with institutions url' => [new InstitutionEligibilityChecker(
                'Search for your institution',
                "Start typing your institution's name",
                'Search',
                '/eligibility/search',
                '',
                null,
                null,
                null,
                '/institutions.json',
                'No matching institution found.'
            )],
        ];
    }

    protected function expectedTemplate() : string
    {
        return 'resources/templates/eligibility-tool-checker.mustache';
    }
}
