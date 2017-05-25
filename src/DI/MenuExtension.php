<?php
declare(strict_types=1);

namespace Nexendrie\Menu\DI;

use Nexendrie\Menu\IMenuControlFactory,
    Nexendrie\Menu\Menu,
    Nette\DI\Config\Helpers,
    Nexendrie\Menu\ConditionUserLoggedIn,
    Nexendrie\Menu\ConditionUserInRole,
    Nexendrie\Menu\ConditionPermission,
    Nexendrie\Menu\ConditionCallback,
    Nette\Reflection\ClassType,
    Nette\Utils\Strings;

/**
 * MenuExtension
 *
 * @author Jakub Konečný
 */
class MenuExtension extends \Nette\DI\CompilerExtension {
  const SERVICE_COMPONENT_FACTORY = "componentFactory";
  const SERVICE_MENU_FACTORY = "menuFactory";
  const SECTION_MENU_TYPES = "menu_types";
  const SECTION_CONDITIONS = "conditions";
  
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
  
  /** @var string[] */
  protected $defaultConditions = [
    "loggedIn" => ConditionUserLoggedIn::class,
    "role" => ConditionUserInRole::class,
    "acl" => ConditionPermission::class,
    "callback" => ConditionCallback::class,
  ];
  
  function __construct() {
    $this->defaults[static::SECTION_MENU_TYPES] = [
      "inline" => __DIR__ . "/../menuInline.latte",
      "list" => __DIR__ . "/../menuList.latte",
    ];
    $this->defaults[static::SECTION_CONDITIONS] = [];
    $constants = (new ClassType(static::class))->constants;
    foreach($constants as $name => $value) {
      if(Strings::startsWith($name, "SECTION_")) {
        $this->specialSections[] = $value;
      }
    }
  }
  
  function loadConfiguration(): void {
    $config = $this->getConfig($this->defaults);
    $builder = $this->getContainerBuilder();
    $builder->addDefinition($this->prefix(static::SERVICE_COMPONENT_FACTORY))
      ->setImplement(IMenuControlFactory::class);
    $builder->addDefinition($this->prefix(static::SERVICE_MENU_FACTORY))
      ->setFactory(MenuFactory::class, [$config[static::SECTION_CONDITIONS]]);
    foreach($config[static::SECTION_CONDITIONS] as $name => $class) {
      $builder->addDefinition($this->prefix("condition.$name"))
        ->setClass($class);
    }
    foreach($this->defaultConditions as $name => $class) {
      $builder->addDefinition($this->prefix("condition.$name"))
        ->setClass($class);
    }
    foreach($config as $name => $menu) {
      if(in_array($name, $this->specialSections)) {
        continue;
      }
      $data = Helpers::merge($menu, $this->menuDefaults);
      $service = $builder->addDefinition($this->prefix($name))
        ->setFactory("@" . MenuFactory::class . "::createMenu", [$name, $data])
        ->setAutowired(($name === "default"));
      if($data["translate"]) {
        $service->addSetup("setTranslator");
      }
    }
  }
  
  function beforeCompile(): void {
    $builder = $this->getContainerBuilder();
    $config = $this->getConfig($this->defaults);
    $control = $builder->getDefinition($this->prefix(static::SERVICE_COMPONENT_FACTORY));
    $menus = $builder->findByType(Menu::class);
    foreach($menus as $menuName => $menu) {
      $control->addSetup('?->addMenu(?);', ["@self", "@$menuName"]);
    }
    foreach($config[static::SECTION_MENU_TYPES] as $type => $template) {
      $control->addSetup('?->addMenuType(?,?);', ["@self", $type, $template]);
    }
  }
}
?>