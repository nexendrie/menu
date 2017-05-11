<?php
declare(strict_types=1);

namespace Nexendrie\Menu\DI;

use Tester\Assert,
    Nexendrie\Menu\IMenuControlFactory,
    Nexendrie\Menu\MenuControl,
    Nexendrie\Menu\Menu,
    Nexendrie\Menu\MenuTypeAlreadyDefinedException;

require __DIR__ . "/../../../bootstrap.php";

class MenuExtensionTest extends \Tester\TestCase {
  use \Testbench\TCompiledContainer;
  
  function setUp() {
    $this->refreshContainer();
  }
  
  function testComponent() {
    /** @var IMenuControlFactory $component */
    $component = $this->getService(IMenuControlFactory::class);
    Assert::type(IMenuControlFactory::class, $component);
    Assert::type(MenuControl::class, $component->create());
  }
  
  function testMenu() {
    /** @var Menu $menu */
    $menu = $this->getService(Menu::class);
    Assert::type(Menu::class, $menu);
  }
  
  function testMenuTypes() {
    $this->refreshContainer(["menu" => [
      "menu_types" => [
        "custom" => __DIR__ . "/../menuCustom.latte",
      ]
    ]]);
    /** @var MenuControl $control */
    $control = $this->getService(IMenuControlFactory::class)->create();
    Assert::exception(function() use($control) {
      $control->addMenuType("custom", "");
    }, MenuTypeAlreadyDefinedException::class);
  }
}

$test = new MenuExtensionTest;
$test->run();
?>