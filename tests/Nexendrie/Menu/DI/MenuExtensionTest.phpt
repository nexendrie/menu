<?php
declare(strict_types=1);

namespace Nexendrie\Menu\DI;

use Tester\Assert,
    Nexendrie\Menu\IMenuControlFactory,
    Nexendrie\Menu\MenuControl,
    Nexendrie\Menu\Menu,
    Nexendrie\Menu\MenuTypeAlreadyDefinedException,
    Nexendrie\Menu\ConditionCallback,
    Nexendrie\Menu\LinkRenderPresenterAction;

require __DIR__ . "/../../../bootstrap.php";

class MenuExtensionTest extends \Tester\TestCase {
  use \Testbench\TCompiledContainer;
  
  public function setUp() {
    $this->refreshContainer();
  }
  
  public function testComponent() {
    /** @var IMenuControlFactory $component */
    $component = $this->getService(IMenuControlFactory::class);
    Assert::type(IMenuControlFactory::class, $component);
    Assert::type(MenuControl::class, $component->create());
  }
  
  public function testMenu() {
    /** @var Menu $menu */
    $menu = $this->getService(Menu::class);
    Assert::type(Menu::class, $menu);
  }
  
  public function testMenuTypes() {
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
  
  public function testConditions() {
    $condition = $this->getService(ConditionCallback::class);
    Assert::type(ConditionCallback::class, $condition);
  }
  
  public function testLinkRenderers() {
    $renderer = $this->getService(LinkRenderPresenterAction::class);
    Assert::type(LinkRenderPresenterAction::class, $renderer);
  }
}

$test = new MenuExtensionTest;
$test->run();
?>