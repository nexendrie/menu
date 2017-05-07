<?php
declare(strict_types=1);

namespace Nexendrie\Menu\DI;

use Tester\Assert,
    Nexendrie\Menu\IMenuControlFactory,
    Nexendrie\Menu\Menu;

require __DIR__ . "/../../../bootstrap.php";

class MenuExtensionTest extends \Tester\TestCase {
  use \Testbench\TCompiledContainer;
  
  function setUp() {
    $this->refreshContainer();
  }
  
  function testComponent() {
    $component = $this->getService(IMenuControlFactory::class);
    Assert::type(IMenuControlFactory::class, $component);
  }
  
  function testMenu() {
    /** @var Menu $menu */
    $menu = $this->getService(Menu::class);
    Assert::type(Menu::class, $menu);
    Assert::same("inline", $menu->type);
    $this->refreshContainer(["menu" => [
      "default" => [
        "type" => "list"
      ]
    ]]);
    /** @var Menu $menu */
    $menu = $this->getService(Menu::class);
    Assert::type(Menu::class, $menu);
    Assert::same("list", $menu->type);
  }
}

$test = new MenuExtensionTest;
$test->run();
?>