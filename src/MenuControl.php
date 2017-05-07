<?php
declare(strict_types=1);

namespace Nexendrie\Menu;

use Nette\Utils\Arrays;

/**
 * MenuControl
 *
 * @author Jakub Konečný
 * @property Menu $menu
 */
class MenuControl extends \Nette\Application\UI\Control {
  /** @var Menu */
  protected $menu;
  /** @var array */
  protected $templates = [
    "inline" => __DIR__ . "/menuSimple.latte",
    "list" => __DIR__ . "/menuList.latte",
  ];
  
  /**
   * MenuControl constructor.
   * @param Menu $menu
   */
  function __construct(Menu $menu) {
    parent::__construct();
    $this->menu = $menu;
  }
  
  /**
   * @return Menu
   */
  function getMenu(): Menu {
    return $this->menu;
  }
  
  protected function getTemplateFilename(): string {
    return Arrays::get($this->templates, $this->menu->type);
  }
  
  function render(): void {
    $this->template->setFile($this->getTemplateFilename());
    $this->template->menu = $this->menu;
    $this->template->render();
  }
}
?>