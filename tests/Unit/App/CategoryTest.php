<?php

namespace Tests\Unit\App;

use App\Models\Category;
use Tests\TestCase;

class CategoryTest extends TestCase
{

    public function providerincrementNumberWithText(): array
    {
        return [
            // Note that we expect this to be capitalised correctly
            ['101a', '100a', 1],
            ['99a', '100a', -1],
            ['44banana56', '43banana56', 1],
            ['42banana56', '43banana56', -1],
            // Note this is an anomaly
            ['42banana42', '43banana43', -1],
        ];
    }

    /**
     * A basic test example.
     * @dataProvider providerincrementNumberWithText
     * @return void
     */
    public function testincrementNumberWithText($expected, $number, $amount)
    {
        $sut = new Category();
        $sut->number = $number;
        $sut->incrementNumberWithText($amount);
        $this->assertSame($expected, $sut->number);
    }

}
