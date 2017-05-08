<?php
declare(strict_types=1);

namespace Nexendrie\Menu;

/**
 * Menu
 *
 * @author Jakub Konečný
 * @property string $title
 * @property-read string $name
 * @property string $htmlId
 */
class Menu implements \ArrayAccess, \Countable, \IteratorAggregate {
  use \Nette\SmartObject;
  
  /** @var MenuItem[] */
  protected $items = [];
  /** @var string */
  protected $class = MenuItem::class;
  /** @var string */
  protected $title = "";
  /** @var string */
  protected $name;
  /** @var string*/
  protected $htmlId;
  
  function __construct(string $name = "default", string $htmlId = "menu") {
    $this->name = $name;
    $this->htmlId = $htmlId;
  }
  
  /**
   * @return string
   */
  function getTitle(): string {
    return $this->title;
  }
  
  /**
   * @param string $title
   */
  function setTitle(string $title) {
    $this->title = $title;
  }
  
  /**
   * @return string
   */
  function getName(): string {
    return $this->name;
  }
  
  /**
   * @return string
   */
  function getHtmlId(): string {
    return $this->htmlId;
  }
  
  /**
   * @param string $htmlId
   */
  function setHtmlId(string $htmlId) {
    $this->htmlId = $htmlId;
  }
  
  /**
   * @return int
   */
  function count(): int {
    return count($this->items);
  }
  
  /**
   * @return \ArrayIterator
   */
  function getIterator(): \ArrayIterator {
    return new \ArrayIterator($this->items);
  }
  
  /**
   * @param int $index
   * @return bool
   */
  function offsetExists($index): bool {
    return $index >= 0 AND $index < count($this->items);
  }
  
  /**
   * @param int $index
   * @return MenuItem
   * @throws \OutOfRangeException
   */
  function offsetGet($index): MenuItem {
    if($index < 0 OR $index >= count($this->items)) {
      throw new \OutOfRangeException("Offset invalid or out of range.");
    }
    return $this->items[$index];
  }
  
  /**
   * @param int $index
   * @param MenuItem $item
   * @return void
   * @throws \OutOfRangeException
   * @throws \InvalidArgumentException
   */
  function offsetSet($index, $item): void {
    if(!$item instanceof $this->class) {
      throw new \InvalidArgumentException("Argument must be of $this->class type.");
    }
    if($index === NULL) {
      $this->items[] = $item;
    } elseif($index < 0 OR $index >= count($this->items)) {
      throw new \OutOfRangeException("Offset invalid or out of range.");
    } else {
      $this->items[$index] = & $item;
    }
  }
  
  /**
   * @param int $index
   * @return void
   * @throws \OutOfRangeException
   */
  function offsetUnset($index): void {
    if($index < 0 OR $index >= count($this->items)) {
      throw new \OutOfRangeException("Offset invalid or out of range.");
    }
    array_splice($this->items, $index, 1);
  }
}
?>