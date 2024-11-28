<?php

namespace eLife\Patterns\ViewModel;

use Assert\Assertion;
use eLife\Patterns\ArrayAccessFromProperties;
use eLife\Patterns\ArrayFromProperties;
use eLife\Patterns\ViewModel;

final class ArticleAssessmentTerms implements ViewModel
{
    use ArrayAccessFromProperties;
    use ArrayFromProperties;

    private $title;
    private $termDescription;
    private $terms;
    private $termDescriptionAriaLabel;

    public function __construct(string $title, string $termDescription, array $terms, string $termDescriptionAriaLabel = null)
    {
        Assertion::notBlank($title);
        Assertion::notBlank($termDescription);
        Assertion::notEmpty($terms);
        Assertion::allIsInstanceOf($terms, Term::class);
        Assertion::nullOrNotBlank($termDescriptionAriaLabel);

        $this->title = $title;
        $this->termDescription = $termDescription;
        $this->termDescriptionAriaLabel = $termDescriptionAriaLabel;

        $this->terms = array_map(function ($term) {
            $result = ['term' => $term['term']];

            if (isset($term['isHighlighted']) && $term['isHighlighted']) {
                $result['isHighlighted'] = true;
            }

            return $result;
        }, $terms);
    }

    public function getTemplateName() : string
    {
        return 'resources/templates/article-assessment-terms.mustache';
    }
}
