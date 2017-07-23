<?php

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