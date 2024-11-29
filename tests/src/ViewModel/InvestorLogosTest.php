<?php

namespace tests\eLife\Patterns\ViewModel;

use eLife\Patterns\ViewModel\Image;
use eLife\Patterns\ViewModel\InvestorLogos;
use eLife\Patterns\ViewModel\Picture;

final class InvestorLogosTest extends ViewModelTest
{
    /**
     * @test
     */
    public function it_has_data()
    {
        $data = [
            'logos' => [
                [
                    'fallback' => [
                        'altText' => 'alt',
                        'defaultPath' => 'foo.jpg',
                    ],
                ],
            ],
        ];

        $investorLogos = new InvestorLogos(...array_map(function (array $logo) {
            return new Picture([], new Image($logo['fallback']['defaultPath'], [], $logo['fallback']['altText']));
        }, $data['logos']));

        $this->assertSameWithoutOrder($data['logos'], $investorLogos['logos']);
        $this->assertSame($data, $investorLogos->toArray());
    }

    public function viewModelProvider(): array
    {
        return [
            [
                new InvestorLogos(new Picture([], new Image('foo.jpg'))),
            ],
        ];
    }

    protected function expectedTemplate(): string
    {
        return 'resources/templates/investor-logos.mustache';
    }
}
