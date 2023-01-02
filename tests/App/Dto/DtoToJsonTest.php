<?php

namespace App\Services;

use App\Dto\CategoryUpdateDto;
use App\Entity\Category;
use PHPUnit\Framework\TestCase;

class DtoToJsonTest extends TestCase
{

    /** @test */
    public function it_should_convert_dto_to_json()
    {
        //given
        $category = new Category();
        $category->setName("test name");
        $category->setId(1);
        $categoryDto = CategoryUpdateDto::fromEntity($category);

        //when
        $actual = json_encode($categoryDto);
        $expected = '{"id":1,"name":"test name"}';

        //then
        $this->assertEquals($expected, $actual);

    }


}
