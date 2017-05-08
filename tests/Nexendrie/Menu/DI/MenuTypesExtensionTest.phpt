<?php
declare(strict_types=1);

namespace Nexendrie\Menu\DI;

use Tester\Assert,
    Nexendrie\Menu\IMenuControlFactory,
    Nexendrie\Menu\MenuControl,
    Nexendrie\Menu\MenuTypeAlreadyDefinedException;

require __DIR__ . "/../../../bootstrap.php";

class MenuTypesExtensionTest extends \Tester\TestCase {
  use \Testbench\TCompiledContainer;
  
  function testMenuTypes() {
    $this->refreshContainer(["menu_types" => [
      "custom" => __DIR__ . "/../menuCustom.latte",
    ]]);
    /** @var MenuControl $control */
    $control = $this->getService(IMenuControlFactory::class)->create();
    Assert::exception(function() use($control) {
      $control->addMenuType("custom", "");
    }, MenuTypeAlreadyDefinedException::class);
  }
}

$test = new MenuTypesExtensionTest;
$test->run();
?>