<?php
declare(strict_types=1);

namespace Nexendrie\Menu\DI;

use Nexendrie\Menu\IMenuControlFactory;
use Nexendrie\Menu\Menu;
use Nette\DI\Config\Helpers;
use Nexendrie\Menu\ConditionUserLoggedIn;
use Nexendrie\Menu\ConditionUserInRole;
use Nexendrie\Menu\ConditionPermission;
use Nexendrie\Menu\ConditionCallback;
use Nexendrie\Menu\LinkRenderPresenterAction;
use Nexendrie\Menu\LinkRenderJavaScriptAction;
use Nexendrie\Menu\LinkRenderUrl;
use Nette\DI\Definitions\FactoryDefinition;

/**
 * MenuExtension
 *
 * @author Jakub Konečný
 */
final class MenuExtension extends \Nette\DI\CompilerExtension {
  public const SERVICE_COMPONENT_FACTORY = "componentFactory";
  public const SERVICE_MENU_FACTORY = "menuFactory";
  public const SECTION_MENU_TYPES = "menu_types";

  private array $defaults = [
    "default" => [],
  ];

  private array $menuDefaults = [
    "title" => "",
    "htmlId" => "menu",
    "translate" => false,
    "items" => [],
  ];
  
  /** @var string[] */
  private array $specialSections = [];
  
  /** @var string[] */
  private array $defaultConditions = [
    "loggedIn" => ConditionUserLoggedIn::class,
    "role" => ConditionUserInRole::class,
    "acl" => ConditionPermission::class,
    "callback" => ConditionCallback::class,
  ];
  
  /** @var string[] */
  private array $linkRenders = [
    "javascript" => LinkRenderJavaScriptAction::class,
    "url" => LinkRenderUrl::class,
    "presenterAction" => LinkRenderPresenterAction::class,
  ];
  
  public function __construct() {
    $this->defaults[static::SECTION_MENU_TYPES] = [
      "inline" => __DIR__ . "/../menuInline.latte",
      "list" => __DIR__ . "/../menuList.latte",
    ];
    $constants = (new \ReflectionClass(static::class))->getConstants();
    foreach($constants as $name => $value) {
      if(str_starts_with($name, "SECTION_")) {
        $this->specialSections[] = $value;
      }
    }
  }

  public function getConfig(): array {
    return Helpers::merge($this->config, $this->defaults);
  }

  public function loadConfiguration(): void {
    $config = $this->getConfig();
    $builder = $this->getContainerBuilder();
    $builder->addFactoryDefinition($this->prefix(static::SERVICE_COMPONENT_FACTORY))
      ->setImplement(IMenuControlFactory::class);
    $builder->addDefinition($this->prefix(static::SERVICE_MENU_FACTORY))
      ->setType(MenuFactory::class)
      ->setAutowired(false);
    foreach($this->defaultConditions as $name => $class) {
      $builder->addDefinition($this->prefix("condition.$name"))
        ->setType($class);
    }
    foreach($this->linkRenders as $name => $class) {
      $builder->addDefinition($this->prefix("linkRender.$name"))
        ->setType($class);
    }
    foreach($config as $name => $menu) {
      if(in_array($name, $this->specialSections, true)) {
        continue;
      }
      /** @var array $data */
      $data = Helpers::merge($menu, $this->menuDefaults);
      $service = $builder->addDefinition($this->prefix($name))
        ->setFactory("@" . $this->prefix(static::SERVICE_MENU_FACTORY) . "::createMenu", [$name, $data])
        ->setAutowired(($name === "default"));
      if($data["translate"]) {
        $service->addSetup("setTranslator");
      }
    }
  }
  
  public function beforeCompile(): void {
    $builder = $this->getContainerBuilder();
    $config = $this->getConfig();
    /** @var FactoryDefinition $control */
    $control = $builder->getDefinition($this->prefix(static::SERVICE_COMPONENT_FACTORY));
    $menus = $builder->findByType(Menu::class);
    foreach($menus as $menuName => $menu) {
      $control->getResultDefinition()->addSetup('?->addMenu(?);', ["@self", "@$menuName"]);
    }
    foreach($config[static::SECTION_MENU_TYPES] as $type => $template) {
      $control->getResultDefinition()->addSetup('?->addMenuType(?,?);', ["@self", $type, $template]);
    }
  }
}
?>