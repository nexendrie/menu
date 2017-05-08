<?php
declare(strict_types=1);

namespace Nexendrie\Menu;

use Tester\Assert,
    Nette\ComponentModel\IComponent;

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
  
  protected function checkRenderMethodOutput(IComponent $control, $expected, $method = "render", array $renderParameters = []) {
    if(!$control->getParent()) {
      $this->attachToPresenter($control);
    }
    ob_start();
    $control->$method(...$renderParameters);
    if(is_file($expected)) {
      \Tester\Assert::matchFile($expected, ob_get_clean());
    } else {
      \Tester\Assert::match($expected, ob_get_clean());
    }
  }
  
  function testRenderInline() {
    $filename = __DIR__ . "/menuSimpleExpected.latte";
    $this->checkRenderOutput($this->control, $filename);
  }
  
  function testRenderList() {
    $filename = __DIR__ . "/menuListExpected.latte";
    $this->checkRenderMethodOutput($this->control, $filename, "renderList", ["list"]);
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