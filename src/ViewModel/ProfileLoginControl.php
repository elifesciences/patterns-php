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
        array $linkFieldRootsRaw,
        array $linkFieldDataRaw
    ) : ProfileLoginControl {
        Assertion::notBlank($profileHomeUri);
        Assertion::notBlank($displayName);
        Assertion::notBlank($linkFieldRootsRaw);
        Assertion::notBlank($linkFieldDataRaw);

        foreach ($linkFieldRootsRaw as $linkFieldRoot) {
            $correspondingUriAttribute = $linkFieldRoot.'-uri';
            Assertion::inArray($correspondingUriAttribute, array_keys($linkFieldDataRaw));
            Assertion::notBlank($linkFieldDataRaw[$correspondingUriAttribute]);

            $correspondingTextAttribute = $linkFieldRoot.'-text';
            Assertion::inArray($correspondingTextAttribute, array_keys($linkFieldDataRaw));
            Assertion::notBlank($linkFieldDataRaw[$correspondingTextAttribute]);
        }

        $loggedInControl = new static();
        $loggedInControl->isLoggedIn = true;
        $loggedInControl->displayName = $displayName;
        $loggedInControl->profileHomeUri = $profileHomeUri;
        $loggedInControl->linkFieldRoots = implode(', ', $linkFieldRootsRaw);
        $loggedInControl->linkFieldData = $loggedInControl->buildLinkFieldsDataAttributeValues($linkFieldDataRaw);

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

    private static function buildLinkFieldsDataAttributeValues(array $linkFieldDataRaw)
    {
        $dataAttributesString = '';
        foreach ($linkFieldDataRaw as $fieldName => $fieldValue) {
            $dataAttributesString .= ' data-'.$fieldName.'="'.$fieldValue.'"';
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
