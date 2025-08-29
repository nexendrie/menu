<?php
declare(strict_types=1);

namespace Nexendrie\Menu;

/**
 * IMenuItemCondition
 *
 * @author Jakub Konečný
 */
interface IMenuItemCondition
{
    public function getName(): string;

    /**
     * @param mixed $parameter
     */
    public function isAllowed($parameter = null): bool;
}
