<?php

namespace tests\eLife\Patterns\ViewModel;

use eLife\Patterns\ViewModel\InstitutionEligibilityOutcome;
use InvalidArgumentException;

final class InstitutionEligibilityOutcomeTest extends ViewModelTest
{
    /**
     * @test
     */
    public function it_has_data()
    {
        $outcome = new InstitutionEligibilityOutcome(
            InstitutionEligibilityOutcome::TYPE_AGREED,
            'The University of Sheffield',
            '31 December 2026',
            true
        );

        $data = [
            'type' => InstitutionEligibilityOutcome::TYPE_AGREED,
            'isAgreed' => true,
            'isNotAgreedPublished' => false,
            'isNotAgreedNotPublished' => false,
            'isNotAgreedNotPublishedWithPossibleMatches' => false,
            'institution' => 'The University of Sheffield',
            'until' => '31 December 2026',
            'rollingDeal' => true,
        ];

        foreach ($data as $key => $value) {
            $this->assertSame($value, $outcome[$key]);
        }
        $this->assertSame($data, $outcome->toArray());
    }

    /**
     * @test
     */
    public function it_has_possible_matches_when_not_agreed_and_not_published()
    {
        $possibleMatches = [
            ['name' => 'University of Sheffield', 'country' => 'United Kingdom', 'url' => ''],
            ['name' => 'Sheffield Hallam University', 'country' => 'United Kingdom', 'url' => ''],
        ];

        $outcome = new InstitutionEligibilityOutcome(
            InstitutionEligibilityOutcome::TYPE_NOT_AGREED_NOT_PUBLISHED_WITH_POSSIBLE_MATCHES,
            'The University',
            null,
            false,
            $possibleMatches
        );

        $this->assertTrue($outcome['isNotAgreedNotPublishedWithPossibleMatches']);
        $this->assertSame($possibleMatches, $outcome['possibleMatches']);
    }

    /**
     * @test
     */
    public function it_has_no_possible_matches_by_default()
    {
        $outcome = new InstitutionEligibilityOutcome(InstitutionEligibilityOutcome::TYPE_NOT_AGREED_NOT_PUBLISHED, 'The University');

        $this->assertArrayNotHasKey('possibleMatches', $outcome->toArray());
    }

    /**
     * @test
     */
    public function it_cannot_have_an_invalid_type()
    {
        $this->expectException(InvalidArgumentException::class);

        new InstitutionEligibilityOutcome('foo', 'The University');
    }

    public function viewModelProvider() : array
    {
        return [
            'agreed' => [new InstitutionEligibilityOutcome(InstitutionEligibilityOutcome::TYPE_AGREED, 'The University of Sheffield')],
            'not agreed, published' => [new InstitutionEligibilityOutcome(InstitutionEligibilityOutcome::TYPE_NOT_AGREED_PUBLISHED, 'The University')],
            'not agreed, not published' => [new InstitutionEligibilityOutcome(InstitutionEligibilityOutcome::TYPE_NOT_AGREED_NOT_PUBLISHED, 'The University')],
            'not agreed, not published, with possible matches' => [new InstitutionEligibilityOutcome(
                InstitutionEligibilityOutcome::TYPE_NOT_AGREED_NOT_PUBLISHED_WITH_POSSIBLE_MATCHES,
                'The University',
                null,
                false,
                [['name' => 'University of Sheffield', 'country' => 'United Kingdom', 'url' => '']]
            )],
        ];
    }

    protected function expectedTemplate() : string
    {
        return 'resources/templates/eligibility-tool-outcome.mustache';
    }
}
