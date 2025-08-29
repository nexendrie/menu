<?php
declare(strict_types=1);

namespace Nexendrie\Menu;

use Tester\Assert;

require __DIR__ . "/../../bootstrap.php";

/**
 * @author Jakub Konečný
 * @testCase
 */
final class MenuItemTest extends \Tester\TestCase
{
    use \Testbench\TCompiledContainer;

    protected MenuItem $item;

    public function setUp(): void
    {
        $this->item = new MenuItem("Test:", "Test");
    }

    public function testLink(): void
    {
        /** @var Menu $menu */
        $menu = $this->getService(Menu::class);
        /** @var MenuItem $item */
        $item = $menu[0];
        Assert::same("http://test.bench/", $item->link);
        Assert::same("Test:", $item->rawLink);
    }
}

$test = new MenuItemTest();
$test->run();
