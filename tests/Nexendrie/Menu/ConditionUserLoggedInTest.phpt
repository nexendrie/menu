<?php
declare(strict_types=1);

namespace Nexendrie\Menu;

use Tester\Assert;

require __DIR__ . "/../../bootstrap.php";

class ConditionUserLoggedInTest extends \Tester\TestCase {
  use \Testbench\TCompiledContainer;
  
  /** @var ConditionUserLoggedIn */
  protected $condition;
  
  public function setUp() {
    $this->condition = $this->getService(ConditionUserLoggedIn::class);
  }
  
  public function testGetName() {
    Assert::same("loggedIn", $this->condition->getName());
  }
  
  public function testIsAllowed() {
    Assert::true($this->condition->isAllowed());
    Assert::exception(function() {
      $this->condition->isAllowed("yes");
    }, \InvalidArgumentException::class);
    Assert::false($this->condition->isAllowed(true));
    Assert::true($this->condition->isAllowed(false));
  }
}

$test = new ConditionUserLoggedInTest;
$test->run();
?>