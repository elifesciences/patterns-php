<?php

namespace eLife\Patterns\ViewModel;

use Assert\Assertion;
use DateTimeImmutable;
use eLife\Patterns\ArrayAccessFromProperties;
use eLife\Patterns\ArrayFromProperties;
use eLife\Patterns\ViewModel;
use InvalidArgumentException;

final class InfoBar implements ViewModel
{
    const TYPE_ATTENTION = 'attention';
    const TYPE_DISMISSIBLE = 'dismissible';
    const TYPE_INFO = 'info';
    const TYPE_SUCCESS = 'success';
    const TYPE_CORRECTION = 'correction';
    const TYPE_MULTIPLE_VERSIONS = 'multiple-versions';
    const TYPE_WARNING = 'warning';

    use ArrayAccessFromProperties;
    use ArrayFromProperties;

    private $dismiss;
    private $cookieExpires;
    private $text;
    private $type;

    public function __construct(
        string $text,
        string $type = self::TYPE_INFO,
        int $cookieDuration = null,
        DateTimeImmutable $cookieExpires = null)
    {
        Assertion::notBlank($text);
        Assertion::choice($type, [
            self::TYPE_ATTENTION,
            self::TYPE_DISMISSIBLE,
            self::TYPE_INFO,
            self::TYPE_SUCCESS,
            self::TYPE_CORRECTION,
            self::TYPE_MULTIPLE_VERSIONS,
            self::TYPE_WARNING,
        ]);

        $this->dismiss = null;
        if ($type === self::TYPE_DISMISSIBLE) {
            if ($cookieDuration === null && $cookieExpires === null) {
                throw new InvalidArgumentException('Dismissible type must have one of $cookieDuration or $cookieDuration set');
            }
            if ($cookieDuration !== null && $cookieExpires !== null) {
                throw new InvalidArgumentException('Dismissible type must not have both $cookieDuration and $cookieDuration set');
            }

            $this->dismiss = [
                'cookieDuration' => $cookieDuration,
                'cookieExpires' => $cookieExpires,
            ];
        }

        $this->text = $text;
        $this->type = $type;
    }

    public function getTemplateName() : string
    {
        return 'resources/templates/info-bar.mustache';
    }
}
