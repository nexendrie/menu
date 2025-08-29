<?php
declare(strict_types=1);

namespace Nexendrie\Menu;

/**
 * ConditionCallback
 *
 * @author Jakub Konečný
 */
final class ConditionCallback extends BaseCondition
{
    /**
     * @param callable $parameter
     * @throws \InvalidArgumentException
     * @throws \UnexpectedValueException
     */
    public function isAllowed($parameter = null): bool
    {
        if (!is_callable($parameter)) {
            throw new \InvalidArgumentException("Method " . __METHOD__ . " expects callback as parameter.");
        }
        $result = call_user_func($parameter);
        if (!is_bool($result)) {
            throw new \UnexpectedValueException(
                "The callback for method " . __METHOD__ . " has to return boolean, " . gettype($result) . " returned."
            );
        }
        return $result;
    }
}
