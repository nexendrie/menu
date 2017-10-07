<?php
declare(strict_types=1);

namespace Nexendrie\Menu;

/**
 * IMenuControlFactory
 *
 * @author Jakub Konečný
 */
interface IMenuControlFactory {
  public function create(): MenuControl;
}
?>