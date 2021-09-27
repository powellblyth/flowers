<?php

namespace Tests\Unit\App;

use App\Models\User;
use Tests\TestCase;

class UserTest extends TestCase
{

    public function providerGetAddress()
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
        $sut->address     = $first;
        $sut->address2    = $second;
        $sut->addresstown = $town;
        $sut->postcode    = $postcode;

        $this->assertSame($expected, $sut->getAddress());
    }

    public function providergetName()
    {
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
     * @param string $expected
     * @param string $first
     * @param string $second
     * @param bool|null $printable
     * @return void
     */
    public function testgetName(string $expected, string $first, string $second, ?bool $printable = null)
    {
        $sut            = new User();
        $sut->firstname = $first;
        $sut->lastname  = $second;

        $this->assertSame($expected, $sut->getName($printable));
    }

    public function providergetPrintableName()
    {
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
    public function testgetPrintableName($first, $second, $expected)
    {
        $sut            = new User();
        $sut->firstname = $first;
        $sut->lastname  = $second;

        $this->assertSame($expected, $sut->printable_name);
        $this->assertSame($expected, $sut->printableName);
        $this->assertSame($expected, $sut->getPrintableNameAttribute());
    }


}
//$this->getMockBuilder(SampleClass::class)->setMethods(null)->setConstructorArgs([4, 8, 15])->getMock()
