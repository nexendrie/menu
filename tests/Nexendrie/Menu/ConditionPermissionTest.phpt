<?php
declare(strict_types=1);

namespace Nexendrie\Menu;

use Tester\Assert;

require __DIR__ . "/../../bootstrap.php";

class ConditionPermissionTest extends \Tester\TestCase {
  use \Testbench\TCompiledContainer;
  
  /** @var ConditionPermission */
  protected $condition;
  
  function setUp() {
    $this->condition = $this->getService(ConditionPermission::class);
  }
  
  function testGetName() {
    Assert::type("string", $this->condition->getName());
  }
  
  function testIsAllowed() {
    Assert::exception(function() {
      $this->condition->isAllowed();
    }, \InvalidArgumentException::class);
    Assert::exception(function() {
      $this->condition->isAllowed("test");
    }, \OutOfBoundsException::class);
    Assert::true($this->condition->isAllowed("resource:privilege"));
    Assert::false($this->condition->isAllowed("resource:privilege2"));
  }
}

$test = new ConditionPermissionTest;
$test->run();
?>