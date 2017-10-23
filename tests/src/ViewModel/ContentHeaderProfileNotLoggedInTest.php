<?php

namespace tests\eLife\Patterns\ViewModel;

use eLife\Patterns\ViewModel\ContentHeaderProfile;
use eLife\Patterns\ViewModel\Link;
use InvalidArgumentException;

final class ContentHeaderProfileNotLoggedInTest extends ViewModelTest
{
    /**
     * @test
     */
    public function it_has_data()
    {
        $details = [
            'affiliations' => [
                'affiliation 1',
                'affiliation 2',
            ],
            'emailAddress' => 'email@address1.com',
        ];

        $data = [
            'affiliations' => $details['affiliations'],
            'emailAddress' => $details['emailAddress'],
            'displayName' => 'Display name',
        ];

        $contentHeader = ContentHeaderProfile::notLoggedIn($data['displayName'], $data['affiliations'], $data['emailAddress']);

        $this->assertSame($data['displayName'], $contentHeader['displayName']);
        $this->assertSame($data['affiliations'], $contentHeader['details']['affiliations']);
        $this->assertSame($data['emailAddress'], $contentHeader['details']['emailAddress']);

        $data['details'] = $details;
        unset($data['affiliations']);
        unset($data['emailAddress']);
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
    public function details_is_null_if_no_affiliations_nor_email_address_is_supplied()
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
            'with affiliations and email address' => [
                ContentHeaderProfile::notLoggedIn(
                    'Display name',
                    [
                        'affiliation 1',
                        'affiliation 2',
                    ],
                    'email@address.com'
                ),
            ],
        ];
    }

    protected function expectedTemplate() : string
    {
        return 'resources/templates/content-header-profile.mustache';
    }
}
