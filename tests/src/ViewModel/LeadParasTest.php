<?php

namespace tests\eLife\Patterns\ViewModel;

use eLife\Patterns\ViewModel\LeadPara;
use eLife\Patterns\ViewModel\LeadParas;
use InvalidArgumentException;
use TypeError;

final class LeadParasTest extends ViewModelTest
{
    /**
     * @test
     */
    public function it_has_data()
    {
        $data = [
            'paras' => [
                [
                    'text' => 'testing first paragraph text',
                ],
                [
                    'text' => 'testing second paragraph text',
                ],
            ],
        ];

        $paras = new LeadParas([
            new LeadPara($data['paras'][0]['text']),
            new LeadPara($data['paras'][1]['text']),
        ]);

        $this->assertSame(
            $data['paras'][0]['text'],
            $paras['paras'][0]['text'],
            'First lead paragraph contains paragraph text'
        );
        $this->assertSame(
            $data['paras'][1]['text'],
            $paras['paras'][1]['text'],
            'Second lead paragraph contains paragraph text'
        );
        $this->assertSame($paras->toArray(), $data);
    }

    /**
     * @test
     */
    public function it_cannot_have_no_paragraphs()
    {
        $this->expectException(InvalidArgumentException::class);

        new LeadParas([]);
    }

    /**
     * @test
     */
    public function it_cannot_have_input_other_than_array()
    {
        $this->expectException(TypeError::class);

        new LeadParas('not a valid construction');
    }

    public function viewModelProvider() : array
    {
        return [
            [
                new LeadParas([
                    new LeadPara('Text testing first'),
                    new LeadPara('Text testing second'),
                ]),
            ],
            [
                new LeadParas([
                    new LeadPara('Text testing first'),
                    new LeadPara('Text testing second'),
                    new LeadPara('Text testing third'),
                    new LeadPara('Text testing fourth'),
                    new LeadPara('Text testing fifth'),
                ]),
            ],
        ];
    }

    protected function expectedTemplate() : string
    {
        return 'resources/templates/lead-paras.mustache';
    }
}
