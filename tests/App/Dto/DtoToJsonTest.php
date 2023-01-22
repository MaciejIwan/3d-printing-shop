<?php

namespace Tests\App\Dto;

use App\Dto\OrderUpdateDto;
use App\Entity\Order;
use App\Enum\OrderStatus;
use DateTime;
use PHPUnit\Framework\TestCase;

class DtoToJsonTest extends TestCase
{

    /** @test */
    public function it_should_convert_dto_to_json()
    {
        //given
        $order = new Order();
        $order->setId(1);
        $order->setName("test name");
        $order->setStatus(OrderStatus::UNPAID);

        $date = new DateTime();
        $order->setUpdatedAt($date);
        $order->setCreatedAt($date);

        $categoryDto = OrderUpdateDto::fromEntity($order);

        //when
        $actual = json_encode($categoryDto);
        $expected = '{"id":1,"name":"test name","status":"New",';

        //then
        $this->assertStringContainsString($expected, $actual);

    }


}
