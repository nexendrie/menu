<?php
declare(strict_types=1);

namespace Nexendrie\Menu;

use Tester\Assert;

require __DIR__ . "/../../bootstrap.php";

/**
 * @author Jakub Konečný
 * @testCase
 */
final class ConditionPermissionTest extends \Tester\TestCase
{
    use \Testbench\TCompiledContainer;

    protected ConditionPermission $condition;

    public function setUp(): void
    {
        $this->condition = $this->getService(ConditionPermission::class); // @phpstan-ignore assign.propertyType
    }

    public function testGetName(): void
    {
        Assert::same("acl", $this->condition->getName());
    }

    public function testIsAllowed(): void
    {
        Assert::exception(function () {
            $this->condition->isAllowed();
        }, \InvalidArgumentException::class);
        Assert::exception(function () {
            $this->condition->isAllowed("test");
        }, \OutOfBoundsException::class);
        Assert::true($this->condition->isAllowed("resource:privilege"));
        Assert::false($this->condition->isAllowed("resource:privilege2"));
    }
}

$test = new ConditionPermissionTest();
$test->run();
