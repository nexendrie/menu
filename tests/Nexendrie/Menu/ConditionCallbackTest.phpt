<?php
declare(strict_types=1);

namespace Nexendrie\Menu;

use Tester\Assert;

require __DIR__ . "/../../bootstrap.php";

class ConditionCallbackTest extends \Tester\TestCase {
  use \Testbench\TCompiledContainer;
  
  /** @var ConditionCallback */
  protected $condition;
  
  function setUp() {
    $this->condition = $this->getService(ConditionCallback::class);
  }
  
  function testGetName() {
    Assert::type("string", $this->condition->getName());
  }
  
  function testIsAllowed() {
    Assert::exception(function() {
      $this->condition->isAllowed(NULL);
    }, \InvalidArgumentException::class);
    Assert::exception(function() {
      $this->condition->isAllowed(function() {
        return NULL;
      });
    }, \UnexpectedValueException::class);
    Assert::true($this->condition->isAllowed(function() {
      return true;
    }));
    Assert::false($this->condition->isAllowed(function() {
      return false;
    }));
  }
}

$test = new ConditionCallbackTest;
$test->run();
?>