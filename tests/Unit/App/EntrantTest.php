<?php
namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use \App\Entrant;

class EntrantTest extends TestCase {

    public function providerGetAddress() {
        return [
            ['first', 'second', 'town', 'postcode', 'first, second, town postcode'],
            ['first', '', 'town', 'postcode', 'first, town postcode'],
            ['', 'second', 'town', 'postcode', 'second, town postcode'],
            ['first', 'second', '', 'postcode', 'first, second postcode'],
            ['', '', '', 'postcode', 'postcode']
        ];
    }

    /**
     * A basic test example.
     * @dataProvider providerGetAddress
     * @return void
     */
    public function testgetAddress($first, $second, $town, $postcode, $expected) {
        $this->sut = new Entrant();
        $this->sut->address = $first;
        $this->sut->address2 = $second;
        $this->sut->addresstown = $town;
        $this->sut->postcode = $postcode;

        $this->assertSame($expected, $this->sut->getAddress());
    }

    public function providergetName() {
        return [
            ['first second', 'first', 'second', null],
            ['first second', 'first', 'second', false],
            ['f second', 'first', 'second', true],
            ['first', 'first', '', null],
            ['second', '', 'second', null],
            ['first second', 'first', 'second ', null],
            ['', '', '']
        ];
    }

    /**
     * A basic test example.
     * @dataProvider providergetName
     * @return void
     */
    public function testgetName(string $expected, string $first, string $second, ?bool $printable=null) {
        $this->sut = new Entrant();
        $this->sut->firstname = $first;
        $this->sut->familyname = $second;

        $this->assertSame($expected, $this->sut->getName($printable));
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
        $this->sut = new Entrant();
        $this->sut->firstname = $first;
        $this->sut->familyname = $second;

        $this->assertSame($expected, $this->sut->getPrintableName());
    }
    public function providergetUrl() {
        return [
            [1, '/entrants/1'],
            ['fish',  '/entrants/0'],
            ['-1', '/entrants/-1'],
        ];
    }

    /**
     * A basic test example.
     * @dataProvider providergetUrl
     * @return void
     */
    public function testgetUrl($id, $expected) {
        $this->sut = new Entrant();
        $this->sut->id = $id;

        $this->assertSame($expected, $this->sut->getUrl());
    }
}
//$this->getMockBuilder(SampleClass::class)->setMethods(null)->setConstructorArgs([4, 8, 15])->getMock()