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

  protected ConditionCallback $condition;
  
  public function setUp(): void {
    $this->condition = $this->getService(ConditionCallback::class); // @phpstan-ignore assign.propertyType
  }
  
  public function testGetName(): void {
    Assert::same("callback", $this->condition->getName());
  }
  
  public function testIsAllowed(): void {
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