<?php
declare(strict_types=1);

namespace Nexendrie\Menu;

use Tester\Assert;
use Nette\ComponentModel\IComponent;

require __DIR__ . "/../../bootstrap.php";

/**
 * @author Jakub Konečný
 * @testCase
 */
final class MenuControlTest extends \Tester\TestCase {
  use \Testbench\TComponent;
  use \Testbench\TCompiledContainer;
  
  /** @var MenuControl */
  protected $control;
  
  public function setUp() {
    static $control = null;
    if($control === null) {
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
      Assert::matchFile($expected, ob_get_clean());
    } else {
      Assert::match($expected, ob_get_clean());
    }
  }
  
  public function testAddMenuType() {
    Assert::exception(function() {
      $this->control->addMenuType("inline", "");
    }, MenuTypeAlreadyDefinedException::class);
    Assert::exception(function() {
      $this->control->addMenuType("custom", "");
    }, TemplateNotFoundException::class);
    $this->control->addMenuType("custom", __DIR__ . "/menuCustom.latte");
    $this->checkRenderMethodOutput($this->control, __DIR__ . "/menuCustom.Expected.latte", "renderCustom");
  }
  
  public function testRenderInline() {
    $this->checkRenderOutput($this->control, __DIR__ . "/menuInlineExpected.latte");
    $this->checkRenderOutput($this->control, __DIR__ . "/menuInlineMultilevelExpected.latte", ["subitems"]);
  }
  
  public function testRenderList() {
    $this->checkRenderMethodOutput($this->control, __DIR__ . "/menuListExpected.latte", "renderList", ["list"]);
    $this->checkRenderMethodOutput($this->control, __DIR__ . "/menuListMultilevelExpected.latte", "renderList", ["subitems"]);
  }
  
  public function testLinkRenders() {
    $filename = __DIR__ . "/menuLinkRendersExpected.latte";
    $this->checkRenderMethodOutput($this->control, $filename, "renderList", ["renders"]);
  }
  
  public function testTranslating() {
    $filename = __DIR__ . "/menuTranslatedExpected.latte";
    $this->checkRenderMethodOutput($this->control, $filename, "renderList", ["translated"]);
  }
  
  public function testInvalidMenu() {
    Assert::exception(function() {
      $this->control->render("invalid");
    }, MenuNotFoundException::class);
  }
  
  public function testInvalidMenuType() {
    Assert::exception(function() {
      $this->control->renderInvalid();
    }, MenuTypeNotSupportedException::class);
  }
}

$test = new MenuControlTest();
$test->run();
?>