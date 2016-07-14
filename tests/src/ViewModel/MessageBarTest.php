<?php

namespace tests\eLife\Patterns\ViewModel;

use eLife\Patterns\ViewModel\MessageBar;

final class MessageBarTest extends ViewModelTest
{
    /**
     * @test
     */
    public function it_has_data()
    {
        $data = [
            'message' => 'testing message bar',
        ];
        $messageBar = new MessageBar($data['message']);

        $this->assertSame($data['message'], $messageBar['message']);
        $this->assertSame($data, $messageBar->toArray());
    }

    public function viewModelProvider() : array
    {
        return [
           [new MessageBar('testing message bar')],
        ];
    }

    protected function expectedTemplate() : string
    {
        return '/elife/patterns/templates/message-bar.mustache';
    }
}
