<?php
declare(strict_types=1);

namespace Nexendrie\Menu;

use Tester\Assert,
    Nette\Security\User;

require __DIR__ . "/../../bootstrap.php";

final class ConditionUserInRoleTest extends \Tester\TestCase {
  use \Testbench\TCompiledContainer;
  
  /** @var ConditionUserInRole */
  protected $condition;
  
  public function setUp() {
    $this->condition = $this->getService(ConditionUserInRole::class);
  }
  
  public function testGetName() {
    Assert::same("role", $this->condition->getName());
  }
  
  public function testIsAllowed() {
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