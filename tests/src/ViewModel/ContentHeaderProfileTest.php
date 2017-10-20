<?php

namespace tests\eLife\Patterns\ViewModel;

use eLife\Patterns\ViewModel\ContentHeaderProfile;
use InvalidArgumentException;

final class ContentHeaderProfileTest extends ViewModelTest
{
    private $linksData = [

        'miscLinks' => [

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
            'details' => [
                'affiliations' => [
                    'affiliation 1',
                    'affiliation 2',
                ],
                'emailAddress' => 'email@address1.com',
            ],
            'displayName' => 'Display name',
        ];

        $contentHeader = new ContentHeaderProfile($data['displayName'], $this->linksData['logoutLink']['input'], $this->linksData['miscLinks']['input'], $data['details']);

        $this->assertSame($data['displayName'], $contentHeader['displayName']);
        $this->assertSame($data['details'], $contentHeader['details']);
        $this->assertSame($this->linksData['logoutLink']['expectedOutput'], $contentHeader['logoutLink']);
        $this->assertSame($this->linksData['miscLinks']['expectedOutput'], $contentHeader['miscLinks']);

        $data['miscLinks'] = $this->linksData['miscLinks']['expectedOutput'];
        $data['logoutLink'] = $this->linksData['logoutLink']['expectedOutput'];
        $this->assertSame($data, $contentHeader->toArray());
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
    public function it_must_have_a_log_out_link()
    {
        $this->expectException(InvalidArgumentException::class);

        new ContentHeaderProfile('Display Name', []);
    }

    /**
     * @test
     */
    public function if_it_has_details_the_details_must_only_contain_emailAddress_or_affiliations_or_both()
    {
        $this->expectException(InvalidArgumentException::class);

        new ContentHeaderProfile('Display Name', ['log out link text' => 'log out link uri'], [],
            [
                'affiliations' => [
                    'affiliation 1',
                    'affiliation 2',
                ],
                'emailAddress' => 'email@address.com',
                'interloper' => 'should not be here',
            ]
        );
    }

    public function viewModelProvider() : array
    {
        return [
            'minimum' => [new ContentHeaderProfile('Display name', ['logout link text' => 'logout link url'])],
            'with email address detail' => [
                new ContentHeaderProfile(
                    'Display name',
                    [
                        'logout link text' => 'logout link url',
                    ],
                    [],
                    [
                        'emailAddress' => 'email@address.com',
                    ]
                ),
            ],
            'with affiliations detail' => [
                new ContentHeaderProfile(
                    'Display name',
                    [
                        'logout link text' => 'logout link url',
                    ],
                    [],
                    [
                        'affiliations' => [
                            'affiliation 1',
                            'affiliation 2',
                        ],
                    ]
                ),
            ],
            'with affiliations and email address detail (aka full detail)' => [
                new ContentHeaderProfile(
                    'Display name',
                    [
                        'logout link text' => 'logout link url',
                    ],
                    [],
                    [
                        'affiliations' => [
                            'affiliation 1',
                            'affiliation 2',
                        ],
                        'emailAddress' => 'email@address.com',
                    ]
                ),
            ],
            'with full detail and misc links' => [
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
                        'affiliations' => [
                            'affiliation 1',
                            'affiliation 2',
                        ],
                        'emailAddress' => 'email@address.com',
                    ]
                ),
            ],
        ];
    }

    protected function expectedTemplate() : string
    {
        return 'resources/templates/content-header-profile.mustache';
    }
}
