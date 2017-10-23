<?php

namespace tests\eLife\Patterns\ViewModel;

use eLife\Patterns\ViewModel\ContentHeaderProfile;
use InvalidArgumentException;

final class ContentHeaderProfileTest extends ViewModelTest
{
    private $linksData = [

        'secondaryLinks' => [

            'input' => [
                'link 1 text' => 'link 1 uri',
                'link 2 text' => 'link 2 uri',
            ],

            'expectedOutput' => [
                [
                    'text' => 'link 1 text',
                    'uri' => 'link 1 uri',
                ],
                [
                    'text' => 'link 2 text',
                    'uri' => 'link 2 uri',
                ],
            ],

        ],

        'logoutLink' => [

            'input' => [
                'log out link text' => 'log out link uri',
            ],

            'expectedOutput' => [
                'text' => 'log out link text',
                'uri' => 'log out link uri',
            ],
        ],
    ];

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
        ];

        $contentHeader = new ContentHeaderProfile($data['displayName'], $this->linksData['logoutLink']['input'], $this->linksData['secondaryLinks']['input'], $data['affiliations'], $data['emailAddress']);


        $this->assertSame($data['affiliations'], $contentHeader['details']['affiliations']);
        $this->assertSame($data['displayName'], $contentHeader['displayName']);
        $this->assertSame($data['emailAddress'], $contentHeader['details']['emailAddress']);
        $this->assertSame($this->linksData['logoutLink']['expectedOutput'], $contentHeader['logoutLink']);
        $this->assertSame($this->linksData['secondaryLinks']['expectedOutput'], $contentHeader['secondaryLinks']);

        $data['secondaryLinks'] = $this->linksData['secondaryLinks']['expectedOutput'];
        $data['logoutLink'] = $this->linksData['logoutLink']['expectedOutput'];

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

        new ContentHeaderProfile('', ['log out link text' => 'log out link uri']);
    }

    /**
     * @test
     */
    public function supplied_affiliations_is_set_as_a_property_of_details()
    {

        $contentHeaderProfile = new ContentHeaderProfile(
            'Display name',
            ['log out link text' => 'log out link uri'],
            [],
            [
                'affiliation 1',
                'affiliation 2'
            ]);

        $this->assertSame(
            [
                'affiliation 1',
                'affiliation 2'
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
            ['log out link text' => 'log out link uri'],
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

        $contentHeaderProfile = new ContentHeaderProfile('Display name', ['log out link text' => 'log out link uri']);

        $this->assertNull($contentHeaderProfile['details']);
    }

    /**
     * @test
     */
    public function it_must_have_a_log_out_link()
    {
        $this->expectException(InvalidArgumentException::class);

        new ContentHeaderProfile('Display Name', []);
    }

    public function viewModelProvider() : array
    {
        return [
            'minimum' => [new ContentHeaderProfile('Display name', ['logout link text' => 'logout link url'])],
            'with email address' => [
                new ContentHeaderProfile(
                    'Display name',
                    [
                        'logout link text' => 'logout link url',
                    ],
                    [],
                    [],
                    'email@address.com'
                ),
            ],
            'with affiliations' => [
                new ContentHeaderProfile(
                    'Display name',
                    [
                        'logout link text' => 'logout link url',
                    ],
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
                    [
                        'logout link text' => 'logout link url',
                    ],
                    [],
                    [
                        'affiliation 1',
                        'affiliation 2',
                    ],
                    'email@address.com'
                ),
            ],
            'with affiliations, email address and secondary links' => [
                new ContentHeaderProfile(
                    'Display name',
                    [
                        'logout link text' => 'logout link url',
                    ],
                    [
                        'link 1 text' => '/link-1-uri',
                        'link 2 text' => '/link-2-uri',
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
