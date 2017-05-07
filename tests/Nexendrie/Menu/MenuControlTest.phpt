<?php
declare(strict_types=1);

namespace Nexendrie\Menu;

use Tester\Assert;

require __DIR__ . "/../../bootstrap.php";

class MenuControlTest extends \Tester\TestCase {
  use \Testbench\TComponent;
  use \Testbench\TCompiledContainer;
  
  /** @var MenuControl */
  protected $control;
  
  function setUp() {
    static $control = NULL;
    if(is_null($control)) {
      $control = $this->getService(IMenuControlFactory::class)->create();
    }
    $this->control = $control;
    $this->attachToPresenter($this->control);
  }
  
  function testRenderSimple() {
    $filename = __DIR__ . "/menuSimpleExpected.latte";
    $this->checkRenderOutput($this->control, $filename);
  }
  
  function testRenderList() {
    $filename = __DIR__ . "/menuListExpected.latte";
    $this->checkRenderOutput($this->control, $filename, ["list"]);
  }
  
  function testInvalidMenu() {
    Assert::exception(function() {
      $this->control->render("invalid");
    }, \InvalidArgumentException::class);
  }
}

$test = new MenuControlTest;
$test->run();
?>