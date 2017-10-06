<?php
declare(strict_types=1);

namespace Nexendrie\Menu;

require __DIR__ . "/../../bootstrap.php";

use Tester\Assert;

final class LinkRenderUrlTest extends \Tester\TestCase {
  use \Testbench\TCompiledContainer;
  
  /** @var LinkRenderUrl */
  protected $render;
  
  protected function setUp() {
    $this->render = $this->getService(LinkRenderUrl::class);
  }
  
  public function testIsApplicable() {
    Assert::true($this->render->isApplicable("https://nexendrie.gitlab.io/menu"));
    Assert::false($this->render->isApplicable("javascript:void()"));
    Assert::false($this->render->isApplicable("Test:new"));
  }
  
  public function testRenderLink() {
    Assert::same("https://nexendrie.gitlab.io/menu", $this->render->renderLink("https://nexendrie.gitlab.io/menu"));
  }
}

$test = new LinkRenderUrlTest();
$test->run();
?>