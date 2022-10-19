<?php

namespace tests\eLife\Patterns\ViewModel;

use DateTimeImmutable;
use eLife\Patterns\ViewModel\InfoBar;
use Exception;
use InvalidArgumentException;

final class InfoBarTest extends ViewModelTest
{
    /**
     * @test
     *
     * @throws Exception
     */
    public function it_has_data()
    {
        $dateAsString = 'Wednesday, 15-Jan-2020 15:12:24 UTC';
        $date = new DateTimeImmutable($dateAsString);

        $data = [
            'text' => 'text',
            'id' => 'id',
            'type' => InfoBar::TYPE_DISMISSIBLE,
            'dismissible' => [
                'cookieExpires' => $dateAsString,
            ],
        ];

        $infoBar = new InfoBar($data['text'], $data['type'], $data['id'], $date);

        $this->assertSame($data['text'], $infoBar['text']);
        $this->assertSame($data['type'], $infoBar['type']);
        $this->assertSame($dateAsString, $infoBar['dismissible']['cookieExpires']);
        $this->assertSame($data['id'], $infoBar['id']);
        $this->assertSameWithoutOrder($data, $infoBar->toArray());
    }

    /**
     * @test
     */
    public function it_cannot_have_an_invalid_type()
    {
        $this->expectException(InvalidArgumentException::class);

        new InfoBar('text', 'foo');
    }

    /**
     * @test
     */
    public function it_cannot_have_blank_text()
    {
        $this->expectException(InvalidArgumentException::class);

        new InfoBar('', InfoBar::TYPE_INFO);
    }

    /**
     * @test
     */
    public function dismissible_type_must_have_id()
    {
        $this->expectException(InvalidArgumentException::class);

        new InfoBar('text', InfoBar::TYPE_DISMISSIBLE, null, new DateTimeImmutable('2020-01-15'));
    }

    public function viewModelProvider() : array
    {
        return [
            'attention' => [new InfoBar('text', InfoBar::TYPE_ATTENTION)],
            'dismissible' => [new InfoBar('text', InfoBar::TYPE_DISMISSIBLE, 'id', new DateTimeImmutable('2020-01-15'))],
            'info' => [new InfoBar('text', InfoBar::TYPE_INFO)],
            'success' => [new InfoBar('text', InfoBar::TYPE_SUCCESS)],
            'correction' => [new InfoBar('text', InfoBar::TYPE_CORRECTION)],
            'warning' => [new InfoBar('text', InfoBar::TYPE_WARNING)],
            'multiple articles' => [new InfoBar('text', InfoBar::TYPE_MULTIPLE_VERSIONS)],
            'announcement' => [new InfoBar('text', InfoBar::TYPE_ANNOUNCEMENT)],
        ];
    }

    protected function expectedTemplate() : string
    {
        return 'resources/templates/info-bar.mustache';
    }
}
