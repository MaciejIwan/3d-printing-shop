<?php

namespace Unit;

use App\Entity\User;
use PHPUnit\Framework\TestCase;

class UserEntityTest extends TestCase
{
    private User $user;

    protected function setUp(): void
    {
        parent::setUp();
        $container = new Container();
        $this->router = new Router($container);
    }

    /** @test */
    public function it_registers_a_route(): void
    {
        $this->router->register('get', '/users', ['Users', 'index']);

        $expected = [
            'get' => [
                '/users' => ['Users', 'index'],
            ],
        ];

        $this->assertSame($expected, $this->router->routes());
    }
}