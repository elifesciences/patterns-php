<?php

namespace tests\eLife\Patterns\ViewModel;

use eLife\Patterns\ViewModel\ProfileLoginControl;
use InvalidArgumentException;

final class ProfileLoginControlLoggedInTest extends ViewModelTest
{
    private $linkFieldRoots = [
        'input' => [
            'profile-manage',
            'logout',
        ],
        'expectedOutput' => 'profile-manage, logout'
    ];
    private $linkFieldData = [
        'input' => [
            'profile-manage-uri' => '/profileManageURI',
            'profile-manage-text' => 'Manage my profile',
            'logout-uri' => '/log-out',
            'logout-text' => 'Log out',
        ],
        'expectedOutput' => 'data-profile-manage-uri="/profileManageURI" data-profile-manage-text="Manage my profile" data-logout-uri="/log-out" data-logout-text="Log out"',
    ];

    /**
     * @test
     */
    public function it_has_data()
    {
        $data = [
            'displayName' => 'My name',
            'isLoggedIn' => true,
            'linkFieldData' => $this->linkFieldData,
            'linkFieldRoots' => $this->linkFieldRoots['input'],
            'profileHomeUri' => '/profileHomeUri',
        ];

        $profileLoginControl = ProfileLoginControl::loggedIn($data['profileHomeUri'], $data['displayName'], $this->linkFieldRoots['input'], $this->linkFieldData['input']);

        $this->assertSame($data['isLoggedIn'], $profileLoginControl['isLoggedIn']);
        $this->assertSame($data['profileHomeUri'], $profileLoginControl['profileHomeUri']);

        $this->assertSame($this->linkFieldRoots['expectedOutput'], $profileLoginControl['linkFieldRoots']);
        $this->assertSame($this->linkFieldData['expectedOutput'], $profileLoginControl['linkFieldData']);

        $data['linkFieldRoots'] = $this->linkFieldRoots['expectedOutput'];
        $data['linkFieldData'] = $this->linkFieldData['expectedOutput'];
        $this->assertSame($data, $profileLoginControl->toArray());
    }

    /**
     * @test
     */
    public function it_must_indicate_it_is_logged_in()
    {
        $profileLoginControl = ProfileLoginControl::LoggedIn('/profileHomeUri', 'Display Name', $this->linkFieldRoots['input'], $this->linkFieldData['input']);
        $this->assertTrue($profileLoginControl['isLoggedIn']);
    }

    /**
     * @test
     */
    public function it_must_be_given_a_profile_home_link()
    {
        $this->expectException(InvalidArgumentException::class);

        ProfileLoginControl::LoggedIn('', 'Display Name', $this->linkFieldRoots['input'], $this->linkFieldData['input']);
    }

    /**
     * @test
     */
    public function it_must_be_given_a_display_name()
    {
        $this->expectException(InvalidArgumentException::class);

        ProfileLoginControl::LoggedIn('/profileHomeUri', '', $this->linkFieldRoots['input'], $this->linkFieldData['input']);
    }

    /**
     * @test
     */
    public function it_must_be_given_link_field_roots()
    {
        $this->expectException(InvalidArgumentException::class);

        ProfileLoginControl::LoggedIn('/profileHomeUri', 'Display Name', [], $this->linkFieldData['input']);

    }

    /**
     * @test
     */
    public function it_must_be_given_link_field_data()
    {
        $this->expectException(InvalidArgumentException::class);

        ProfileLoginControl::LoggedIn('/profileHomeUri', 'Display Name', $this->linkFieldRoots['input'], []);
    }

    /**
     * @test
     */
    public function it_must_have_a_text_data_attribute_for_each_data_attribute_root()
    {
        $this->expectException(InvalidArgumentException::class);

        ProfileLoginControl::LoggedIn(
            '/profileHomeUri',
            'Display Name',
            [
                'root-name-1',
                'root-name-2'
            ],
            [
                'root-name-1-uri' => '/uriOne',
                'root-name-1-text' => 'Text one',
                'root-name-2-uri' => '/uriTwo',
            ]
        );
    }

    /**
     * @test
     */
    public function its_text_data_attributes_for_each_data_attribute_root_must_not_be_empty()
    {
        $this->expectException(InvalidArgumentException::class);

        ProfileLoginControl::LoggedIn(
            '/profileHomeUri',
            'Display Name',
            [
                'root-name-1',
                'root-name-2'
            ],
            [
                'root-name-1-uri' => '/uriOne',
                'root-name-1-text' => 'Text one',
                'root-name-2-uri' => '/uriTwo',
                'root-name-2-text' => '',
            ]
        );
    }

    /**
     * @test
     */
    public function it_must_have_a_uri_data_attribute_for_each_data_attribute_root()
    {
        $this->expectException(InvalidArgumentException::class);

        ProfileLoginControl::LoggedIn(
            '/profileHomeUri',
            'Display Name',
            [
                'root-name-1',
                'root-name-2'
            ],
            [
                'root-name-1-uri' => '/uriOne',
                'root-name-1-text' => 'Text one',
                'root-name-2-text' => 'Text two',
            ]
        );
    }

    /**
     * @test
     */
    public function its_uri_data_attributes_for_each_data_attribute_root_must_not_be_empty()
    {
        $this->expectException(InvalidArgumentException::class);

        ProfileLoginControl::LoggedIn(
            '/profileHomeUri',
            'Display Name',
            [
                'root-name-1',
                'root-name-2'
            ],
            [
                'root-name-1-uri' => '/uriOne',
                'root-name-1-text' => 'Text one',
                'root-name-2-uri' => '',
                'root-name-2-text' => 'Text two',
            ]
        );
    }


    public function viewModelProvider() : array
    {

        return [
            [ProfileLoginControl::loggedIn('/profileHomeUri', 'Display Name', $this->linkFieldRoots['input'], $this->linkFieldData['input'])],
        ];
    }

    protected function expectedTemplate() : string
    {
        return 'resources/templates/profile-login-control.mustache';
    }
}
