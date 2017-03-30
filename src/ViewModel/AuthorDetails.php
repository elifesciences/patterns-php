<?php

namespace eLife\Patterns\ViewModel;

use Assert\Assertion;
use eLife\Patterns\ArrayAccessFromProperties;
use eLife\Patterns\ArrayFromProperties;
use eLife\Patterns\SimplifyAssets;
use eLife\Patterns\ViewModel;
use Traversable;

final class AuthorDetails implements ViewModel
{
    use ArrayAccessFromProperties;
    use ArrayFromProperties;
    use SimplifyAssets;

    private $authorId;
    private $name;
    private $details;
    private $orcid;
    private $groups;

    private function __construct(string $id, string $name, array $details = [], string $orcid = null, array $groups = [])
    {
        Assertion::notBlank($id);
        Assertion::notBlank($name);
        Assertion::allNotBlank($details);

        $this->authorId = $id;
        $this->name = $name;
        $this->details = array_map(function (string $heading, $value) {
            return array_filter([
                'heading' => $heading,
                'value' => is_string($value) ? $value : null,
                'values' => is_array($value) ? $value : null,
            ]);
        }, array_keys($details), array_values($details));
        $this->orcid = $orcid;
        $this->groups = array_map(function (string $name, array $items) {
            Assertion::notEmpty($items);
            Assertion::allString($items);

            return array_filter([
                'groupName' => $name,
                'items' => $items,
            ]);
        }, array_keys($groups), array_values($groups));
    }

    public static function forPerson(string $id, string $name, array $details = [], string $orcid = null) : AuthorDetails
    {
        return new self($id, $name, $details, $orcid);
    }

    public static function forGroup(string $id, string $name, array $details = [], array $groups = []) : AuthorDetails
    {
        return new self($id, $name, $details, null, $groups);
    }

    public function getTemplateName() : string
    {
        return 'resources/templates/author-details.mustache';
    }

    public function getStyleSheets() : Traversable
    {
        yield 'resources/assets/css/author-details.css';
    }
}
