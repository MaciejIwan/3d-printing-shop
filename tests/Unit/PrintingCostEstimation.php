<?php

declare(strict_types=1);

namespace Tests\Unit;

use PHPSTL\Handler\VolumeHandler;
use PHPSTL\Reader\STLReader;
use PHPUnit\Framework\TestCase;

require __DIR__ . '/../../configs/printingConst.php';

class PrintingCostEstimation extends TestCase
{
    /** @test */
    public function testName()
    {
        $reader = STLReader::forFile(__DIR__ . '/stls/tip_holder.stl');
        $reader->setHandler(new VolumeHandler());

        $vol = $reader->readModel();
        $grams = $vol / 1000;
        $actualCost = $grams * FILAMENT_PRICE_PER_GRAM;

        $realCost = 6.5;

        $this->assertTrue($actualCost * MARGIN > 2 * $realCost);
    }

}
