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

  protected MenuControl $control;
  
  public function setUp(): void {
    static $control = null;
    if($control === null) {
      /** @var IMenuControlFactory $factory */
      $factory = $this->getService(IMenuControlFactory::class);
      $control = $factory->create();
    }
    $this->control = $control;
    $this->attachToPresenter($this->control);
  }
  
  protected function checkRenderMethodOutput(IComponent $control, string $expected, string $method = "render", array $renderParameters = []): void {
    if($control->getParent() === null) {
      $this->attachToPresenter($control);
    }
    ob_start();
    $control->$method(...$renderParameters); // @phpstan-ignore method.dynamicName
    if(is_file($expected)) {
      Assert::matchFile($expected, (string) ob_get_clean());
    } else {
      Assert::match($expected, (string) ob_get_clean());
    }
  }
  
  public function testAddMenuType(): void {
    Assert::exception(function() {
      $this->control->addMenuType("inline", "");
    }, MenuTypeAlreadyDefinedException::class);
    Assert::exception(function() {
      $this->control->addMenuType("custom", "");
    }, TemplateNotFoundException::class);
    $this->control->addMenuType("custom", __DIR__ . "/menuCustom.latte");
    $this->checkRenderMethodOutput($this->control, __DIR__ . "/menuCustom.Expected.latte", "renderCustom");
  }
  
  public function testRenderInline(): void {
    $this->checkRenderOutput($this->control, __DIR__ . "/menuInlineExpected.latte");
    $this->checkRenderOutput($this->control, __DIR__ . "/menuInlineMultilevelExpected.latte", ["subitems"]);
  }
  
  public function testRenderList(): void {
    $this->checkRenderMethodOutput($this->control, __DIR__ . "/menuListExpected.latte", "renderList", ["list"]);
    $this->checkRenderMethodOutput($this->control, __DIR__ . "/menuListMultilevelExpected.latte", "renderList", ["subitems"]);
  }
  
  public function testLinkRenders(): void {
    $filename = __DIR__ . "/menuLinkRendersExpected.latte";
    $this->checkRenderMethodOutput($this->control, $filename, "renderList", ["renders"]);
  }
  
  public function testTranslating(): void {
    $filename = __DIR__ . "/menuTranslatedExpected.latte";
    $this->checkRenderMethodOutput($this->control, $filename, "renderList", ["translated"]);
  }
  
  public function testInvalidMenu(): void {
    Assert::exception(function() {
      $this->control->render("invalid");
    }, MenuNotFoundException::class);
  }
  
  public function testInvalidMenuType(): void {
    Assert::exception(function() {
      $this->control->renderInvalid(); // @phpstan-ignore method.notFound
    }, MenuTypeNotSupportedException::class);
  }
}

$test = new MenuControlTest();
$test->run();
?>