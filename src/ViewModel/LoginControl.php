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
        array $linkFields
    ) : LoginControl {
        Assertion::notBlank($defaultUri);
        Assertion::notBlank($displayName);
        Assertion::notBlank($linkFields);

        foreach ($linkFields as $name => $values) {
            Assertion::count($values, 2);
            Assertion::choice(array_keys($values)[0], ['uri', 'text']);
            Assertion::choice(array_keys($values)[1], ['uri', 'text']);
            Assertion::notBlank($values['uri']);
            Assertion::notBlank($values['text']);
        }

        $loggedInControl = new static();
        $loggedInControl->isLoggedIn = true;
        $loggedInControl->displayName = $displayName;
        $loggedInControl->defaultUri = $defaultUri;
        $loggedInControl->linkFieldRoots = implode(', ', array_keys($linkFields));
        $loggedInControl->linkFieldData = $loggedInControl->buildLinkFieldsDataAttributeValues($linkFields);

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

    private static function buildLinkFieldsDataAttributeValues(array $linkFields)
    {

        $dataAttributesString = '';
        foreach ($linkFields as $name => $values) {
            $dataAttributesString .= ' data-'.$name.'-uri="'.$values['uri'].'"' .
                                     ' data-'.$name.'-text="'.$values['text'].'"';
        }

        return trim($dataAttributesString);
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
