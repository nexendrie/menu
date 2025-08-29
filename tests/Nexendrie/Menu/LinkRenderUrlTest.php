<?php
declare(strict_types=1);

namespace Nexendrie\Menu;

require __DIR__ . "/../../bootstrap.php";

use Tester\Assert;

/**
 * @author Jakub Konečný
 * @testCase
 */
final class LinkRenderUrlTest extends \Tester\TestCase
{
    use \Testbench\TCompiledContainer;

    protected LinkRenderUrl $render;

    protected function setUp(): void
    {
        $this->render = $this->getService(LinkRenderUrl::class); // @phpstan-ignore assign.propertyType
    }

    public function testIsApplicable(): void
    {
        Assert::true($this->render->isApplicable("https://nexendrie.gitlab.io/menu"));
        Assert::false($this->render->isApplicable("javascript:void()"));
        Assert::false($this->render->isApplicable("Test:new"));
    }

    public function testRenderLink(): void
    {
        Assert::same("https://nexendrie.gitlab.io/menu", $this->render->renderLink("https://nexendrie.gitlab.io/menu"));
        Assert::same("", $this->render->renderLink("Test:new"));
    }
}

$test = new LinkRenderUrlTest();
$test->run();
