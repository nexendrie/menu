<?php
declare(strict_types=1);

namespace Nexendrie\Menu\DI;

use Nexendrie\Menu\IMenuControlFactory,
    Nexendrie\Menu\Menu,
    Nette\DI\Config\Helpers,
    Nexendrie\Menu\ConditionUserLoggedIn,
    Nexendrie\Menu\ConditionUserInRole,
    Nexendrie\Menu\ConditionPermission,
    Nexendrie\Menu\ConditionCallback;

/**
 * MenuExtension
 *
 * @author Jakub Konečný
 */
class MenuExtension extends \Nette\DI\CompilerExtension {
  const COMPONENT_SERVICE = "componentFactory";
  const MENU_FACTORY_SERVICE = "menuFactory";
  const MENU_TYPES_SECTION = "menu_types";
  const CONDITIONS_SECTION = "conditions";
  
  /** @var array */
  protected $defaults = [
    "default" => [],
  ];
  
  /**
   * @var array
   */
  protected $menuDefaults = [
    "title" => "",
    "htmlId" => "menu",
    "translate" => false,
    "items" => [],
  ];
  
  /** @var string[] */
  protected $specialSections = [];
  
  function __construct() {
    $this->defaults[static::MENU_TYPES_SECTION] = [
      "inline" => __DIR__ . "/../menuInline.latte",
      "list" => __DIR__ . "/../menuList.latte",
    ];
    $this->defaults[static::CONDITIONS_SECTION] = [
      "loggedIn" => ConditionUserLoggedIn::class,
      "role" => ConditionUserInRole::class,
      "acl" => ConditionPermission::class,
      "callback" => ConditionCallback::class,
    ];
    $this->specialSections = [
      static::MENU_TYPES_SECTION, static::CONDITIONS_SECTION,
    ];
  }
  
  function loadConfiguration(): void {
    $config = $this->getConfig($this->defaults);
    $builder = $this->getContainerBuilder();
    $builder->addDefinition($this->prefix(static::COMPONENT_SERVICE))
      ->setImplement(IMenuControlFactory::class);
    $builder->addDefinition($this->prefix(static::MENU_FACTORY_SERVICE))
      ->setFactory(MenuFactory::class, [$config[static::CONDITIONS_SECTION]]);
    foreach($config[static::CONDITIONS_SECTION] as $name => $class) {
      $builder->addDefinition($this->prefix("condition.$name"))
        ->setClass($class);
    }
    foreach($config as $name => $menu) {
      if(in_array($name, $this->specialSections)) {
        continue;
      }
      $data = Helpers::merge($menu, $this->menuDefaults);
      $service = $builder->addDefinition($this->prefix($name))
        ->setFactory("@" . MenuFactory::class . "::createMenu", [$name, $data, $config[static::CONDITIONS_SECTION]])
        ->setAutowired(($name === "default"));
      if($data["translate"]) {
        $service->addSetup("setTranslator");
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
}
?>