<?php
declare(strict_types=1);

namespace Nexendrie\Menu;

use Tester\Assert;

require __DIR__ . "/../../bootstrap.php";

final class MenuTest extends \Tester\TestCase {
  /** @var Menu */
  protected $menu;
  
  public function setUp() {
    $this->menu = new Menu();
  }
  
  public function testHtmlId() {
    Assert::same("menu", $this->menu->htmlId);
    $this->menu->htmlId = "testMenu";
    Assert::same("testMenu", $this->menu->htmlId);
  }
  
  /**
   * @return void
   */
  public function testGetAllowedItems() {
    $item1 = new MenuItem("Test:", "Test");
    $item1->addCondition(new class implements IMenuItemCondition {
      public function getName(): string {
        return "true";
      }
      
      public function isAllowed($parameter = null): bool {
        return true;
      }
    }, null);
    $this->menu[] = $item1;
    $this->menu[] = $item1;
    $item2 = new MenuItem("Test:", "Test");
    $item2->addCondition(new class implements IMenuItemCondition {
      public function getName(): string {
        return "false";
      }
    
      public function isAllowed($parameter = null): bool {
        return false;
      }
    }, null);
    $this->menu[] = $item2;
    $items = $this->menu->getAllowedItems();
    Assert::type("array", $items);
    Assert::count(2, $items);
  }
}

$test = new MenuTest();
$test->run();
?>