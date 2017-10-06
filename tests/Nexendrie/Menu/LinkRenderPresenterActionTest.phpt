<?php
declare(strict_types=1);

namespace Nexendrie\Menu;

require __DIR__ . "/../../bootstrap.php";

use Tester\Assert;

final class LinkRenderPresenterActionTest extends \Tester\TestCase {
  use \Testbench\TCompiledContainer;
  
  /** @var LinkRenderPresenterAction */
  protected $render;
  
  protected function setUp() {
    $this->render = $this->getService(LinkRenderPresenterAction::class);
  }
  
  public function testIsApplicable() {
    Assert::true($this->render->isApplicable("Test:new"));
    Assert::false($this->render->isApplicable("https://nexendrie.gitlab.io"));
  }
  
  public function testRenderLink() {
    Assert::same("http://test.bench/test/new", $this->render->renderLink("Test:new"));
    Assert::same("", $this->render->renderLink("Abc"));
  }
}

$test = new LinkRenderPresenterActionTest();
$test->run();
?>