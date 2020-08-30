<?php
declare(strict_types=1);

namespace Nexendrie\Menu\DI;

use Tester\Assert;
use Nexendrie\Menu\Menu;
use Nexendrie\Menu\InvalidMenuItemDefinitionException;
use Nexendrie\Menu\MenuItemConditionNotSupportedException;

require __DIR__ . "/../../../bootstrap.php";

/**
 * @author Jakub Konečný
 * @testCase
 */
final class MenuFactoryTest extends \Tester\TestCase {
  use \Testbench\TCompiledContainer;
  
  /** @var MenuFactory */
  protected $factory;
  
  public function setUp() {
    $this->factory = $this->getContainer()->getService("menu." . MenuExtension::SERVICE_MENU_FACTORY);
  }
  
  public function testCreateMenu() {
    $config = [
      "htmlId" => "menu",
      "title" => "Menu",
      "items" => [
        "Item 1" => "Test:"
      ]
    ];
    $menu = $this->factory->createMenu("default", $config);
    Assert::type(Menu::class, $menu);
    Assert::same("menu", $menu->htmlId);
    Assert::same("Menu", $menu->title);
    Assert::count(1, $menu);
    $config["items"]["Item 1"] =  1;
    Assert::exception(function() use($config) {
      $this->factory->createMenu("default", $config);
    }, \InvalidArgumentException::class);
    $config["items"]["Item 1"] =  [];
    Assert::exception(function() use($config) {
      $this->factory->createMenu("default", $config);
    }, InvalidMenuItemDefinitionException::class);
    $config["items"]["Item 1"] =  [
      "link" => "Test:",
      "conditions" => [
        "abc" => false
      ]
    ];
    Assert::exception(function() use($config) {
      $this->factory->createMenu("default", $config);
    }, MenuItemConditionNotSupportedException::class);
  }
}

$test = new MenuFactoryTest();
$test->run();
?>