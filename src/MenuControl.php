<?php
declare(strict_types=1);

namespace Nexendrie\Menu;

use Nette\Utils\Arrays;

/**
 * MenuControl
 *
 * @author Jakub Konečný
 */
class MenuControl extends \Nette\Application\UI\Control {
  /** @var Menu[] */
  protected $menus = [];
  /** @var array */
  protected $templates = [
    "inline" => __DIR__ . "/menuSimple.latte",
    "list" => __DIR__ . "/menuList.latte",
  ];
  
  function addMenu(Menu $menu): void {
    $this->menus[$menu->name] = & $menu;
  }
  
  /**
   * @param string $menuName
   * @return Menu
   * @throws \InvalidArgumentException
   */
  protected function getMenu(string $menuName): Menu {
    foreach($this->menus as $name => $menu) {
      if($name === $menuName) {
        return $menu;
      }
    }
    throw new \InvalidArgumentException("Menu $menuName not found.");
  }
  
  protected function getTemplateFilename(string $menu): string {
    return Arrays::get($this->templates, $this->getMenu($menu)->type);
  }
  
  function render(string $menuName = "default"): void {
    try {
      $menu = $this->getMenu($menuName);
    } catch(\InvalidArgumentException $e) {
      throw $e;
    }
    $this->template->setFile($this->getTemplateFilename($menuName));
    $this->template->menu = $menu;
    $this->template->render();
  }
}
?>