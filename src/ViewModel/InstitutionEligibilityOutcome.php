<?php

namespace eLife\Patterns\ViewModel;

use Assert\Assertion;
use DateTime;
use eLife\Patterns\ArrayAccessFromProperties;
use eLife\Patterns\ArrayFromProperties;
use eLife\Patterns\ViewModel;

final class InstitutionEligibilityOutcome implements ViewModel
{
    const TYPE_AGREED = 'agreed';
    const TYPE_AGREED_HHMI = 'agreed-hhmi';
    const TYPE_NOT_AGREED_PUBLISHED = 'not-agreed-published';
    const TYPE_NOT_AGREED_NOT_PUBLISHED = 'not-agreed-not-published';

    use ArrayAccessFromProperties;
    use ArrayFromProperties;

    private $type;
    private $isAgreed;
    private $isAgreedHhmi;
    private $isNotAgreedPublished;
    private $isNotAgreedNotPublished;
    /**
     * @var string
     */
    private $institution;
    /**
     * @var string|null
     */
    private $until;
    /**
     * @var bool
     */
    private $rollingDeal;

    private $possibleMatches;

    /**
     * @var bool
     */
    private $hasPossibleMatches;

    public function __construct(
        string $type,
        string $institution,
        string $until = null,
        bool $rollingDeal = false,
        array $possibleMatches = []
    ){
        Assertion::choice($type, [
            self::TYPE_AGREED,
            self::TYPE_AGREED_HHMI,
            self::TYPE_NOT_AGREED_PUBLISHED,
            self::TYPE_NOT_AGREED_NOT_PUBLISHED,
        ]);

        $this->type = $type;
        $this->isAgreed = self::TYPE_AGREED === $type;
        $this->isAgreedHhmi = self::TYPE_AGREED_HHMI === $type;
        $this->isNotAgreedPublished = self::TYPE_NOT_AGREED_PUBLISHED === $type;
        $this->isNotAgreedNotPublished = self::TYPE_NOT_AGREED_NOT_PUBLISHED === $type;
        $this->institution = $institution;
        $this->until = $until;
        $this->rollingDeal = $rollingDeal;
        $this->possibleMatches = $possibleMatches;

        // variable for Mustache templating
        if (count($this->possibleMatches) > 0) {
            $this->hasPossibleMatches = true;
        }
    }

    public function getTemplateName() : string
    {
        return 'resources/templates/eligibility-tool-outcome.mustache';
    }
}
