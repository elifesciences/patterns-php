<?php

namespace tests\eLife\Patterns\ViewModel;

use eLife\Patterns\ViewModel\InstitutionSearchResults;
use eLife\Patterns\ViewModel\Link;
use InvalidArgumentException;

final class InstitutionSearchResultsTest extends ViewModelTest
{
    /**
     * @test
     */
    public function it_has_data()
    {
        $institutions = [new Link('The University of Sheffield', '/eligibility/check?institution=the-university-of-sheffield')];

        $results = new InstitutionSearchResults($institutions, 'Institution not found.');

        $this->assertSame($institutions, $results['institutions']);
        $this->assertSame('Institution not found.', $results['emptyMessage']);
    }

    /**
     * @test
     */
    public function it_requires_institutions_to_be_links()
    {
        $this->expectException(InvalidArgumentException::class);

        new InstitutionSearchResults(['not a link']);
    }

    public function viewModelProvider() : array
    {
        return [
            'with institutions' => [new InstitutionSearchResults([new Link('The University of Sheffield', '/eligibility/check?institution=the-university-of-sheffield')])],
            'empty' => [new InstitutionSearchResults([], 'Institution not found.')],
        ];
    }

    protected function expectedTemplate() : string
    {
        return 'resources/templates/institution-search-results.mustache';
    }
}
