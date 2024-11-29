<?php

namespace tests\eLife\Patterns\ViewModel;

use eLife\Patterns\ViewModel\Math;
use InvalidArgumentException;

final class MathTest extends ViewModelTest
{
    /**
     * @test
     */
    public function it_has_data()
    {
        $data = [
            'math' => '<math><mrow><mi>a</mi><mo>+</mo><mi>b</mi></mrow></math>',
            'id' => 'id',
            'label' => 'label',
        ];

        $math = new Math($data['math'], $data['id'], $data['label']);

        $this->assertSame($data['math'], $math['math']);
        $this->assertSame($data['id'], $math['id']);
        $this->assertSame($data['label'], $math['label']);
        $this->assertSame($data, $math->toArray());
    }

    /**
     * @test
     */
    public function it_must_have_math_ml()
    {
        $this->expectException(InvalidArgumentException::class);

        new Math('foo');
    }

    public function viewModelProvider(): array
    {
        return [
            'minimum' => [new Math('<math><mrow><mi>a</mi><mo>+</mo><mi>b</mi></mrow></math>')],
            'complete' => [new Math('<math><mrow><mi>a</mi><mo>+</mo><mi>b</mi></mrow></math>', 'id', 'label')],
        ];
    }

    protected function expectedTemplate(): string
    {
        return 'resources/templates/math.mustache';
    }
}
