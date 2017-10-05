<?php

namespace tests\eLife\Patterns\ViewModel;

use eLife\Patterns\ViewModel\ProfileLoginControl;
use InvalidArgumentException;

final class ProfileLoginControlLoggedInTest extends ViewModelTest
{
    /**
     * @test
     */
    public function it_has_data()
    {
        $data = [
            'displayName' => 'My name',
            'isLoggedIn' => true,
            'logoutUri' => 'Logout uri',
            'profileHomeLink' => 'Profile home link',
            'profileManageLink' => 'Profile manage link',
        ];

        $profileLoginControl = ProfileLoginControl::loggedIn($data['profileHomeLink'], $data['displayName'], $data['profileManageLink'], $data['logoutUri']);

        $this->assertSame($data['isLoggedIn'], $profileLoginControl['isLoggedIn']);
        $this->assertSame($data['profileHomeLink'], $profileLoginControl['profileHomeLink']);
        $this->assertSame($data['displayName'], $profileLoginControl['displayName']);
        $this->assertSame($data['profileManageLink'], $profileLoginControl['profileManageLink']);
        $this->assertSame($data['logoutUri'], $profileLoginControl['logoutUri']);
        $this->assertSame($data, $profileLoginControl->toArray());
    }

    /**
     * @test
     */
    public function it_must_indicate_its_logged_in()
    {
        $profileLoginControl = ProfileLoginControl::notLoggedIn('some uri');
        $this->assertNull($profileLoginControl['isLoggedIn']);
    }

    /**
     * @test
     */
    public function it_must_be_given_a_profile_home_link()
    {
        $this->expectException(InvalidArgumentException::class);

        ProfileLoginControl::loggedIn('', 'display name', 'manage profile link', 'logout uri');
    }

    /**
     * @test
     */
    public function it_must_be_given_a_display_name()
    {
        $this->expectException(InvalidArgumentException::class);

        ProfileLoginControl::loggedIn('profile home link', '', 'manage profile link', 'logout uri');
    }

    /**
     * @test
     */
    public function it_must_be_given_a_profile_manage_link()
    {
        $this->expectException(InvalidArgumentException::class);

        ProfileLoginControl::loggedIn('profile home link', 'display name', '', 'logout uri');
    }

    /**
     * @test
     */
    public function it_must_be_given_a_logout_uri()
    {
        $this->expectException(InvalidArgumentException::class);

        ProfileLoginControl::loggedIn('profile home link', 'display name', 'manage profile link', '');
    }

    public function viewModelProvider() : array
    {
        return [
            [ProfileLoginControl::loggedIn('#myProfileUri', 'My Name', '#manageMyProfileUri', '#logoutUri')],
        ];
    }

    protected function expectedTemplate() : string
    {
        return 'resources/templates/profile-login-control.mustache';
    }
}
