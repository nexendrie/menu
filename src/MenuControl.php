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
  
  /**
   * @param string $menuType
   * @return string
   * @throws \InvalidArgumentException
   */
  protected function getTemplateFilename(string $menuType): string {
    $filename = Arrays::get($this->templates, $menuType, "");
    if($filename === "") {
      throw new \InvalidArgumentException("Menu type $menuType is not supported.");
    } else {
      return $filename;
    }
  }
  
  /**
   * @param string $menuName
   * @param string $menuType
   * @return void
   * @throws \InvalidArgumentException
   */
  protected function baseRender(string $menuName, string $menuType): void {
    try {
      $menu = $this->getMenu($menuName);
      $templateFile = $this->getTemplateFilename($menuType);
    } catch(\InvalidArgumentException $e) {
      throw $e;
    }
    $this->template->setFile($templateFile);
    $this->template->menu = $menu;
    $this->template->render();
  }
  
  function renderInline(string $menuName = "default"): void {
    $this->baseRender($menuName, "inline");
  }
  
  function renderList(string $menuName = "default"): void {
    $this->baseRender($menuName, "list");
  }
  
  function render(string $menuName = "default"): void {
    $this->renderInline($menuName);
  }
}
?>