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
        ];
    }

    protected function expectedTemplate() : string
    {
        return 'resources/templates/institution-eligibility-checker.mustache';
    }
}
