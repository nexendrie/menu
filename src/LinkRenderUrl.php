<?php
declare(strict_types=1);

namespace Nexendrie\Menu;

use Nette\Utils\Validators;

/**
 * LinkRendererUrl
 *
 * @author Jakub Konečný
 */
final class LinkRenderUrl extends BaseLinkRender {
  public function isApplicable(string $link): bool {
    return Validators::isUrl($link);
  }
  
  public function renderLink(string $link): string {
    return $link;
  }
}
?>