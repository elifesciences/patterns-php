<?php

namespace tests\eLife\Patterns\ViewModel;

use eLife\Patterns\ViewModel\HypothesisLoader;

final class HypothesisLoaderTest extends ViewModelTest
{
    /**
     * @test
     */
    public function it_has_data()
    {
        $data = [
            'core' => [
                'usernameUrl' => 'https://example.com/username',
                'hypothesisApiUrl' => 'https://example.com/h-api',
                'hypothesisAuthority' => 'Cartman',
                'iconPath' => 'https://example.com/icon',
            ],

            'loggedIn' => [
                'profilePath' => 'https://example.com/profile',
                'logoutPath' => 'https://example.com/log-out',
                'grantToken' => 'someGrantToken',
            ],

            'loggedOut' => [
                'loginPath' => 'https://example.com/log-in',
            ],
        ];

        $loaderLoggedIn = HypothesisLoader::loggedIn(
            $data['core']['usernameUrl'],
            $data['core']['hypothesisApiUrl'],
            $data['core']['hypothesisAuthority'],
            $data['core']['iconPath'],
            $data['loggedIn']['profilePath'],
            $data['loggedIn']['logoutPath'],
            $data['loggedIn']['grantToken']
        );

        $this->assertSame($data['core']['usernameUrl'], $loaderLoggedIn['usernameUrl']);
        $this->assertSame($data['core']['hypothesisApiUrl'], $loaderLoggedIn['hypothesisApiUrl']);
        $this->assertSame($data['core']['hypothesisAuthority'], $loaderLoggedIn['hypothesisAuthority']);
        $this->assertSame($data['core']['iconPath'], $loaderLoggedIn['iconPath']);
        $this->assertSame($data['loggedIn']['profilePath'], $loaderLoggedIn['profilePath']);
        $this->assertSame($data['loggedIn']['logoutPath'], $loaderLoggedIn['logoutPath']);
        $this->assertSame($data['loggedIn']['grantToken'], $loaderLoggedIn['grantToken']);

        $this->assertSameWithoutOrder(array_merge($data['core'], $data['loggedIn']), $loaderLoggedIn->toArray());

        $loaderLoggedOut = HypothesisLoader::loggedOut(
            $data['core']['usernameUrl'],
            $data['core']['hypothesisApiUrl'],
            $data['core']['hypothesisAuthority'],
            $data['core']['iconPath'],
            $data['loggedOut']['loginPath']
        );

        $this->assertSame($data['core']['usernameUrl'], $loaderLoggedOut['usernameUrl']);
        $this->assertSame($data['core']['hypothesisApiUrl'], $loaderLoggedOut['hypothesisApiUrl']);
        $this->assertSame($data['core']['hypothesisAuthority'], $loaderLoggedOut['hypothesisAuthority']);
        $this->assertSame($data['core']['iconPath'], $loaderLoggedOut['iconPath']);
        $this->assertSame($data['loggedOut']['loginPath'], $loaderLoggedOut['loginPath']);

        $this->assertSameWithoutOrder(array_merge($data['core'], $data['loggedOut']), $loaderLoggedOut->toArray());
    }

    public function viewModelProvider() : array
    {
        return [
            'logged-out' => [
                HypothesisLoader::loggedOut('https://usernameUrl', 'https://hypothesisApiUrl', 'hypothesisAuthority', 'https://iconPath', 'loginPath'),
            ],

            'logged-in' => [
                HypothesisLoader::loggedIn('https://usernameUrl', 'https://hypothesisApiUrl', 'hypothesisAuthority', 'https://iconPath', 'profilePath', 'logoutPath', 'grantToken'),
            ],

        ];
    }

    protected function expectedTemplate() : string
    {
        return 'resources/templates/hypothesis-loader.mustache';
    }
}
