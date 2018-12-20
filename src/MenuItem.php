<?php
declare(strict_types=1);

namespace Nexendrie\Menu;

/**
 * Menu item
 *
 * @author Jakub Konečný
 * @property string $link
 * @property-read string $rawLink
 * @property string $text
 * @property-read bool $allowed
 */
class MenuItem extends Collection {
  /** @var string */
  protected $text;
  /** @var string */
  protected $link;
  /** @var array[] of [IMenuItemCondition, string] */
  protected $conditions = [];
  /** @var IMenuItemLinkRender[] */
  protected $linkRenders = [];
  
  public function __construct(string $link, string $text) {
    parent::__construct();
    $this->link = $link;
    $this->text = $text;
  }
  
  public function getLink(): string {
    $link = $this->link;
    foreach($this->linkRenders as $render) {
      if($render->isApplicable($this->link)) {
        $link =  $render->renderLink($this->link);
        break;
      }
    }
    return $link;
  }
  
  public function setLink(string $link) {
    $this->link = $link;
  }

  public function getRawLink(): string {
    return $this->link;
  }

  public function getText(): string {
    return $this->text;
  }
  
  public function setText(string $text) {
    $this->text = $text;
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
  
  public function isAllowed(): bool {
    foreach($this->conditions as $condition) {
      if(!$condition[0]->isAllowed($condition[1])) {
        return false;
      }
    }
    return true;
  }
}
?>