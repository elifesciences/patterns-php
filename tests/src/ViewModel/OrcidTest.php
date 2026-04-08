<?php

namespace tests\eLife\Patterns\ViewModel;

use eLife\Patterns\ViewModel\Orcid;
use InvalidArgumentException;
use PHPUnit\Framework\Attributes\Test;

final class OrcidTest extends ViewModelTest
{
    #[Test]
    public function it_has_data()
    {
        $data = [
            'id' => '0000-0002-1825-0097',
        ];

        $orcid = new Orcid($data['id']);

        $this->assertSame($data['id'], $data['id']);
        $this->assertSame($data, $orcid->toArray());
    }

    #[Test]
    public function it_must_have_a_valid_id()
    {
        $this->expectException(InvalidArgumentException::class);

        new Orcid('foo');
    }

    public static function viewModelProvider() : array
    {
        return [
            [new Orcid('0000-0002-1825-0097')],
        ];
    }

    protected function expectedTemplate() : string
    {
        return 'resources/templates/orcid.mustache';
    }
}
