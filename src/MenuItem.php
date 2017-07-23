<?php
declare(strict_types=1);

namespace Nexendrie\Menu;

/**
 * Menu item
 *
 * @author Jakub Konečný
 * @property string $link
 * @property string $text
 * @property-read bool $allowed
 */
class MenuItem {
  use \Nette\SmartObject;
  
  /** @var  string */
  protected $text;
  /** @var  string */
  protected $link;
  /** @var array of [IMenuItemCondition, parameter] */
  protected $conditions = [];
  
  public function __construct(string $link, string $text) {
    $this->link = $link;
    $this->text = $text;
  }
  
  /**
   * @return string
   */
  public function getLink(): string {
    return $this->link;
  }
  
  /**
   * @param string $link
   */
  public function setLink(string $link) {
    $this->link = $link;
  }
  
  /**
   * @return string
   */
  public function getText(): string {
    return $this->text;
  }
  
  /**
   * @param string $text
   */
  public function setText(string $text) {
    $this->text = $text;
  }
  
  /**
   * @param IMenuItemCondition $condition
   * @param mixed $parameter
   * @return void
   */
  public function addCondition(IMenuItemCondition $condition, $parameter): void {
    $this->conditions[$condition->getName()] = [$condition, $parameter];
  }
  
  /**
   * @return bool
   */
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