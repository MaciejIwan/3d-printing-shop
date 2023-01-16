<?php

namespace Tests\Unit;

use PHPSTL\Handler\VolumeHandler;
use PHPSTL\Reader\STLReader;
use PHPUnit\Framework\TestCase;

define("DELTA", 0.00001);

class StlReaderTests extends TestCase
{

    /** @test */
    public function it_should_calculate_volume()
    {
        $reader = STLReader::forFile(__DIR__ . '/stls/text.stl');
        $reader->setHandler(new VolumeHandler());

        $expected = 61.023744373000547;
        $actual = $reader->readModel();

        $this->assertEqualsWithDelta($expected, $actual, 0.001);
    }

    /** @test */
    public function it_should_calculate_volume_realStl()
    {
        $reader = STLReader::forFile(__DIR__ . '/stls/sd_card.stl');
        $reader->setHandler(new VolumeHandler());

        $expected = 5702.6245429008;
        $actual = $reader->readModel();

        $this->assertEqualsWithDelta($expected, $actual, 0.001);
    }

    /** @test */
    public function it_should_calculate_volume_gopro()
    {
        $reader = STLReader::forFile(__DIR__ . '/stls/gopro_mount.stl');
        $reader->setHandler(new VolumeHandler());

        $expected = 6645.6946460775;
        $actual = $reader->readModel();


        $this->assertEqualsWithDelta($expected, $actual, 0.001);
    }

    /** @test */
    public function it_should_calculate_volume_tip_holder()
    {
        $reader = STLReader::forFile(__DIR__ . '/stls/tip_holder.stl');
        $reader->setHandler(new VolumeHandler());

        $expected = 64797.796720668;
        $actual = $reader->readModel();

        $this->assertEqualsWithDelta($expected, $actual, 0.001);
    }

}
