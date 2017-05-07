<?php
declare(strict_types=1);

namespace Nexendrie\Menu;

/**
 * MenuControl
 *
 * @author Jakub Konečný
 * @property Menu $menu
 */
class MenuControl extends \Nette\Application\UI\Control {
  /** @var Menu */
  protected $menu;
  
  /**
   * MenuControl constructor.
   * @param Menu $menu
   */
  function __construct(Menu $menu) {
    parent::__construct();
    $this->menu = $menu;
  }
  
  function render(): void {
    $this->template->setFile(__DIR__ . "/menuSimple.latte");
    $this->template->items = $this->menu->getIterator();
    $this->template->render();
  }
}
?>