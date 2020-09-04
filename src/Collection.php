<?php
declare(strict_types=1);

namespace Nexendrie\Menu;

use Nexendrie\Utils\Collection as BaseCollection;

/**
 * Collection of menu items
 *
 * @author Jakub Konečný
 * @internal
 * @property-read MenuItem[] $allowedItems
 */
abstract class Collection extends BaseCollection {
  use \Nette\SmartObject;

  /** @var string */
  protected $class = MenuItem::class;
  
  /**
   * @return MenuItem[]
   * @deprecated Access the property directly
   */
  public function getAllowedItems(): array {
    return $this->getItems(["allowed" => true]);
  }
}
?>