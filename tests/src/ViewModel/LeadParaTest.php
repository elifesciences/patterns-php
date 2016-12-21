<?php

namespace tests\eLife\Patterns\ViewModel;

use eLife\Patterns\ViewModel\LeadPara;
use InvalidArgumentException;

final class LeadParaTest extends ViewModelTest
{
    /**
     * @test
     */
    public function it_has_data()
    {
        $data = [
            'text' => 'testing paragraph text',
            'id' => 'testId',
        ];

        $lead = new LeadPara($data['text'], $data['id']);

        $this->assertSame($data['text'], $lead['text'], 'Lead paragraph contains paragraph text');
        $this->assertSame($data['id'], $lead['id'], 'testId');
        $this->assertSame($lead->toArray(), $data);
    }

    /**
     * @test
     */
    public function it_cannot_have_a_blank_paragraph()
    {
        $this->expectException(InvalidArgumentException::class);

        new LeadPara('');
    }

    public function viewModelProvider() : array
    {
        return [
            [
                new LeadPara('Text testing'),
                new LeadPara('Text testing', 'idForHTMLElement'),
            ],
        ];
    }

    protected function expectedTemplate() : string
    {
        return '/elife/patterns/templates/lead-para.mustache';
    }
}
