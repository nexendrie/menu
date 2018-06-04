<?php
declare(strict_types=1);

namespace Nexendrie\Menu;

use Nette\Application\LinkGenerator;
use Nette\Application\UI\InvalidLinkException;

/**
 * LinkRenderPresenterAction
 *
 * @author Jakub Konečný
 */
final class LinkRenderPresenterAction extends BaseLinkRender {
  protected $name = "presenterAction";
  
  /** @var LinkGenerator */
  private $linkGenerator;
  
  public function __construct(LinkGenerator $linkGenerator) {
    $this->linkGenerator = $linkGenerator;
  }
  
  public function isApplicable(string $link): bool {
    try {
      $this->linkGenerator->link($link);
      return true;
    } catch(InvalidLinkException $e) {
      return false;
    }
  }
  
  public function renderLink(string $link): string {
    try {
      return $this->linkGenerator->link($link);
    } catch(InvalidLinkException $e) {
      return "";
    }
  }
}
?>