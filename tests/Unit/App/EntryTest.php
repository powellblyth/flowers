<?php

namespace Tests\Unit\App;

use App\Models\Entry;
use Tests\TestCase;

class EntryTest extends TestCase
{
    public function providergetPriceType()
    {
        return [
            [true, \App\Models\Category::PRICE_LATE_PRICE],
            [false, \App\Models\Category::PRICE_EARLY_PRICE],
        ];
    }

    /**
     * A basic test example.
     * @dataProvider providergetPriceType
     * @param $isLate
     * @param $expected
     * @return void
     */
    public function testgetPriceType($isLate, $expected)
    {
        $this->sut = $this->getMockBuilder(Entry::class)->setMethods(['isLate'])->getMock();
        $this->sut->expects($this->once())->method('isLate')->will($this->returnValue($isLate));

        $this->assertSame($expected, $this->sut->getPriceType());
    }

    public function providergetPlacementName()
    {
        return [
            [1, 'First Place'],
            ['Fish', 'Fish'],
            ['1', 'First Place'],
            ['2', 'Second Place'],
            ['3', 'Third Place'],
            ['commended', 'Commended'],
            ['', '']
        ];
    }

    /**
     * A basic test example.
     * @dataProvider providergetPlacementName
     * @param $placement
     * @param $expected
     * @return void
     */
    public function testgetgetPlacementName($placement, $expected)
    {
        $this->sut               = new Entry();
        $this->sut->winningplace = $placement;

        $this->assertSame($expected, $this->sut->getPlacementName());
        $this->assertSame($expected, $this->sut->winning_label);
    }

    public function providerhasWon()
    {
        return [
            [1, true],
            ['fish', true],
            ['', false],
            ['    ', false],
            ['commended', true],
            ['-1', true],
        ];
    }

    /**
     * A basic test example.
     * @dataProvider providerhasWon
     * @return void
     */
    public function testhasWon($id, $expected)
    {
        $this->sut               = new Entry();
        $this->sut->winningplace = $id;

        $this->assertSame($expected, $this->sut->hasWon());
    }
}
