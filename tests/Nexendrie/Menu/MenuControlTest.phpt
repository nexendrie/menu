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
    $this->control = $this->getService(IMenuControlFactory::class)->create();
    $this->attachToPresenter($this->control);
  }
  
  function testRenderSimple() {
    $filename = __DIR__ . "/menuSimpleExpected.latte";
    $this->checkRenderOutput($this->control, $filename);
  }
}

$test = new MenuControlTest;
$test->run();
?>