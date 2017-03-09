<?php

namespace tests\eLife\Patterns\ViewModel;

use eLife\Patterns\ViewModel\Code;
use InvalidArgumentException;

final class CodeTest extends ViewModelTest
{
    /**
     * @test
     */
    public function it_has_data()
    {
        $data = [
            'code' => '<p>code</p>',
        ];
        $code = new Code($data['code']);

        $this->assertSame($code['code'], $code['code']);
        $this->assertSame($data, $code->toArray());
    }

    public function it_must_have_code()
    {
        $this->expectException(InvalidArgumentException::class);

        new Code('');
    }

    public function viewModelProvider() : array
    {
        return [
            [new Code('<p>code</p>')],
        ];
    }

    protected function expectedTemplate() : string
    {
        return '/elife/patterns/templates/code.mustache';
    }
}
