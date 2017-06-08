<?php
declare(strict_types=1);

namespace Nexendrie\Menu;

use Tester\Assert;

require __DIR__ . "/../../bootstrap.php";

class MenuTest extends \Tester\TestCase {
  /** @var Menu */
  protected $menu;
  
  function setUp() {
    $this->menu = new Menu;
  }
  
  function testHtmlId() {
    Assert::same("menu", $this->menu->htmlId);
    $this->menu->htmlId = "testMenu";
    Assert::same("testMenu", $this->menu->htmlId);
  }
  
  /**
   * @return void
   */
  function testGetAllowedItems() {
    $item1 = new MenuItem("Test:", "Test");
    $item1->addCondition(new class implements IMenuItemCondition {
      function getName(): string {
        return "true";
      }
      
      function isAllowed($parameter = NULL): bool {
        return true;
      }
    }, NULL);
    $this->menu[] = $item1;
    $this->menu[] = $item1;
    $item2 = new MenuItem("Test:", "Test");
    $item2->addCondition(new class implements IMenuItemCondition {
      function getName(): string {
        return "false";
      }
    
      function isAllowed($parameter = NULL): bool {
        return false;
      }
    }, NULL);
    $this->menu[] = $item2;
    $items = $this->menu->getAllowedItems();
    Assert::type("array", $items);
    Assert::count(2, $items);
  }
}

$test = new MenuTest;
$test->run();
?>