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
    private $hasAffiliations;
    private $affiliations;
    private $hasPresentAddresses;
    private $presentAddresses;
    private $contributionStatement;
    private $equalContributionStatement;
    private $hasMeansOfCorrespondence;
    private $meansOfCorrespondence;
    private $competingInterest;
    private $orcid;

    public function __construct(string $id, string $name, array $affiliations, array $presentAddresses, string $contributionStatement = null, string $equalContributionStatement = null, array $emailAddresses, array $phoneNumbers, string $competingInterest, string $orcid = null)
    {
        Assertion::notBlank($id);
        Assertion::notBlank($name);
        Assertion::allNotBlank($affiliations);
        Assertion::allNotBlank($presentAddresses);
        Assertion::allNotBlank($emailAddresses);
        Assertion::allNotBlank($phoneNumbers);

        $this->authorId = $id;
        $this->name = $name;
        $this->hasAffiliations = !empty($affiliations);
        $this->affiliations = $affiliations;
        $this->hasPresentAddresses = !empty($presentAddresses);
        $this->presentAddresses = $presentAddresses;
        $this->contributionStatement = $contributionStatement;
        $this->equalContributionStatement = $equalContributionStatement;
        $this->hasMeansOfCorrespondence = !empty($emailAddresses) || !empty($phoneNumbers);
        $this->meansOfCorrespondence = array_map(function (string $emailAddress) {
            return [
                'isEmail' => true,
                'value' => $emailAddress,
            ];
        }, $emailAddresses);
        $this->meansOfCorrespondence = array_merge($this->meansOfCorrespondence, array_map(function (string $phoneNumber) {
            return [
                'isEmail' => false,
                'value' => $phoneNumber,
            ];
        }, $phoneNumbers));
        $this->competingInterest = $competingInterest;
        $this->orcid = $orcid;
    }

    public function getTemplateName() : string
    {
        return '/elife/patterns/templates/author-details.mustache';
    }

    public function getStyleSheets() : Traversable
    {
        yield '/elife/patterns/assets/css/author-details.css';
    }
}
