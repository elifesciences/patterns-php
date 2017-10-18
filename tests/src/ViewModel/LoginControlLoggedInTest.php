<?php

namespace tests\eLife\Patterns\ViewModel;

use eLife\Patterns\ViewModel\Image;
use eLife\Patterns\ViewModel\LoginControl;
use eLife\Patterns\ViewModel\Picture;
use InvalidArgumentException;

final class LoginControlLoggedInTest extends ViewModelTest
{
    private $linkFields = [
        'input' => [
            'Manage my profile' => '/profileManageURI',
            'Log out' => '/log-out',
        ],
        'expectedOutput' => [
            'linkFieldRoots' => 'link1, link2',
            'linkFieldData' => 'data-link1-text="Manage my profile" data-link1-uri="/profileManageURI" data-link2-text="Log out" data-link2-uri="/log-out"',

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
            'icon' => [
                'fallback' => [
                    'altText' => '',
                    'defaultPath' => '/default/path',
                ],
            ],

        ];

        $profileLoginControl = LoginControl::loggedIn($data['defaultUri'], $data['displayName'], $this->linkFields['input'], new Picture([], new Image('/default/path')));

        $this->assertSame($data['isLoggedIn'], $profileLoginControl['isLoggedIn']);
        $this->assertSame($data['defaultUri'], $profileLoginControl['defaultUri']);
        $this->assertSame($data['icon'], $profileLoginControl['icon']->toArray());

        $this->assertSame($this->linkFields['expectedOutput']['linkFieldRoots'], $profileLoginControl['linkFieldRoots']);
        $this->assertSame($this->linkFields['expectedOutput']['linkFieldData'], $profileLoginControl['linkFieldData']);

        $data['linkFieldData'] = $this->linkFields['expectedOutput']['linkFieldData'];
        $data['linkFieldRoots'] = $this->linkFields['expectedOutput']['linkFieldRoots'];
        unset($data['linkFields']);
        $this->assertSameValuesWithoutOrder($data, $profileLoginControl->toArray());
    }

    /**
     * @test
     */
    public function it_must_indicate_it_is_logged_in()
    {
        $profileLoginControl = LoginControl::loggedIn('/defaultUri', 'Display Name', $this->linkFields['input'], new Picture([], new Image('/default/path')));
        $this->assertTrue($profileLoginControl['isLoggedIn']);
    }

    /**
     * @test
     */
    public function it_must_be_given_a_profile_home_link()
    {
        $this->expectException(InvalidArgumentException::class);

        LoginControl::loggedIn('', 'Display Name', $this->linkFields['input'], new Picture([], new Image('/default/path')));
    }

    /**
     * @test
     */
    public function it_must_be_given_a_display_name()
    {
        $this->expectException(InvalidArgumentException::class);

        LoginControl::loggedIn('/defaultUri', '', $this->linkFields['input'], new Picture([], new Image('/default/path')));
    }

    /**
     * @test
     */
    public function it_must_be_given_link_fields()
    {
        $this->expectException(InvalidArgumentException::class);

        LoginControl::loggedIn('/defaultUri', 'Display Name', [], new Picture([], new Image('/default/path')));
    }

    /**
     * @test
     */
    public function a_link_field_key_must_not_be_empty()
    {
        $this->expectException(InvalidArgumentException::class);

        LoginControl::loggedIn(
            '/defaultUri',
            'Display Name',
            [
                'Text one' => '/uriOne',
                '' => '/uriTwo',
            ],
            new Picture([], new Image('/default/path'))
        );
    }

    /**
     * @test
     */
    public function a_link_field_value_must_not_be_empty()
    {
        $this->expectException(InvalidArgumentException::class);

        LoginControl::loggedIn(
            '/defaultUri',
            'Display Name',
            [
                'Text one' => '/uriOne',
                'Text two' => '',
            ],
            new Picture([], new Image('/default/path'))
        );
    }

    public function viewModelProvider() : array
    {
        return [
            [LoginControl::loggedIn('/defaultUri', 'Display Name', $this->linkFields['input'], new Picture([], new Image('/default/path')))],
        ];
    }

    protected function expectedTemplate() : string
    {
        return 'resources/templates/login-control.mustache';
    }
}
