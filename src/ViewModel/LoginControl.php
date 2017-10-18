<?php

namespace eLife\Patterns\ViewModel;

use Assert\Assertion;
use eLife\Patterns\ArrayAccessFromProperties;
use eLife\Patterns\ArrayFromProperties;
use eLife\Patterns\SimplifyAssets;
use eLife\Patterns\ViewModel;
use Traversable;

final class LoginControl implements ViewModel
{
    use ArrayAccessFromProperties;
    use ArrayFromProperties;
    use SimplifyAssets;

    private $button;
    private $displayName;
    private $icon;
    private $isLoggedIn;
    private $linkFieldData;
    private $linkFieldRoots;
    private $defaultUri;

    private function __construct()
    {
    }

    public static function loggedIn(
        string $defaultUri,
        string $displayName,
        array $linkFields,
        Picture $icon
    ) : LoginControl {
        Assertion::notBlank($defaultUri);
        Assertion::notBlank($displayName);
        Assertion::notBlank($linkFields);
        Assertion::notBlank($icon);

        foreach ($linkFields as $text => $uri) {
            Assertion::notBlank($text);
            Assertion::notBlank($uri);
        }

        $loggedInControl = new static();
        $loggedInControl->isLoggedIn = true;
        $loggedInControl->displayName = $displayName;
        $loggedInControl->defaultUri = $defaultUri;
        $loggedInControl->linkFieldRoots = $loggedInControl->buildLinkFieldRootsAttributeValue($linkFields);
        $loggedInControl->linkFieldData = $loggedInControl->buildLinkFieldsDataAttributeValues($linkFields);
        $loggedInControl->icon = $icon;

        return $loggedInControl;
    }

    public static function notLoggedIn(string $text, string $uri) : LoginControl
    {
        Assertion::notBlank($uri);
        Assertion::notBlank($text);

        $notLoggedInControl = new static();
        $notLoggedInControl->isLoggedIn = null;
        $notLoggedInControl->button = Button::link($text, $uri, Button::SIZE_EXTRA_SMALL, Button::STYLE_CONFIRM);

        return $notLoggedInControl;
    }

    private static function buildLinkFieldRootsAttributeValue($linkFields)
    {
        $dataAttributesString = '';
        for ($i = 1; $i <= count($linkFields); $i += 1) {
            $dataAttributesString .= "link{$i}, ";
        }

        return rtrim(trim($dataAttributesString), ',');
    }

    private static function buildLinkFieldsDataAttributeValues(array $linkFields)
    {
        $dataAttributes = array_map(function (string $text, string $uri, int $i) {
            return "data-link{$i}-text=\"{$text}\" data-link{$i}-uri=\"{$uri}\"";
        }, array_keys($linkFields), array_values($linkFields), range(1, count($linkFields)));

        return implode(' ', $dataAttributes);
    }

    public function getStyleSheets(): Traversable
    {
        yield 'resources/assets/css/login-control.css';
    }

    public function getTemplateName(): string
    {
        return 'resources/templates/login-control.mustache';
    }
}
