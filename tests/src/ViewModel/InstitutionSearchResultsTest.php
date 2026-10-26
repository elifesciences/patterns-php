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
        $searchResults = [new Link('The University of Sheffield', '/eligibility/check?institution=the-university-of-sheffield')];

        $results = new InstitutionSearchResults($searchResults, 'Institution not found.');

        $this->assertSame($searchResults, $results['searchResults']);
        $this->assertSame('Institution not found.', $results['emptyMessage']);
    }

    /**
     * @test
     */
    public function it_requires_search_results_to_be_links()
    {
        $this->expectException(InvalidArgumentException::class);

        new InstitutionSearchResults(['not a link']);
    }

    public function viewModelProvider() : array
    {
        return [
            'with search results' => [new InstitutionSearchResults([new Link('The University of Sheffield', '/eligibility/check?institution=the-university-of-sheffield')])],
            'empty' => [new InstitutionSearchResults([], 'Institution not found.')],
        ];
    }

    protected function expectedTemplate() : string
    {
        return 'resources/templates/eligibility-tool-institution-search-results.mustache';
    }
}
