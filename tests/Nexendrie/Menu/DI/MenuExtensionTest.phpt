<?php
declare(strict_types=1);

namespace Nexendrie\Menu\DI;

use Tester\Assert;
use Nexendrie\Menu\IMenuControlFactory;
use Nexendrie\Menu\MenuControl;
use Nexendrie\Menu\Menu;
use Nexendrie\Menu\MenuTypeAlreadyDefinedException;
use Nexendrie\Menu\ConditionCallback;
use Nexendrie\Menu\LinkRenderPresenterAction;

require __DIR__ . "/../../../bootstrap.php";

final class MenuExtensionTest extends \Tester\TestCase {
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
  
  public function testSubitems() {
    $menu = $this->getContainer()->getService("menu.subitems");
    Assert::count(1, $menu);
    Assert::count(1, $menu[0]);
  }
}

$test = new MenuExtensionTest();
$test->run();
?>