<?php

namespace tests\eLife\Patterns\ViewModel;

use eLife\Patterns\ViewModel\AboutProfile;
use eLife\Patterns\ViewModel\Image;
use eLife\Patterns\ViewModel\Picture;
use eLife\Patterns\ViewModel\PictureSource;
use InvalidArgumentException;

final class AboutProfileTest extends ViewModelTest
{
    /**
     * @test
     */
    public function it_has_data()
    {
        $data = [
            'name' => 'name',
            'role' => 'role',
            'image' => [
                'fallback' => [
                    'altText' => 'the alt text',
                    'defaultPath' => '/default/path',
                    'srcset' => '/path/to/image/500/wide 2x',
                ],
                'sources' => [
                    [
                        'srcset' => '/path/to/svg',
                    ],
                    [
                        'srcset' => '/path/to/another/svg',
                        'media' => 'media statement',
                    ],
                ],
            ],
            'profile' => 'profile',
        ];
        $profile = new AboutProfile(
            $data['name'],
            $data['role'],
            new Picture(
                [
                    new PictureSource($data['image']['sources'][0]['srcset']),
                    new PictureSource($data['image']['sources'][1]['srcset'], null, null, $data['image']['sources'][1]['media']),
                ],
                new Image(
                    $data['image']['fallback']['defaultPath'],
                    '/path/to/image/500/wide',
                    $data['image']['fallback']['altText']
                )
            ),
            'profile'
        );

        $this->assertSame($data['name'], $profile['name']);
        $this->assertSame($data['role'], $profile['role']);
        $this->assertSame($data['image'], $profile['image']->toArray());
        $this->assertSame($data['profile'], $profile['profile']);
        $this->assertSame($data, $profile->toArray());
    }

    /**
     * @test
     */
    public function it_must_have_a_name()
    {
        $this->expectException(InvalidArgumentException::class);

        new AboutProfile('');
    }

    public function viewModelProvider() : array
    {
        return [
            'minimum' => [
                new AboutProfile('name'),
            ],
        ];
    }

    protected function expectedTemplate() : string
    {
        return 'resources/templates/about-profile.mustache';
    }
}
