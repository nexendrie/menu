<?php
declare(strict_types=1);

namespace Nexendrie\Menu;

use Nette\Utils\Arrays,
    Nette\Utils\Strings;

/**
 * MenuControl
 *
 * @author Jakub Konečný
 * @method void render(string $menuName = "default")
 * @method void renderInline(string $menuName = "default")
 * @method void renderList(string $menuName = "default")
 */
class MenuControl extends \Nette\Application\UI\Control {
  /** @var Menu[] */
  protected $menus = [];
  /** @var array */
  protected $templates = [
    "inline" => __DIR__ . "/menuInline.latte",
    "list" => __DIR__ . "/menuList.latte",
  ];
  
  function addMenu(Menu $menu): void {
    $this->menus[$menu->name] = & $menu;
  }
  
  /**
   * @param string $menuName
   * @return Menu
   * @throws MenuNotFoundException
   */
  protected function getMenu(string $menuName): Menu {
    foreach($this->menus as $name => $menu) {
      if($name === $menuName) {
        return $menu;
      }
    }
    throw new MenuNotFoundException("Menu $menuName not found.");
  }
  
  /**
   * @param string $menuType
   * @return string
   * @throws MenuTypeNotSupportedException
   */
  protected function getTemplateFilename(string $menuType): string {
    $filename = Arrays::get($this->templates, $menuType, "");
    if($filename === "") {
      throw new MenuTypeNotSupportedException("Menu type $menuType is not supported.");
    } else {
      return $filename;
    }
  }
  
  /**
   * @param string $menuName
   * @param string $menuType
   * @return void
   * @throws MenuNotFoundException
   * @throws MenuTypeNotSupportedException
   */
  protected function baseRender(string $menuName, string $menuType): void {
    try {
      $menu = $this->getMenu($menuName);
      $templateFile = $this->getTemplateFilename($menuType);
    } catch(MenuNotFoundException | MenuTypeNotSupportedException $e) {
      throw $e;
    }
    $this->template->setFile($templateFile);
    $this->template->menu = $menu;
    $this->template->render();
  }
  
  function __call($name, $args) {
    if($name === "render") {
      $name = "renderInline";
    }
    if(Strings::startsWith($name, "render")) {
      $render = Strings::firstLower(Strings::after($name, "render"));
      $menuName = Arrays::get($args, 0, "default");
      $this->baseRender($menuName, $render);
      return;
    }
    return parent::__call($name, $args);
  }
}
?>