<?php

namespace eLife\Patterns\ViewModel;

use Assert\Assertion;
use eLife\Patterns\ArrayAccessFromProperties;
use eLife\Patterns\ArrayFromProperties;
use eLife\Patterns\ViewModel;

final class InstitutionEligibilityOutcome implements ViewModel
{
    const TYPE_AGREED = 'agreed';
    const TYPE_NOT_AGREED_PUBLISHED = 'not-agreed-published';

    use ArrayAccessFromProperties;
    use ArrayFromProperties;

    private $type;
    private $isAgreed;
    private $isNotAgreedPublished;
    /**
     * @var string
     */
    private $institution;

    public function __construct(string $type, string $institution)
    {
        Assertion::choice($type, [
            self::TYPE_AGREED,
            self::TYPE_NOT_AGREED_PUBLISHED,
        ]);

        $this->type = $type;
        $this->isAgreed = self::TYPE_AGREED === $type;
        $this->isNotAgreedPublished = self::TYPE_NOT_AGREED_PUBLISHED === $type;
        $this->institution = $institution;
    }

    public function getTemplateName() : string
    {
        return 'resources/templates/eligibility-tool-outcome.mustache';
    }
}
