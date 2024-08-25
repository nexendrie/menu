<?php
declare(strict_types=1);

namespace Nexendrie\Menu;

require __DIR__ . "/../../bootstrap.php";

use Tester\Assert;

/**
 * @author Jakub Konečný
 * @testCase
 */
final class LinkRenderPresenterActionTest extends \Tester\TestCase {
  use \Testbench\TCompiledContainer;

  protected LinkRenderPresenterAction $render;
  
  protected function setUp(): void {
    $this->render = $this->getService(LinkRenderPresenterAction::class); // @phpstan-ignore assign.propertyType
  }
  
  public function testIsApplicable(): void {
    Assert::true($this->render->isApplicable("Test:new"));
    Assert::false($this->render->isApplicable("https://nexendrie.gitlab.io"));
  }
  
  public function testRenderLink(): void {
    Assert::same("http://test.bench/test/new", $this->render->renderLink("Test:new"));
    Assert::same("", $this->render->renderLink("Abc"));
  }
}

$test = new LinkRenderPresenterActionTest();
$test->run();
?>