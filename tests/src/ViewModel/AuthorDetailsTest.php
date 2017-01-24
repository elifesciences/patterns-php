<?php

namespace tests\eLife\Patterns\ViewModel;

use eLife\Patterns\ViewModel\AuthorDetails;
use InvalidArgumentException;

final class AuthorDetailsTest extends ViewModelTest
{
    /**
     * @test
     */
    public function it_has_data()
    {
        $data = [
            'authorId' => 'id',
            'name' => 'name',
            'hasAffiliations' => true,
            'affiliations' => ['affiliation'],
            'hasPresentAddresses' => true,
            'presentAddresses' => ['present address'],
            'contributionStatement' => 'contribution statement',
            'equalContributionStatement' => 'equal contributions statement',
            'hasMeansOfCorrespondence' => true,
            'meansOfCorrespondence' => [
                [
                    'isEmail' => true,
                    'value' => 'email@example.com',
                ],
                [
                    'isEmail' => false,
                    'value' => '+44 1223 855340',
                ],
            ],
            'competingInterest' => 'competing interest',
            'orcid' => '0000-0002-1825-0097',
        ];

        $authorDetails = new AuthorDetails('id', 'name', ['affiliation'], ['present address'], 'contribution statement', 'equal contributions statement', ['email@example.com'], ['+44 1223 855340'], 'competing interest', '0000-0002-1825-0097');

        $this->assertSame($data['authorId'], $authorDetails['authorId']);
        $this->assertSame($data['name'], $authorDetails['name']);
        $this->assertSame($data['hasAffiliations'], $authorDetails['hasAffiliations']);
        $this->assertSame($data['affiliations'], $authorDetails['affiliations']);
        $this->assertSame($data['hasPresentAddresses'], $authorDetails['hasPresentAddresses']);
        $this->assertSame($data['presentAddresses'], $authorDetails['presentAddresses']);
        $this->assertSame($data['contributionStatement'], $authorDetails['contributionStatement']);
        $this->assertSame($data['equalContributionStatement'], $authorDetails['equalContributionStatement']);
        $this->assertSame($data['hasMeansOfCorrespondence'], $authorDetails['hasMeansOfCorrespondence']);
        $this->assertSame($data['meansOfCorrespondence'], $authorDetails['meansOfCorrespondence']);
        $this->assertSame($data['competingInterest'], $authorDetails['competingInterest']);
        $this->assertSame($data['orcid'], $authorDetails['orcid']);
        $this->assertSame($data, $authorDetails->toArray());
    }

    /**
     * @test
     */
    public function it_cannot_have_a_blank_id()
    {
        $this->expectException(InvalidArgumentException::class);

        new AuthorDetails('', 'name', [], [], null, null, [], [], 'competing interests');
    }

    /**
     * @test
     */
    public function it_cannot_have_a_blank_name()
    {
        $this->expectException(InvalidArgumentException::class);

        new AuthorDetails('id', '', [], [], null, null, [], [], 'competing interests');
    }

    /**
     * @test
     */
    public function it_cannot_have_a_blank_affiliation()
    {
        $this->expectException(InvalidArgumentException::class);

        new AuthorDetails('id', 'name', [''], [], null, null, [], [], 'competing interests');
    }

    /**
     * @test
     */
    public function it_cannot_have_a_blank_present_address()
    {
        $this->expectException(InvalidArgumentException::class);

        new AuthorDetails('id', 'name', [], [''], null, null, [], [], 'competing interests');
    }

    /**
     * @test
     */
    public function it_cannot_have_a_blank_email_address()
    {
        $this->expectException(InvalidArgumentException::class);

        new AuthorDetails('id', 'name', [], [], null, null, [''], [], 'competing interests');
    }

    /**
     * @test
     */
    public function it_cannot_have_a_blank_phone_number()
    {
        $this->expectException(InvalidArgumentException::class);

        new AuthorDetails('id', 'name', [], [], null, null, [], [''], 'competing interests');
    }

    public function viewModelProvider() : array
    {
        return [
            'maximum' => [new AuthorDetails('id', 'name', ['affiliation'], ['present address'], 'contribution statement', 'equal contributions statement', ['email@example.com'], ['+44 1223 855340'], 'competing interest', '0000-0002-1825-0097')],
            'minimum' => [new AuthorDetails('id', 'name', [], [], null, null, [], [], 'competing interests')],
        ];
    }

    protected function expectedTemplate() : string
    {
        return '/elife/patterns/templates/author-details.mustache';
    }
}
