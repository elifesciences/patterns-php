<?php

namespace tests\eLife\Patterns\ViewModel;

use eLife\Patterns\ViewModel\MessageBar;
use PHPUnit\Framework\Attributes\Test;

final class MessageBarTest extends ViewModelTest
{
    #[Test]
    public function it_has_data()
    {
        $data = [
            'message' => 'testing message bar',
        ];
        $messageBar = new MessageBar($data['message']);

        $this->assertSame($data['message'], $messageBar['message']);
        $this->assertSame($data, $messageBar->toArray());
    }

    public static function viewModelProvider() : array
    {
        return [
            [new MessageBar('testing message bar')],
        ];
    }

    protected function expectedTemplate() : string
    {
        return 'resources/templates/message-bar.mustache';
    }
}
