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
  
  /**
   * @return void
   */
  function testCount() {
    Assert::same(0, count($this->menu));
    $this->menu[] = new MenuItem("Test:", "Test");
    Assert::same(1, count($this->menu));
  }
  
  /**
   * @return void
   */
  function testGetIterator() {
    for($i = 1; $i <= 5; $i++) {
      $this->menu[] = new MenuItem("Test:", "Test");
    }
    /** @var MenuItem $item */
    foreach($this->menu as $item) {
      Assert::same("Test", $item->text);
      Assert::same("Test:", $item->link);
    }
  }
  
  /**
   * @return void
   */
  function testOffsetExists() {
    Assert::false(isset($this->menu[0]));
    $this->menu[] = new MenuItem("Test:", "Test");
    Assert::true(isset($this->menu[0]));
  }
  
  /**
   * @return void
   */
  function testOffsetGet() {
    $this->menu[] = new MenuItem("Test:", "Test");
    $item = $this->menu[0];
    Assert::type(MenuItem::class, $item);
    Assert::exception(function() {
      $item = $this->menu[1];
    }, \OutOfRangeException::class);
  }
  
  function testOffsetSet() {
    $this->menu[] = new MenuItem("Test:", "Test");
    $this->menu[0] = new MenuItem("Test:new", "New Test");
    Assert::same("New Test", $this->menu[0]->text);
    Assert::exception(function() {
      $this->menu[] = new \stdClass;
    }, \InvalidArgumentException::class);
    Assert::exception(function() {
      $this->menu[-1] = new MenuItem("Test:", "Test");
    }, \OutOfRangeException::class);
  }
  
  /**
   * @return void
   */
  function testOffsetUnset() {
    $this->menu[] = new MenuItem("Test:", "Test");
    unset($this->menu[0]);
    Assert::false(isset($this->menu[0]));
    Assert::exception(function() {
      unset($this->menu[0]);
    }, \OutOfRangeException::class);
  }
}

$test = new MenuTest;
$test->run();
?>