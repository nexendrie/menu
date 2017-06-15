<?php
declare(strict_types=1);

namespace Nexendrie\Menu;

use Tester\Assert,
    Nette\Security\User;

require __DIR__ . "/../../bootstrap.php";

class ConditionUserInRoleTest extends \Tester\TestCase {
  use \Testbench\TCompiledContainer;
  
  /** @var ConditionUserInRole */
  protected $condition;
  
  function setUp() {
    $this->condition = $this->getService(ConditionUserInRole::class);
  }
  
  function testGetName() {
    Assert::type("string", $this->condition->getName());
  }
  
  function testIsAllowed() {
    Assert::exception(function() {
      $this->condition->isAllowed();
    }, \InvalidArgumentException::class);
    Assert::false($this->condition->isAllowed("abc"));
    /** @var User $user */
    $user = $this->getService(User::class);
    $user->login("test", "test");
    Assert::true($this->condition->isAllowed("abc"));
  }
}

$test = new ConditionUserInRoleTest;
$test->run();
?>