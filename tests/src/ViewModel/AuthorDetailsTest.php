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
            'details' => [
                [
                    'heading' => 'single detail',
                    'value' => 'value',
                ],
                [
                    'heading' => 'many details',
                    'values' => ['value 1', 'value 2'],
                ],
                [
                    'heading' => 'many details 2',
                    'value' => 'value 1',
                ],
            ],
            'orcid' => '0000-0002-1825-0097',
        ];

        $authorDetails = AuthorDetails::forPerson($data['authorId'], $data['name'], [$data['details'][0]['heading'] => $data['details'][0]['value'], $data['details'][1]['heading'] => $data['details'][1]['values'], $data['details'][2]['heading'] => [$data['details'][2]['value']]], $data['orcid']);

        $this->assertSame($data['authorId'], $authorDetails['authorId']);
        $this->assertSame($data['name'], $authorDetails['name']);
        $this->assertSame($data['details'], $authorDetails['details']);
        $this->assertSame($data['orcid'], $authorDetails['orcid']);
        $this->assertSame($data, $authorDetails->toArray());

        $data = [
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
            'groups' => [
                [
                    'groupName' => 'group',
                    'items' => ['item'],
                ],
            ],
        ];

        $authorDetails = AuthorDetails::forGroup($data['authorId'], $data['name'], [$data['details'][0]['heading'] => $data['details'][0]['value'], $data['details'][1]['heading'] => $data['details'][1]['values']], [$data['groups'][0]['groupName'] => $data['groups'][0]['items']]);

        $this->assertSame($data['authorId'], $authorDetails['authorId']);
        $this->assertSame($data['name'], $authorDetails['name']);
        $this->assertSame($data['details'], $authorDetails['details']);
        $this->assertSame($data['groups'], $authorDetails['groups']);
        $this->assertSame($data, $authorDetails->toArray());
    }

    /**
     * @test
     */
    public function it_cannot_have_a_blank_id()
    {
        $this->expectException(InvalidArgumentException::class);

        AuthorDetails::forPerson('', 'name');
    }

    /**
     * @test
     */
    public function it_cannot_have_a_blank_name()
    {
        $this->expectException(InvalidArgumentException::class);

        AuthorDetails::forPerson('id', '');
    }

    public function viewModelProvider() : array
    {
        return [
            'minimum person' => [AuthorDetails::forPerson('id', 'name')],
            'maximum person' => [AuthorDetails::forPerson('id', 'name', ['single detail' => 'value', 'many details' => ['value1', 'value2']], '0000-0002-1825-0097')],
            'minimum group' => [AuthorDetails::forGroup('id', 'name')],
            'maximum group' => [
                AuthorDetails::forGroup('id', 'name', ['single detail' => 'value', 'many details' => ['value1', 'value2']], ['group' => ['item']]),
            ],
        ];
    }

    protected function expectedTemplate() : string
    {
        return 'resources/templates/author-details.mustache';
    }
}
