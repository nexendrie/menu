<?php
declare(strict_types=1);

namespace Nexendrie\Menu;

require __DIR__ . "/../../bootstrap.php";

use Tester\Assert;

/**
 * @author Jakub Konečný
 * @testCase
 */
final class LinkRenderJavaScriptActionTest extends \Tester\TestCase
{
    use \Testbench\TCompiledContainer;

    protected LinkRenderJavaScriptAction $render;

    protected function setUp(): void
    {
        $this->render = $this->getService(LinkRenderJavaScriptAction::class); // @phpstan-ignore assign.propertyType
    }

    public function testIsApplicable(): void
    {
        Assert::true($this->render->isApplicable("javascript:void()"));
        Assert::false($this->render->isApplicable("Test:new"));
        Assert::false($this->render->isApplicable("https://nexendrie.gitlab.io"));
    }

    public function testRenderLink(): void
    {
        Assert::same("javascript:void()", $this->render->renderLink("javascript:void()"));
        Assert::same("", $this->render->renderLink("abc:def"));
    }
}

$test = new LinkRenderJavaScriptActionTest();
$test->run();
