<?php
declare(strict_types=1);

namespace Nexendrie\Menu;

/**
 * Menu item
 *
 * @author Jakub Konečný
 * @property-read string $link
 * @property-read bool $allowed
 */
class MenuItem extends Collection {
  public string $text;
  public string $rawLink;
  /** @var array[] of [IMenuItemCondition, string] */
  protected array $conditions = [];
  /** @var IMenuItemLinkRender[] */
  protected array $linkRenders = [];
  
  public function __construct(string $link, string $text) {
    parent::__construct();
    $this->rawLink = $link;
    $this->text = $text;
  }

  protected function getLink(): string {
    $link = $this->rawLink;
    foreach($this->linkRenders as $render) {
      if($render->isApplicable($link)) {
        $link = $render->renderLink($link);
        break;
      }
    }
    return $link;
  }

  /**
   * @param mixed $parameter
   */
  public function addCondition(IMenuItemCondition $condition, $parameter): void {
    $this->conditions[$condition->getName()] = [$condition, $parameter];
  }
  
  public function addLinkRender(IMenuItemLinkRender $render): void {
    $this->linkRenders[$render->getName()] = $render;
  }

  protected function isAllowed(): bool {
    foreach($this->conditions as $condition) {
      if(!$condition[0]->isAllowed($condition[1])) {
        return false;
      }
    }
    return true;
  }
}
?>