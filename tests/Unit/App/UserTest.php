<?php

namespace Tests\Unit\App;

use App\Models\User;
use Tests\TestCase;

class UserTest extends TestCase
{

    public function providerGetAddress(): array
    {
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
    public function testgetAddress($first, $second, $town, $postcode, $expected)
    {
        $sut              = new User();
        $sut->address_1     = $first;
        $sut->address_2    = $second;
        $sut->address_town = $town;
        $sut->postcode    = $postcode;

        $this->assertSame($expected, $sut->address);
    }

    public function providergetName(): array
    {
        return [
            ['First Second', 'first', 'second', null],
            ['First Second', 'first', 'second', false],
            ['First', 'first', '', null],
            ['Second', '', 'second', null],
            ['First Second', 'first', 'second ', null],
            ['', '', '']
        ];
    }

    /**
     * A basic test example.
     * @dataProvider providergetName
     * @param string $expected
     * @param string $first
     * @param string $second
     * @param bool|null $printable
     * @return void
     */
    public function testgetName(string $expected, string $first, string $second, ?bool $printable = null)
    {
        $sut            = new User();
        $sut->first_name = $first;
        $sut->last_name  = $second;

        $this->assertSame($expected, $sut->full_name);
    }

    public function providergetPrintableName(): array
    {
        return [
            ['first', 'second', 'F Second'],
            ['first', '', 'F'],
            ['', 'second', 'Second'],
            ['first', 'second ', 'F Second'],
            ['', '', '']
        ];
    }

    /**
     * A basic test example.
     * @dataProvider providergetPrintableName
     * @return void
     */
    public function testgetPrintableName($first, $second, $expected)
    {
        $sut            = new User();
        $sut->first_name = $first;
        $sut->last_name  = $second;

        $this->assertSame($expected, $sut->printable_name);
        $this->assertSame($expected, $sut->printableName);
    }


}
//$this->getMockBuilder(SampleClass::class)->setMethods(null)->setConstructorArgs([4, 8, 15])->getMock()
