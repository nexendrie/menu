<?php
declare(strict_types=1);

namespace Nexendrie\Menu;

/**
 * IMenuItemLinkRender
 *
 * @author Jakub Konečný
 */
interface IMenuItemLinkRender
{
    public function isApplicable(string $link): bool;

    public function renderLink(string $link): string;

    public function getName(): string;
}
