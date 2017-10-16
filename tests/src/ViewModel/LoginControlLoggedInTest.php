<?php

namespace tests\eLife\Patterns\ViewModel;

use eLife\Patterns\ViewModel\LoginControl;
use InvalidArgumentException;

final class LoginControlLoggedInTest extends ViewModelTest
{
    private $linkFields = [
        'input' => [
            'profile-manage' => [
                'uri' => '/profileManageURI',
                'text' => 'Manage my profile',
            ],
            'logout' => [
                'uri' => '/log-out',
                'text' => 'Log out',
            ],
        ],
        'expectedOutput' => [
            'linkFieldRoots' => 'profile-manage, logout',
            'linkFieldData' => 'data-profile-manage-uri="/profileManageURI" data-profile-manage-text="Manage my profile" data-logout-uri="/log-out" data-logout-text="Log out"',
        ],
    ];

    /**
     * @test
     */
    public function it_has_data()
    {
        $data = [
            'displayName' => 'My name',
            'isLoggedIn' => true,
            'linkFields' => $this->linkFields['input'],
            'defaultUri' => '/defaultUri',
        ];


        $profileLoginControl = LoginControl::loggedIn($data['defaultUri'], $data['displayName'], $this->linkFields['input']);

        $this->assertSame($data['isLoggedIn'], $profileLoginControl['isLoggedIn']);
        $this->assertSame($data['defaultUri'], $profileLoginControl['defaultUri']);

        $this->assertSame($this->linkFields['expectedOutput']['linkFieldRoots'], $profileLoginControl['linkFieldRoots']);
        $this->assertSame($this->linkFields['expectedOutput']['linkFieldData'], $profileLoginControl['linkFieldData']);

        // Ugly hack to get the properties in the correct order for the following assertSame :-(
        $data['linkFieldData'] = $this->linkFields['expectedOutput']['linkFieldData'];
        $data['linkFieldRoots'] = $this->linkFields['expectedOutput']['linkFieldRoots'];
        unset($data['linkFields']);
        unset($data['defaultUri']);
        $data['defaultUri'] = '/defaultUri';

        $this->assertSame($data, $profileLoginControl->toArray());
    }

    /**
     * @test
     */
    public function it_must_indicate_it_is_logged_in()
    {
        $profileLoginControl = LoginControl::loggedIn('/defaultUri', 'Display Name', $this->linkFields['input']);
        $this->assertTrue($profileLoginControl['isLoggedIn']);
    }

    /**
     * @test
     */
    public function it_must_be_given_a_profile_home_link()
    {
        $this->expectException(InvalidArgumentException::class);

        LoginControl::loggedIn('', 'Display Name', $this->linkFields['input']);
    }

    /**
     * @test
     */
    public function it_must_be_given_a_display_name()
    {
        $this->expectException(InvalidArgumentException::class);

        LoginControl::loggedIn('/defaultUri', '', $this->linkFields['input']);
    }

    /**
     * @test
     */
    public function it_must_be_given_link_fields()
    {
        $this->expectException(InvalidArgumentException::class);

        LoginControl::loggedIn('/defaultUri', 'Display Name', []);
    }

    /**
     * @test
     */
    public function it_must_have_a_text_data_attribute_for_each_data_attribute_root()
    {
        $this->expectException(InvalidArgumentException::class);

        LoginControl::loggedIn(
            '/defaultUri',
            'Display Name',
            [
                'root-name-1' => [
                    'uri' => '/uriOne',
                    'text' => 'Text one',
                ],
                'root-name-2' => [
                    'uri' => '/uriTwo',
                ],
            ]
        );
    }

    /**
     * @test
     */
    public function its_text_data_attributes_for_each_data_attribute_root_must_not_be_empty()
    {
        $this->expectException(InvalidArgumentException::class);

        LoginControl::loggedIn(
            '/defaultUri',
            'Display Name',
            [
                'root-name-1' => [
                    'uri' => '/uriOne',
                    'text' => 'Text one',
                ],
                'root-name-2' => [
                    'uri' => '/uriTwo',
                    'text' => '',
                ],
            ]
        );

    }

    /**
     * @test
     */
    public function it_must_have_a_uri_data_attribute_for_each_data_attribute_root()
    {
        $this->expectException(InvalidArgumentException::class);

        LoginControl::loggedIn(
            '/defaultUri',
            'Display Name',
            [
                'root-name-1' => [
                    'uri' => '/uriOne',
                    'text' => 'Text one',
                ],
                'root-name-2' => [
                    'text' => 'Text two',
                ],
            ]
        );
    }

    /**
     * @test
     */
    public function its_uri_data_attributes_for_each_data_attribute_root_must_not_be_empty()
    {
        $this->expectException(InvalidArgumentException::class);

        LoginControl::loggedIn(
            '/defaultUri',
            'Display Name',
            [
                'root-name-1' => [
                    'uri' => '/uriOne',
                    'text' => 'Text one',
                ],
                'root-name-2' => [
                    'uri' => '',
                    'text' => 'Text two',
                ],
            ]
        );
    }

    /**
     * @test
     */
    public function each_data_attribute_root_must_have_only_have_keys_text_and_uri()
    {
        $this->expectException(InvalidArgumentException::class);

        LoginControl::loggedIn(
            '/defaultUri',
            'Display Name',
            [
                'root-name-1' => [
                    'uri' => '/uriOne',
                    'text' => 'Text one',
                    'wrongKey' => 'should not be here',
                ]
            ]
        );
    }

    public function viewModelProvider() : array
    {
        return [
            [LoginControl::loggedIn('/defaultUri', 'Display Name', $this->linkFields['input'])],
        ];
    }

    protected function expectedTemplate() : string
    {
        return 'resources/templates/login-control.mustache';
    }
}
