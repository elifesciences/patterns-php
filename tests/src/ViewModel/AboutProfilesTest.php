<?php

namespace tests\eLife\Patterns\ViewModel;

use eLife\Patterns\ViewModel\AboutProfile;
use eLife\Patterns\ViewModel\AboutProfiles;
use eLife\Patterns\ViewModel\ListHeading;
use InvalidArgumentException;

final class AboutProfilesTest extends ViewModelTest
{
    /**
     * @test
     */
    public function it_has_data()
    {
        $data = [
            'heading' => [
                'heading' => 'heading',
            ],
            'compact' => true,
            'items' => [
                [
                    'name' => 'name',
                    'role' => 'role',
                    'profile' => 'profile',
                ],
            ],
        ];
        $profile = new AboutProfiles(array_map(function (array $item) {
            return new AboutProfile($item['name'], $item['role'], null, false, $item['profile']);
        }, $data['items']), new ListHeading($data['heading']['heading']), $data['compact']);

        $this->assertSame($data['heading'], $profile['heading']->toArray());
        $this->assertSame($data['compact'], $profile['compact']);
        $this->assertSameWithoutOrder($data['items'], $profile['items']);
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

    public function viewModelProvider(): array
    {
        return [
            'minimum' => [
                new AboutProfiles([new AboutProfile('name')]),
            ],
            'complete' => [
                new AboutProfiles([new AboutProfile('name')], new ListHeading('heading'), true),
            ],
        ];
    }

    protected function expectedTemplate(): string
    {
        return 'resources/templates/about-profiles.mustache';
    }
}
