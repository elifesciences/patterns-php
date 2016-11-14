<?php

namespace tests\eLife\Patterns\ViewModel;

use eLife\Patterns\ViewModel\AuthorDetails;
use eLife\Patterns\ViewModel\AuthorsDetails;

final class AuthorsDetailsTest extends ViewModelTest
{
    /**
     * @test
     */
    public function it_has_data()
    {
        $data = [
            'authorDetails' => [
                [
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
                ],
                [
                    'authorId' => 'id',
                    'name' => 'name',
                    'hasAffiliations' => false,
                    'hasPresentAddresses' => false,
                    'hasMeansOfCorrespondence' => false,
                    'competingInterest' => 'competing interest',
                ],
            ],
        ];

        $authorsDetails = new AuthorsDetails(
            $maximum = new AuthorDetails('id', 'name', ['affiliation'], ['present address'], 'contribution statement', 'equal contributions statement', ['email@example.com'], ['+44 1223 855340'], 'competing interest', '0000-0002-1825-0097'),
            $minimum = new AuthorDetails('id', 'name', [], [], null, null, [], [], 'competing interest')
        );

        $this->assertCount(2, $data['authorDetails']);
        $this->assertSame($data['authorDetails'][0], $maximum->toArray());
        $this->assertSame($data['authorDetails'][1], $minimum->toArray());
        $this->assertSame($data, $authorsDetails->toArray());
    }

    public function viewModelProvider() : array
    {
        return [
            [
                new AuthorsDetails(
                    $maximum = new AuthorDetails('id', 'name', ['affiliation'], ['present address'], 'contribution statement', 'equal contributions statement', ['email@example.com'], ['+44 1223 855340'], 'competing interest', '0000-0002-1825-0097'),
                    $minimum = new AuthorDetails('id', 'name', [], [], null, null, [], [], 'competing interests')
                ),
            ],
        ];
    }

    protected function expectedTemplate() : string
    {
        return '/elife/patterns/templates/authors-details.mustache';
    }
}
