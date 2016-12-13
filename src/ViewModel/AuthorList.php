<?php

namespace eLife\Patterns\ViewModel;

use Assert\Assertion;
use eLife\Patterns\ArrayAccessFromProperties;
use eLife\Patterns\ArrayFromProperties;
use eLife\Patterns\CastsToArray;

final class AuthorList implements CastsToArray
{
    use ArrayAccessFromProperties;
    use ArrayFromProperties;

    private $list;
    private $firstAuthorOnly;
    private $hasEtAl = false;

    private function __construct(array $list = null, string $firstAuthorOnly = null)
    {
        $this->list = $list;

        if ($firstAuthorOnly) {
            $this->firstAuthorOnly = $firstAuthorOnly;
            $this->hasEtAl = true;
        }
    }

    public static function readMoreFromList(AuthorList $authorList)
    {
        Assertion::isInstanceOf($authorList->list[0], Author::class);

        return self::asReadMore($authorList->list[0]['name']);
    }

    public static function asList($list)
    {
        Assertion::notEmpty($list, 'Author list must have at least one item.');
        Assertion::allIsInstanceOf($list, Author::class);

        return new static(
            $list
        );
    }

    public static function asReadMore(string $firstAuthor)
    {
        Assertion::notBlank($firstAuthor);

        return new static(
            null,
            $firstAuthor
        );
    }
}
