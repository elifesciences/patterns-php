<?php

namespace eLife\Patterns\ViewModel;

use Assert\Assertion;
use eLife\Patterns\ArrayAccessFromProperties;
use eLife\Patterns\ArrayFromProperties;
use eLife\Patterns\SimplifyAssets;
use eLife\Patterns\ViewModel;
use Traversable;

final class ProfileLoginControl implements ViewModel
{
    use ArrayAccessFromProperties;
    use ArrayFromProperties;
    use SimplifyAssets;

    private $button;
    private $displayName;
    private $isLoggedIn;
    private $linkFieldData;
    private $linkFieldRoots;
    private $profileHomeUri;

    private function __construct()
    {
    }

    public static function loggedIn(
        string $profileHomeUri,
        string $displayName,
        array $linkFields
    ) : ProfileLoginControl {
        Assertion::notBlank($profileHomeUri);
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
        $loggedInControl->profileHomeUri = $profileHomeUri;
        $loggedInControl->linkFieldRoots = implode(', ', array_keys($linkFields));
        $loggedInControl->linkFieldData = $loggedInControl->buildLinkFieldsDataAttributeValues($linkFields);

        return $loggedInControl;
    }

    public static function notLoggedIn(string $uri) : ProfileLoginControl
    {
        Assertion::notBlank($uri);

        $notLoggedInControl = new static();
        $notLoggedInControl->isLoggedIn = null;
        $notLoggedInControl->button = Button::link('Log in / Register', $uri, Button::SIZE_EXTRA_SMALL, Button::STYLE_CONFIRM);

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
        yield 'resources/assets/css/profile-login-control.css';
    }

    public function getTemplateName(): string
    {
        return 'resources/templates/profile-login-control.mustache';
    }
}
