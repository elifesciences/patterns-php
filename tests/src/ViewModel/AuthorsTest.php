<?php

namespace tests\eLife\Patterns\ViewModel;

use eLife\Patterns\ViewModel\Author;
use eLife\Patterns\ViewModel\Authors;
use eLife\Patterns\ViewModel\Button;
use eLife\Patterns\ViewModel\ContentHeader;
use eLife\Patterns\ViewModel\ContentHeaderImage;
use eLife\Patterns\ViewModel\FormLabel;
use eLife\Patterns\ViewModel\Image;
use eLife\Patterns\ViewModel\Institution;
use eLife\Patterns\ViewModel\Link;
use eLife\Patterns\ViewModel\Meta;
use eLife\Patterns\ViewModel\Picture;
use eLife\Patterns\ViewModel\Profile;
use eLife\Patterns\ViewModel\Select;
use eLife\Patterns\ViewModel\SelectNav;
use eLife\Patterns\ViewModel\SelectOption;
use eLife\Patterns\ViewModel\SocialMediaSharers;
use InvalidArgumentException;

final class AuthorsTest extends ViewModelTest
{
    /**
     * @test
     */
    public function it_has_data()
    {
        $data = [
            'list' => [
                [
                    'name' => 'author',
                    'url' => false,
                    'isCorresponding' => true,
                ],
            ],
            'institutions' => [
                'list' => [
                    [
                        'name' => 'institution',
                    ],
                ],
            ],
        ];

        $authors = new Authors(
            array_map(function (array $item) {
                return Author::asText($item['name'], $item['isCorresponding'] ?? false);
            }, $data['list']),
            array_map(function (array $item) {
                return new Institution($item['name']);
            }, $data['institutions']['list'])
        );

        $this->assertSameWithoutOrder($data['list'], $authors['list']);
        $this->assertSameWithoutOrder($data['institutions'], $authors['institutions']);
        $this->assertSameWithoutOrder($data, $authors->toArray());
    }

    /**
     * @test
     */
    public function it_must_have_authors()
    {
        $this->expectException(InvalidArgumentException::class);

        new Authors([]);
    }

    /**
     * @test
     */
    public function authors_must_be_authors()
    {
        $this->expectException(InvalidArgumentException::class);

        new Authors(['foo']);
    }

    /**
     * @test
     */
    public function institutions_must_be_institutions()
    {
        $this->expectException(InvalidArgumentException::class);

        new Authors([Author::asText('author')], ['foo']);
    }

    public function viewModelProvider(): array
    {
        return [
            'minimum' => [new Authors([Author::asText('author')])],
            'complete' => [
                new Authors([Author::asText('author')], [new Institution('institution')]),
            ],
        ];
    }

    protected function expectedTemplate(): string
    {
        return 'resources/templates/authors.mustache';
    }
}
