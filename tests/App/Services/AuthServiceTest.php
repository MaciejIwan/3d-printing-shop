<?php

namespace App\Services;

use App\Exceptions\ValidationException;
use App\Repository\UserRepository;
use PHPUnit\Framework\TestCase;
use ReflectionClass;


class AuthServiceTest extends TestCase
{
////    private $container;
//    protected function setUp(): void
//    {
//        parent::setUp();
////        $app = require(__DIR__ . '/../../../bootstrap.php');
////        $this->container = $app->getContainer();
//    }

    /** @test */
    public function it_should_throw_ValidationException_when_validateRegisterData_with_taken_email()
    {
        //given
        $new_user_Data = [
            'name' => 'maciej',
            'email' => 'mojkmac@gmail.com',
            'password' => '1234pass',
            'confirmPassword' => '1234pass'
        ];
        $repositoryMock = $this
            ->getMockBuilder(UserRepository::class)
            ->onlyMethods(['isEmailTaken'])
            ->disableOriginalConstructor()
            ->getMock();
        $repositoryMock->expects($this->any())
            ->method('isEmailTaken')
            ->willReturn(true);
        $object = new UserRegisterService($repositoryMock);
        $reflector = new ReflectionClass(UserRegisterService::class);
        $method = $reflector->getMethod('validateRegisterData');
        $method->setAccessible(true);

        //when
        $this->expectException(ValidationException::class);
        $method->invokeArgs($object, array($new_user_Data));

        //then
        $this->expectException(ValidationException::class);
    }

    /** @test */
    public function it_should_throw_ValidationException_password_to_short_when_validateRegisterData()
    {
        //given
        $new_user_Data = [
            'name' => 'maciej',
            'email' => 'mojkmac@gmail.com',
            'password' => '1234pass',
            'confirmPassword' => '1234'
        ];
        $repositoryMock = $this
            ->getMockBuilder(UserRepository::class)
            ->onlyMethods(['isEmailTaken'])
            ->disableOriginalConstructor()
            ->getMock();
        $repositoryMock->expects($this->any())
            ->method('isEmailTaken')
            ->willReturn(false);

        $object = new UserRegisterService($repositoryMock);
        $reflector = new ReflectionClass(UserRegisterService::class);
        $method = $reflector->getMethod('validateRegisterData');
        $method->setAccessible(true);

        //when then
        $this->expectException(ValidationException::class);
//        $this->expectExceptionMessage(ValidationException::$PASSWORD_LENGTH);
        $method->invokeArgs($object, array($new_user_Data));

    }

}
