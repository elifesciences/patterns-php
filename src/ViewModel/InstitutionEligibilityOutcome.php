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
    const TYPE_NOT_AGREED_PUBLISHED = 'not-agreed-published';
    const TYPE_NOT_AGREED_NOT_PUBLISHED = 'not-agreed-not-published';
    const TYPE_NOT_AGREED_NOT_PUBLISHED_WITH_POSSIBLE_MATCHES = 'not-agreed-not-published-with-possible-matches';

    use ArrayAccessFromProperties;
    use ArrayFromProperties;

    private $type;
    private $isAgreed;
    private $isNotAgreedPublished;
    private $isNotAgreedNotPublished;
    private $isNotAgreedNotPublishedWithPossibleMatches;
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

    public function __construct(
        string $type,
        string $institution,
        string $until = null,
        bool $rollingDeal = false,
        array $possibleMatches = []
    ){
        Assertion::choice($type, [
            self::TYPE_AGREED,
            self::TYPE_NOT_AGREED_PUBLISHED,
            self::TYPE_NOT_AGREED_NOT_PUBLISHED,
            self::TYPE_NOT_AGREED_NOT_PUBLISHED_WITH_POSSIBLE_MATCHES,
        ]);

        $this->type = $type;
        $this->isAgreed = self::TYPE_AGREED === $type;
        $this->isNotAgreedPublished = self::TYPE_NOT_AGREED_PUBLISHED === $type;
        $this->isNotAgreedNotPublished = self::TYPE_NOT_AGREED_NOT_PUBLISHED === $type;
        $this->isNotAgreedNotPublishedWithPossibleMatches = self::TYPE_NOT_AGREED_NOT_PUBLISHED_WITH_POSSIBLE_MATCHES === $type;
        $this->institution = $institution;
        $this->until = $until;
        $this->rollingDeal = $rollingDeal;
        $this->possibleMatches = $possibleMatches;
    }

    public function getTemplateName() : string
    {
        return 'resources/templates/eligibility-tool-outcome.mustache';
    }
}
