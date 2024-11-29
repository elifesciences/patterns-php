<?php

namespace tests\eLife\Patterns\ViewModel;

use eLife\Patterns\ViewModel\LoginControl;
use InvalidArgumentException;

final class LoginControlNotLoggedInTest extends ViewModelTest
{
    /**
     * @test
     */
    public function it_has_data()
    {
        $data = [
            'button' => [
                'classes' => 'button--login',
                'path' => 'The uri',
                'text' => 'Log in / Register<span class="visuallyhidden"> (via Orcid)</span>',
            ],
        ];

        $loginControl = LoginControl::notLoggedIn($data['button']['text'], $data['button']['path']);

        $this->assertSame(null, $loginControl['isLoggedIn']);
        $this->assertSame($data, $loginControl->toArray());
    }

    /**
     * @test
     */
    public function it_must_be_passed_a_uri()
    {
        $this->expectException(InvalidArgumentException::class);

        LoginControl::notLoggedIn('text', '');
    }

    /**
     * @test
     */
    public function it_must_be_passed_text()
    {
        $this->expectException(InvalidArgumentException::class);

        LoginControl::notLoggedIn('', '/log-in');
    }

    /**
     * @test
     */
    public function it_must_indicate_its_not_logged_in()
    {
        $loginControl = LoginControl::notLoggedIn('text', 'some uri');
        $this->assertNull($loginControl['isLoggedIn']);
    }

    public function viewModelProvider(): array
    {
        return [
            [LoginControl::notLoggedIn('some text', '#loginUri')],
        ];
    }

    protected function expectedTemplate(): string
    {
        return 'resources/templates/login-control.mustache';
    }
}
