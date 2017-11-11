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
  /** @var MenuItem[] */
  protected $items = [];
  /** @var string */
  protected $class = MenuItem::class;
  
  /**
   * @return MenuItem[]
   */
  public function getAllowedItems(): array {
    $items = [];
    foreach($this->items as $item) {
      if($item->isAllowed()) {
        $items[] = $item;
      }
    }
    return $items;
  }
}
?>