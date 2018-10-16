<?php
declare(strict_types=1);

namespace Nexendrie\Menu;

use Nette\Utils\Strings;

/**
 * LinkRenderJavaScriptAction
 *
 * @author Jakub Konečný
 */
final class LinkRenderJavaScriptAction extends BaseLinkRender {
  /** @var string */
  protected $name = "javascript";
  
  public function isApplicable(string $link): bool {
    return Strings::startsWith($link, "javascript:");
  }
  
  public function renderLink(string $link): string {
    if(!$this->isApplicable($link)) {
      return "";
    }
    return $link;
  }
}
?>