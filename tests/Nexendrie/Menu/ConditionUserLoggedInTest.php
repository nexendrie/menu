<?php
declare(strict_types=1);

namespace Nexendrie\Menu;

use Tester\Assert;

require __DIR__ . "/../../bootstrap.php";

/**
 * @author Jakub Konečný
 * @testCase
 */
final class ConditionUserLoggedInTest extends \Tester\TestCase {
  use \Testbench\TCompiledContainer;

  protected ConditionUserLoggedIn $condition;
  
  public function setUp(): void {
    $this->condition = $this->getService(ConditionUserLoggedIn::class); // @phpstan-ignore assign.propertyType
  }
  
  public function testGetName(): void {
    Assert::same("loggedIn", $this->condition->getName());
  }
  
  public function testIsAllowed(): void {
    Assert::true($this->condition->isAllowed());
    Assert::exception(function() {
      $this->condition->isAllowed("yes"); // @phpstan-ignore argument.type
    }, \InvalidArgumentException::class);
    Assert::false($this->condition->isAllowed(true));
    Assert::true($this->condition->isAllowed(false));
  }
}

$test = new ConditionUserLoggedInTest();
$test->run();
?>