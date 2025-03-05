<?php declare(strict_types=1);
require_once "./utils/class/restaurant.php";
require_once "./utils/BD/connexionBD.php";
require_once "./utils/BD/requettes/userManagement.php";

use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\UsesClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(Invoice::class)]
#[UsesClass(Money::class)]
final class UserTest extends TestCase{
    public function testuser(){
        $user->deleteUser("test");
        $user->deleteUser("testA");

        $this->assertFalse($user->usernameExist("test"));
        $this->assertFalse($user->usernameExist("testA"));

        $this->assertTrue($user->createUser("test","1234",false));
        $this->assertTrue($user->createUser("testA","1234",true));

        $this->assertTrue($user->usernameExist("test"));
        $this->assertTrue($user->usernameExist("testA"));

        $user->userConnecter("test");
        $this->assertEquals($_SESSION["connecte"]["username"], "test");

        $this->assertTrue($user->canLogin("test", "1234"));
        $this->assertTrue($user->canLogin("testA", "1234"));
        $this->assertFalse($user->canLogin("test", "12345"));
        $this->assertFalse($user->canLogin("testA", "12345"));

        $this->assertTrue($user->updateUser("test","testB","1234", false));

        $this->assertFalse($user->isAdmin("test"));
        $this->assertTrue($user->isAdmin("testA"));

        $this->assertFalse($user->deleteUser("AAAAAA"));
        $this->assertTrue($user->deleteUser("test"));
        $this->assertTrue($user->deleteUser("testA"));
    }
}