<?php
declare(strict_types=1);

namespace Nexendrie\Menu;

/**
 * ConditionABC
 *
 * @author Jakub Konečný
 */
final class ConditionABC extends BaseCondition
{
    public function isAllowed($parameter = null): bool
    {
        return true;
    }
}
