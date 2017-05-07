<?php
declare(strict_types=1);

namespace Nexendrie\Menu;

/**
 * Menu
 *
 * @author Jakub Konečný
 * @property string $type
 * @property string $title
 */
class Menu implements \ArrayAccess, \Countable, \IteratorAggregate {
  use \Nette\SmartObject;
  
  /** @var MenuItem[] */
  protected $items = [];
  /** @var string */
  protected $class = MenuItem::class;
  /** @var string */
  protected $type = "inline";
  /** @var string */
  protected $title = "";
  
  /**
   * @return string
   */
  function getType(): string {
    return $this->type;
  }
  
  /**
   * @param string $type
   */
  function setType(string $type) {
    $types = ["inline", "list",];
    if(!in_array($type, $types)) {
      throw new \InvalidArgumentException("Menu type can be either inline or list.");
    }
    $this->type = $type;
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