<?php

namespace tests\eLife\Patterns\ViewModel;

use eLife\Patterns\ViewModel\ContentHeaderProfile;
use eLife\Patterns\ViewModel\Orcid;
use InvalidArgumentException;

final class ContentHeaderProfileNotLoggedInTest extends ViewModelTest
{
    /**
     * @test
     */
    public function it_has_data()
    {
        $data = [
            'details' => [
                'affiliations' => [
                    'affiliation 1',
                    'affiliation 2',
                ],
                'emailAddress' => 'email@address1.com',
                'orcid' => [
                    'id' => '0000-0002-1825-0097',
                ],
            ],
            'displayName' => 'Display name',
        ];

        $contentHeader = ContentHeaderProfile::notLoggedIn($data['displayName'], $data['details']['affiliations'], $data['details']['emailAddress'], new Orcid($data['details']['orcid']['id']));

        $this->assertSameWithoutOrder($data['details'], $contentHeader['details']);
        $this->assertSame($data['displayName'], $contentHeader['displayName']);

        $this->assertSameWithoutOrder($data, $contentHeader->toArray());
    }

    /**
     * @test
     */
    public function it_must_have_a_display_name()
    {
        $this->expectException(InvalidArgumentException::class);

        ContentHeaderProfile::notLoggedIn('');
    }

    /**
     * @test
     */
    public function supplied_affiliations_is_set_as_a_property_of_details()
    {
        $contentHeaderProfile = ContentHeaderProfile::notLoggedIn(
            'Display name',
            [
                'affiliation 1',
                'affiliation 2',
            ]);

        $this->assertSame(
            [
                'affiliation 1',
                'affiliation 2',
            ],
            $contentHeaderProfile['details']['affiliations']);
    }

    /**
     * @test
     */
    public function supplied_email_address_is_set_as_a_property_of_details()
    {
        $contentHeaderProfile = ContentHeaderProfile::notLoggedIn(
            'Display name',
            [],
            'email@address.com');

        $this->assertSame('email@address.com', $contentHeaderProfile['details']['emailAddress']);
    }

    /**
     * @test
     */
    public function supplied_orcid_is_set_as_a_property_of_details()
    {
        $contentHeaderProfile = ContentHeaderProfile::notLoggedIn(
            'Display name',
            [],
            null,
            new Orcid('0000-0002-1825-0097')
        );

        $this->assertSame('0000-0002-1825-0097', $contentHeaderProfile['details']['orcid']['id']);
    }

    /**
     * @test
     */
    public function details_is_null_if_no_details_are_supplied()
    {
        $contentHeaderProfile = ContentHeaderProfile::notLoggedIn('Display name');

        $this->assertNull($contentHeaderProfile['details']);
    }

    public function viewModelProvider() : array
    {
        return [
            'minimum' => [ContentHeaderProfile::notLoggedIn('Display name')],
            'with email address' => [
                ContentHeaderProfile::notLoggedIn(
                    'Display name',
                    [],
                    'email@address.com'
                ),
            ],
            'with affiliations' => [
                ContentHeaderProfile::notLoggedIn(
                    'Display name',
                    [
                        'affiliation 1',
                        'affiliation 2',
                    ]
                ),
            ],
            'with orcid' => [
                ContentHeaderProfile::notLoggedIn(
                    'Display name',
                    [],
                    null,
                    new Orcid('0000-0002-1825-0097')
                ),
            ],
            'complete' => [
                ContentHeaderProfile::notLoggedIn(
                    'Display name',
                    [
                        'affiliation 1',
                        'affiliation 2',
                    ],
                    'email@address.com',
                    new Orcid('0000-0002-1825-0097')
                ),
            ],
        ];
    }

    protected function expectedTemplate() : string
    {
        return 'resources/templates/content-header-profile.mustache';
    }
}
