<?php
declare(strict_types=1);

namespace Nexendrie\Menu;

use Tester\Assert;

require __DIR__ . "/../../bootstrap.php";

class MenuItemTest extends \Tester\TestCase {
  /** @var MenuItem */
  protected $item;
  
  public function setUp() {
    $this->item = new MenuItem("Test:", "Test");
  }
  
  public function testLink() {
    Assert::same("Test:", $this->item->link);
    $this->item->link = "Test:new";
    Assert::same("Test:new", $this->item->link);
  }
  
  public function testText() {
    Assert::same("Test", $this->item->text);
    $this->item->text = "New Test";
    Assert::same("New Test", $this->item->text);
  }
}

$test = new MenuItemTest;
$test->run();
?>