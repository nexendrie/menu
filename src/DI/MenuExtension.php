<?php
declare(strict_types=1);

namespace Nexendrie\Menu\DI;

use Nexendrie\Menu\IMenuControlFactory,
    Nexendrie\Menu\Menu,
    Nexendrie\Menu\MenuItem,
    Nette\DI\Config\Helpers;

/**
 * MenuExtension
 *
 * @author Jakub Konečný
 */
class MenuExtension extends \Nette\DI\CompilerExtension {
  const COMPONENT_SERVICE = "componentFactory";
  const MENU_TYPES_SECTION = "menu_types";
  
  /** @var array */
  protected $defaults = [
    "default" => [],
  ];
  
  protected $menuDefaults = [
    "title" => "",
    "htmlId" => "menu",
    "translate" => false,
    "items" => [],
  ];
  
  function __construct() {
    $this->defaults[static::MENU_TYPES_SECTION] = [
      "inline" => __DIR__ . "/../menuInline.latte",
      "list" => __DIR__ . "/../menuList.latte",
    ];
  }
  
  function loadConfiguration(): void {
    $config = $this->getConfig($this->defaults);
    $builder = $this->getContainerBuilder();
    $builder->addDefinition($this->prefix(static::COMPONENT_SERVICE))
      ->setImplement(IMenuControlFactory::class);
    foreach($config as $name => $menu) {
      if($name === static::MENU_TYPES_SECTION) {
        continue;
      }
      $data = Helpers::merge($menu, $this->menuDefaults);
      $builder->addDefinition($this->prefix($name))
        ->setFactory(self::class . "::createMenu", [$name, $data])
        ->setAutowired(($name === "default"));
      if($data["translate"]) {
        $builder->getDefinition($this->prefix($name))
          ->addSetup("setTranslator");
      }
    }
  }
  
  function beforeCompile(): void {
    $builder = $this->getContainerBuilder();
    $config = $this->getConfig($this->defaults);
    $control = $builder->getDefinition($this->prefix(static::COMPONENT_SERVICE));
    $menus = $builder->findByType(Menu::class);
    foreach($menus as $menuName => $menu) {
      $control->addSetup('?->addMenu(?);', ["@self", "@$menuName"]);
    }
    foreach($config[static::MENU_TYPES_SECTION] as $type => $template) {
      $control->addSetup('?->addMenuType(?,?);', ["@self", $type, $template]);
    }
  }
  
  static function createMenu(string $name, array $config): Menu {
    $menu = new Menu($name, $config["htmlId"]);
    $menu->title = $config["title"];
    foreach($config["items"] as $text => $link) {
      $menu[] = new MenuItem($link, $text);
    }
    return $menu;
  }
}
?>