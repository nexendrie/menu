<?php
declare(strict_types=1);

namespace Nexendrie\Menu;

use Tester\Assert;

require __DIR__ . "/../../bootstrap.php";

/**
 * @author Jakub Konečný
 * @testCase
 */
final class BaseConditionTest extends \Tester\TestCase {
  public function testProperty() {
    $condition = new class extends BaseCondition {
      protected string $name = "abc";
      
      public function isAllowed($parameter = null): bool {
        return true;
      }
    };
    Assert::same("abc", $condition->getName());
  }
  
  public function testClassName() {
    $condition = new ConditionABC();
    Assert::same("abc", $condition->getName());
  }
}

$test = new BaseConditionTest();
$test->run();
?>