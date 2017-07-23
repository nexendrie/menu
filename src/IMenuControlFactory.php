<?php

namespace Nexendrie\Menu;

/**
 * IMenuControlFactory
 *
 * @author Jakub Konečný
 */
interface IMenuControlFactory {
  /** @return MenuControl */
  public function create();
}
?>