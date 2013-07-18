<?php

namespace Satooshi\Component\Environment;

/**
 * @covers Satooshi\Component\Environment\Clock
 *
 * @author Kitamura Satoshi <with.no.parachute@gmail.com>
 */
class ClockTest extends \PHPUnit_Framework_TestCase
{
    protected function setUp()
    {
        $this->iniSet('date.timezone', 'UTC');

        $_SERVER['REQUEST_TIME'] = 1374127307; // 2013-07-18 06:01:47 UTC
    }

    // createRequestDateTime()

    /**
     * @test
     */
    public function shouldCreateRequestDateTimeWithGivenDateTimeIfRequestTimeIsMissing()
    {
        unset($_SERVER['REQUEST_TIME']);

        $actual = Clock::createRequestDateTime();

        $this->assertTrue($actual instanceof \DateTime);
    }

    /**
     * @test
     */
    public function shouldCreateRequestDateTimeWithGivenDateTimeZone()
    {
        $timezone = 'Asia/Tokyo';
        $expected = new \DateTimeZone($timezone);

        $actual = Clock::createRequestDateTime($timezone);

        $this->assertEquals($expected, $actual->getTimezone());
    }

    /**
     * @test
     */
    public function shouldReturnSameRequestDateTimeWithGivenDateTime()
    {
        $timezone = 'UTC';
        $now      = new \DateTime('2013-01-01 00:00:00', new \DateTimeZone($timezone));

        $actual = Clock::createRequestDateTime($timezone, $now);

        $this->assertSame($now, $actual);
    }

    // setDateTimeFormat()

    /**
     * @test
     */
    public function shouldSetDateTimeFormat()
    {
        $expected = 'Y/m/d H.i.s';

        $obj = new Clock();
        $obj->setDateTimeFormat($expected);

        $this->assertEquals($expected, $obj->getDateTimeFormat());
    }

    // getDateTimeFormat()

    /**
     * @test
     */
    public function shouldHaveDateTimeFormat()
    {
        $expected = 'Y-m-d H:i:s';

        $obj = new Clock();

        $this->assertEquals($expected, $obj->getDateTimeFormat());
    }

    // __toString()

    /**
     * @test
     */
    public function shouldConvertToString()
    {
        $obj = new Clock();

        $expected = $obj->getCurrentDateTime()->format('Y-m-d H:i:s');

        $this->assertEquals($expected, "$obj");
    }

    // getCurrentDateTime()

    /**
     * @test
     */
    public function shouldHaveCurrentDateTime()
    {
        $expected = new \DateTime('@' . $_SERVER['REQUEST_TIME']);
        $expected->setTimezone(new \DateTimeZone(ini_get('date.timezone')));

        $obj = new Clock();

        $this->assertEquals($expected, $obj->getCurrentDateTime());
    }

    // getUnixTimestamp()

    /**
     * @test
     */
    public function shouldHaveUnixTimestamp()
    {
        $expected = $_SERVER['REQUEST_TIME'];

        $obj = new Clock();

        $this->assertEquals($expected, $obj->getUnixTimestamp());
    }
}
