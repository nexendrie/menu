<?php
declare(strict_types=1);

namespace Nexendrie\Menu;

use Nexendrie\Utils\Collection as BaseCollection;

/**
 * Collection of menu items
 *
 * @author Jakub Konečný
 * @property-read MenuItem[] $allowedItems
 */
abstract class Collection extends BaseCollection {
  use \Nette\SmartObject;
  
  /** @var string */
  protected $class = MenuItem::class;
  
  /**
   * @return MenuItem[]
   */
  public function getAllowedItems(): array {
    return array_values(array_filter($this->items, function(MenuItem $item) {
      return $item->isAllowed();
    }));
  }
}
?>