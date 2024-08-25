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

/**
 * @author Jakub Konečný
 * @testCase
 */
final class MenuExtensionTest extends \Tester\TestCase {
  use \Testbench\TCompiledContainer;
  
  public function setUp(): void {
    $this->refreshContainer();
  }
  
  public function testComponent(): void {
    /** @var IMenuControlFactory $component */
    $component = $this->getService(IMenuControlFactory::class);
    Assert::type(IMenuControlFactory::class, $component);
    Assert::type(MenuControl::class, $component->create());
  }
  
  public function testMenu(): void {
    /** @var Menu $menu */
    $menu = $this->getService(Menu::class);
    Assert::type(Menu::class, $menu);
  }
  
  public function testMenuTypes(): void {
    $this->refreshContainer(["menu" => [
      "menu_types" => [
        "custom" => __DIR__ . "/../menuCustom.latte",
      ]
    ]]);
    /** @var IMenuControlFactory $factory */
    $factory = $this->getService(IMenuControlFactory::class);
    $control = $factory->create();
    Assert::exception(function() use($control) {
      $control->addMenuType("custom", "");
    }, MenuTypeAlreadyDefinedException::class);
  }
  
  public function testConditions(): void {
    $condition = $this->getService(ConditionCallback::class);
    Assert::type(ConditionCallback::class, $condition);
  }
  
  public function testLinkRenderers(): void {
    $renderer = $this->getService(LinkRenderPresenterAction::class);
    Assert::type(LinkRenderPresenterAction::class, $renderer);
  }
  
  public function testSubitems(): void {
    /** @var Menu $menu */
    $menu = $this->getContainer()->getService("menu.subitems");
    Assert::count(1, $menu);
    /** @var Menu $subitems */
    $subitems = $menu[0];
    Assert::count(1, $subitems);
  }
}

$test = new MenuExtensionTest();
$test->run();
?>