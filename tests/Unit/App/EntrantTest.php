<?php
namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use \App\Entrant;

class EntrantTest extends TestCase {

    public function providergetName() {
        return [
            ['First Second', 'first', 'second', null],
            ['First Second', 'first', 'second', false],
            ['f second', 'first', 'second', true],
            ['First', 'first', '', null],
            ['Second', '', 'second', null],
            ['First Second', 'first', 'second ', null],
            ['', '', '']
        ];
    }

    /**
     * A basic test example.
     * @dataProvider providergetName
     * @return void
     */
    public function testgetName(string $expected, string $first, string $second, ?bool $printable=null) {
        $sut = new Entrant();
        $sut->firstname = $first;
        $sut->familyname = $second;

        $this->assertSame($expected, $sut->getName($printable));
    }

    public function providergetPrintableName() {
        return [
            ['first', 'second', 'f second'],
            ['first', '', 'f'],
            ['', 'second', 'second'],
            ['first', 'second ', 'f second'],
            ['', '', '']
        ];
    }

    /**
     * A basic test example.
     * @dataProvider providergetPrintableName
     * @return void
     */
    public function testgetPrintableName($first, $second, $expected) {
        $sut = new Entrant();
        $sut->firstname = $first;
        $sut->familyname = $second;

        $this->assertSame($expected, $sut->getPrintableName());
    }
    public function providergetUrl() {
        return [
            ['/entrants/1', 1],
            ['/entrants/0', 'fish'],
            ['/entrants/-1', '-1'],
        ];
    }

    /**
     * A basic test example.
     * @dataProvider providergetUrl
     * @return void
     */
    public function testgetUrl($expected, $id) {
        $sut = new Entrant();
        $sut->id = $id;

        $this->assertNotFalse(strpos($sut->getUrl(), $expected));
    }

    public function providergetEntrantNumber() {
        return [
            ['E-0001', 1],
            ['E-0032',  32],
        ];
    }

    /**
     * A basic test example.
     * @dataProvider providergetEntrantNumber
     * @return void
     */
    public function testgetEntrantNumber($expected, $id) {
        $sut = new Entrant();
        $sut->id = $id;

        $this->assertSame($expected, $sut->getEntrantNumber());
    }


}
//$this->getMockBuilder(SampleClass::class)->setMethods(null)->setConstructorArgs([4, 8, 15])->getMock()