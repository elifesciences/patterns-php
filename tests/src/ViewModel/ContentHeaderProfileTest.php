<?php

namespace tests\eLife\Patterns\ViewModel;

use eLife\Patterns\ViewModel\ContentHeaderProfile;
use eLife\Patterns\ViewModel\Link;
use InvalidArgumentException;

final class ContentHeaderProfileTest extends ViewModelTest
{
    /**
     * @test
     */
    public function it_has_data()
    {
        $data = [
            'affiliations' => [
                'affiliation 1',
                'affiliation 2',
            ],
            'displayName' => 'Display name',
            'emailAddress' => 'email@address1.com',
            'logoutLink' => new Link('log out link text', '/log-out-link-uri'),
            'secondaryLinks' => [
                new Link('link 1 text', 'link 1 url'),
                new Link('link 2 text', 'link 2 url'),
            ],
        ];

        $contentHeader = new ContentHeaderProfile($data['displayName'], $data['logoutLink'], $data['secondaryLinks'], $data['affiliations'], $data['emailAddress']);

        $this->assertSame($data['affiliations'], $contentHeader['details']['affiliations']);
        $this->assertSame($data['displayName'], $contentHeader['displayName']);
        $this->assertSame($data['emailAddress'], $contentHeader['details']['emailAddress']);
        $this->assertSame($data['logoutLink'], $contentHeader['logoutLink']);
        $this->assertSame($data['secondaryLinks'], $contentHeader['secondaryLinks']);

        // TODO: Refactor details/affiliations/email address data to have input and expectedOutput
        $data['details']['affiliations'] = $data['affiliations'];
        unset($data['affiliations']);
        $data['details']['emailAddress'] = $data['emailAddress'];
        unset($data['emailAddress']);
        $this->assertSameWithoutOrder($data, $contentHeader->toArray());
    }

    /**
     * @test
     */
    public function it_must_have_a_display_name()
    {
        $this->expectException(InvalidArgumentException::class);

        new ContentHeaderProfile('', new Link('log out link text', '/log-out-link-uri'));
    }

    /**
     * @test
     */
    public function supplied_affiliations_is_set_as_a_property_of_details()
    {
        $contentHeaderProfile = new ContentHeaderProfile(
            'Display name',
            new Link('log out link text', '/log-out-link-uri'),
            [],
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
        $contentHeaderProfile = new ContentHeaderProfile(
            'Display name',
            new Link('log out link text', '/log-out-link-uri'),
            [],
            [],
            'email@address.com');

        $this->assertSame('email@address.com', $contentHeaderProfile['details']['emailAddress']);
    }

    /**
     * @test
     */
    public function details_is_null_if_no_affiliations_nor_email_address_is_supplied()
    {
        $contentHeaderProfile = new ContentHeaderProfile('Display name', new Link('log out link text', '/log-out-link-uri'));

        $this->assertNull($contentHeaderProfile['details']);
    }

    /**
     * @test
     */
    public function supplied_logout_link_becomes_logout_link_property()
    {
        $contentHeaderProfile = new ContentHeaderProfile(
            'Display name',
            new Link('log out link text', '/log-out-link-uri')
        );

        $this->assertSameWithoutOrder(
            new Link('log out link text', '/log-out-link-uri'),
            $contentHeaderProfile['logoutLink']);
    }

    /**
     * @test
     */
    public function supplied_secondary_links_becomes_secondary_links_property()
    {
        $contentHeaderProfile = new ContentHeaderProfile(
            'Display name',
            new Link('log out link text', '/log-out-link-uri'),
            [
                new Link('link 1 text', 'link 1 url'),
                new Link('link 2 text', 'link 2 url'),
            ]
        );

        $this->assertSameWithoutOrder(
            [
                new Link('link 1 text', 'link 1 url'),
                new Link('link 2 text', 'link 2 url'),
            ],
            $contentHeaderProfile['secondaryLinks']);
    }

    public function viewModelProvider() : array
    {
        return [
            'minimum' => [new ContentHeaderProfile('Display name')],
            'with log out link' => [
                new ContentHeaderProfile(
                    'Display name',
                    new Link('log out link text', '/log-out-link-uri')
                ),
            ],
            'with email address' => [
                new ContentHeaderProfile(
                    'Display name',
                    new Link('log out link text', '/log-out-link-uri'),
                    [],
                    [],
                    'email@address.com'
                ),
            ],
            'with affiliations' => [
                new ContentHeaderProfile(
                    'Display name',
                    new Link('log out link text', '/log-out-link-uri'),
                    [],
                    [
                        'affiliation 1',
                        'affiliation 2',
                    ]
                ),
            ],
            'with affiliations and email address' => [
                new ContentHeaderProfile(
                    'Display name',
                    new Link('log out link text', '/log-out-link-uri'),
                    [],
                    [
                        'affiliation 1',
                        'affiliation 2',
                    ],
                    'email@address.com'
                ),
            ],
            'with log out link, secondary links, affiliations and email address' => [
                new ContentHeaderProfile(
                    'Display name',
                    new Link('log out link text', '/log-out-link-uri'),
                    [
                        new Link('link 1 text', 'link 1 url'),
                        new Link('link 2 text', 'link 2 url'),
                    ],
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
