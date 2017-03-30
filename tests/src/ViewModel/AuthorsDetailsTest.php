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
                    'details' => [
                        [
                            'heading' => 'single detail',
                            'value' => 'value',
                        ],
                        [
                            'heading' => 'many details',
                            'values' => ['value 1', 'value 2'],
                        ],
                    ],
                    'orcid' => '0000-0002-1825-0097',
                ],
                [
                    'authorId' => 'id',
                    'name' => 'name',
                ],
            ],
        ];

        $authorsDetails = new AuthorsDetails(
            $maximum = AuthorDetails::forPerson('id', 'name', ['single detail' => 'value', 'many details' => ['value 1', 'value 2']], '0000-0002-1825-0097'),
            $minimum = AuthorDetails::forPerson('id', 'name')
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
                    $maximum = AuthorDetails::forPerson('id', 'name', ['single detail' => 'value', 'many details' => ['value 1', 'value 2']], '0000-0002-1825-0097'),
                    $minimum = AuthorDetails::forPerson('id', 'name')
                ),
            ],
        ];
    }

    protected function expectedTemplate() : string
    {
        return 'resources/templates/authors-details.mustache';
    }
}
