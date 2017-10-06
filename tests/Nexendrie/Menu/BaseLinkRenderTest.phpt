<?php
declare(strict_types=1);

namespace Nexendrie\Menu;

require __DIR__ . "/../../bootstrap.php";

use Tester\Assert;

final class BaseLinkRenderTest extends \Tester\TestCase {
  public function testProperty() {
    $condition = new class extends BaseLinkRender {
      protected $name = "abc";
      
      public function isApplicable(string $link): bool {
        return true;
      }
      
      public function renderLink(string $link): string {
        return $link;
      }
    };
    Assert::same("abc", $condition->getName());
  }
  
  public function testClassName() {
    $condition = new LinkRenderAbc();
    Assert::same("abc", $condition->getName());
  }
}

$test = new BaseLinkRenderTest();
$test->run();
?>