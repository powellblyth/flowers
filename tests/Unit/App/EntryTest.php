<?php

namespace Tests\Unit\App;

use App\Models\Entry;
use Tests\TestCase;

class EntryTest extends TestCase
{

//    public function providerGetAddress() {
//        return [
//            ['first', 'second', 'town', 'postcode', 'first, second, town postcode'],
//            ['first', '', 'town', 'postcode', 'first, town postcode'],
//            ['', 'second', 'town', 'postcode', 'second, town postcode'],
//            ['first', 'second', '', 'postcode', 'first, second postcode'],
//            ['', '', '', 'postcode', 'postcode']
//        ];
//    }
//
//    /**
//     * A basic test example.
//     * @dataProvider providerGetAddress
//     * @return void
//     */
//    public function testgetAddress($first, $second, $town, $postcode, $expected) {
//        $this->sut = new Entrant();
//        $this->sut->address = $first;
//        $this->sut->address2 = $second;
//        $this->sut->addresstown = $town;
//        $this->sut->postcode = $postcode;
//
//        $this->assertSame($expected, $this->sut->getAddress());
//    }

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
