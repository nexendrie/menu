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
   * Register new menu type
   * Also creates new virtual method renderName
   *
   * @param string $name
   * @param string $template
   * @return void
   * @throws MenuTypeAlreadyDefinedException
   * @throws TemplateNotFoundException
   */
  function addMenuType(string $name, string $template): void {
    if(array_key_exists($name, $this->templates)) {
      throw new MenuTypeAlreadyDefinedException("Menu type $name is already defined");
    }
    if(!file_exists($template)) {
      throw new TemplateNotFoundException("File $template does not exist.");
    }
    $this->templates[$name] = realpath($template);
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
   * Returns filename of template for a menu type
   *
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
   * Contains all logic for rendering the component
   *
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
  
  /**
   * Defines virtual methods for rendering menu types
   * renderAbc will try to render menu of abc type
   * Anything that does not start with render is handled by \Nette\SmartObject
   *
   * @param $name
   * @param $args
   * @return mixed
   */
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