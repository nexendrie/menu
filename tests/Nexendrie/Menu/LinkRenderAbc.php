<?php
declare(strict_types=1);

namespace Nexendrie\Menu;

/**
 * LinkRenderAbc
 *
 * @author Jakub Konečný
 */
class LinkRenderAbc extends BaseLinkRender {
  public function isApplicable(string $link): bool {
    return true;
  }
  
  public function renderLink(string $link): string {
    return $link;
  }
}
?>