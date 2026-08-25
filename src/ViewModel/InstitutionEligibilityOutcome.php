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
    const TYPE_NOT_AGREED_UNPUBLISHED = 'not-agreed-unpublished';

    use ArrayAccessFromProperties;
    use ArrayFromProperties;

    private $type;
    private $isAgreed;
    private $isNotAgreedPublished;
    private $isNotAgreedUnpublished;

    public function __construct(string $type)
    {
        Assertion::choice($type, [
            self::TYPE_AGREED,
            self::TYPE_NOT_AGREED_PUBLISHED,
            self::TYPE_NOT_AGREED_UNPUBLISHED,
        ]);

        $this->type = $type;
        $this->isAgreed = self::TYPE_AGREED === $type;
        $this->isNotAgreedPublished = self::TYPE_NOT_AGREED_PUBLISHED === $type;
        $this->isNotAgreedUnpublished = self::TYPE_NOT_AGREED_UNPUBLISHED === $type;
    }

    public function getTemplateName() : string
    {
        return 'resources/templates/institution-eligibility-outcome.mustache';
    }
}
