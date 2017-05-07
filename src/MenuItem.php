<?php
declare(strict_types=1);

namespace Nexendrie\Menu;

/**
 * Menu item
 *
 * @author Jakub Konečný
 * @property string $link
 * @property string $text
 */
class MenuItem {
  use \Nette\SmartObject;
  
  /** @var  string */
  protected $text;
  /** @var  string */
  protected $link;
  
  function __construct(string $link, string $text) {
    $this->link = $link;
    $this->text = $text;
  }
  
  /**
   * @return string
   */
  function getLink(): string {
    return $this->link;
  }
  
  /**
   * @param string $link
   */
  function setLink(string $link) {
    $this->link = $link;
  }
  
  /**
   * @return string
   */
  function getText(): string {
    return $this->text;
  }
  
  /**
   * @param string $text
   */
  function setText(string $text) {
    $this->text = $text;
  }
}
?>