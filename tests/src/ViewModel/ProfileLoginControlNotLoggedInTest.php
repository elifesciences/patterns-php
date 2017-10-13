<?php

namespace tests\eLife\Patterns\ViewModel;

use eLife\Patterns\ViewModel\ProfileLoginControl;
use InvalidArgumentException;

final class ProfileLoginControlNotLoggedInTest extends ViewModelTest
{
    /**
     * @test
     */
    public function it_has_data()
    {
        $data = [
            'button' => [
                'classes' => 'button--extra-small button--confirm',
                'path' => 'The uri',
                'text' => 'Log in / Register',
            ],
        ];

        $profileLoginControl = ProfileLoginControl::notLoggedIn($data['button']['path']);

        $this->assertSame(null, $profileLoginControl['isLoggedIn']);
        $this->assertSame($data, $profileLoginControl->toArray());
    }

    /**
     * @test
     */
    public function it_must_be_passed_a_uri()
    {
        $this->expectException(InvalidArgumentException::class);

        ProfileLoginControl::notLoggedIn('');
    }

    /**
     * @test
     */
    public function it_must_indicate_its_not_logged_in()
    {
        $profileLoginControl = ProfileLoginControl::notLoggedIn('some uri');
        $this->assertNull($profileLoginControl['isLoggedIn']);
    }

    public function viewModelProvider() : array
    {
        return [
            [ProfileLoginControl::notLoggedIn('#loginUri')],
        ];
    }

    protected function expectedTemplate() : string
    {
        return 'resources/templates/profile-login-control.mustache';
    }
}
