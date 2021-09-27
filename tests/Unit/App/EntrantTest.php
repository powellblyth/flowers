<?php

namespace Tests\Unit\App;

use App\Models\Entrant;
use Tests\TestCase;

class EntrantTest extends TestCase
{

    public function providergetName()
    {
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
    public function testgetName(string $expected, string $first, string $second, ?bool $printable = null)
    {
        $sut = new Entrant();
        $sut->firstname = $first;
        $sut->familyname = $second;

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
     * @param $first
     * @param $second
     * @param $expected
     * @return void
     */
    public function testgetPrintableName($first, $second, $expected)
    {
        $sut = new Entrant();
        $sut->firstname = $first;
        $sut->familyname = $second;

        $this->assertSame($expected, $sut->printable_name);
        $this->assertSame($expected, $sut->printableName);
        $this->assertSame($expected, $sut->getPrintableNameAttribute());
    }

    public function providergetEntrantNumber(): array
    {
        return [
            ['E-0001', 1],
            ['E-0032', 32],
        ];
    }

    /**
     * A basic test example.
     * @dataProvider providergetEntrantNumber
     * @param $expected
     * @param $id
     * @return void
     */
    public function testgetEntrantNumber($expected, $id)
    {
        $sut = new Entrant();
        $sut->id = $id;

        $this->assertSame($expected, $sut->getEntrantNumber());
    }

    public function providerDescribeAge():array{
        return [
            ['',null],
            ['',88],
            ['',18],
            ['12 years',12],
        ];
    }
    /**
     * @param $expected
     * @param $age
     * @dataProvider providerDescribeAge
     */
    public function testDescribeAge($expected, $age)
    {
        $sut = new Entrant(['age'=>$age]);
        $this->assertSame($expected, $sut->getAgeDescriptionAttribute());
        $this->assertSame($expected, $sut->age_description);
    }

}
//$this->getMockBuilder(SampleClass::class)->setMethods(null)->setConstructorArgs([4, 8, 15])->getMock()
