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
        $outcome = new InstitutionEligibilityOutcome(InstitutionEligibilityOutcome::TYPE_AGREED);

        $data = [
            'type' => InstitutionEligibilityOutcome::TYPE_AGREED,
            'isAgreed' => true,
            'isNotAgreedPublished' => false,
            'isNotAgreedUnpublished' => false,
        ];

        $this->assertSame($data['type'], $outcome['type']);
        $this->assertSame($data['isAgreed'], $outcome['isAgreed']);
        $this->assertSame($data['isNotAgreedPublished'], $outcome['isNotAgreedPublished']);
        $this->assertSame($data['isNotAgreedUnpublished'], $outcome['isNotAgreedUnpublished']);
        $this->assertSame($data, $outcome->toArray());
    }

    /**
     * @test
     */
    public function it_cannot_have_an_invalid_type()
    {
        $this->expectException(InvalidArgumentException::class);

        new InstitutionEligibilityOutcome('foo');
    }

    public function viewModelProvider() : array
    {
        return [
            'agreed' => [new InstitutionEligibilityOutcome(InstitutionEligibilityOutcome::TYPE_AGREED)],
            'not agreed, published' => [new InstitutionEligibilityOutcome(InstitutionEligibilityOutcome::TYPE_NOT_AGREED_PUBLISHED)],
            'not agreed, unpublished' => [new InstitutionEligibilityOutcome(InstitutionEligibilityOutcome::TYPE_NOT_AGREED_UNPUBLISHED)],
        ];
    }

    protected function expectedTemplate() : string
    {
        return 'resources/templates/institution-eligibility-outcome.mustache';
    }
}
