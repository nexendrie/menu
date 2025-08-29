<?php
declare(strict_types=1);

namespace Nexendrie\Menu;

/**
 * LinkRenderJavaScriptAction
 *
 * @author Jakub Konečný
 */
final class LinkRenderJavaScriptAction extends BaseLinkRender
{
    protected string $name = "javascript";

    public function isApplicable(string $link): bool
    {
        return str_starts_with($link, "javascript:");
    }

    public function renderLink(string $link): string
    {
        if (!$this->isApplicable($link)) {
            return "";
        }
        return $link;
    }
}
