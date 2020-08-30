<?php
declare(strict_types=1);

namespace Nexendrie\Menu;

use Tester\Assert;

require __DIR__ . "/../../bootstrap.php";

/**
 * @author Jakub Konečný
 * @testCase
 */
final class ConditionCallbackTest extends \Tester\TestCase {
  use \Testbench\TCompiledContainer;
  
  /** @var ConditionCallback */
  protected $condition;
  
  public function setUp() {
    $this->condition = $this->getService(ConditionCallback::class);
  }
  
  public function testGetName() {
    Assert::same("callback", $this->condition->getName());
  }
  
  public function testIsAllowed() {
    Assert::exception(function() {
      $this->condition->isAllowed(null);
    }, \InvalidArgumentException::class);
    Assert::exception(function() {
      $this->condition->isAllowed(function() {
        return null;
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

$test = new ConditionCallbackTest();
$test->run();
?>