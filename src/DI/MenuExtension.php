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
  /** @var array */
  protected $defaults = [
    "default" => [],
  ];
  
  function loadConfiguration(): void {
    $config = $this->getConfig($this->defaults);
    $builder = $this->getContainerBuilder();
    $builder->addDefinition($this->prefix("component"))
      ->setImplement(IMenuControlFactory::class);
    $items = Helpers::merge($config["default"], []);
    $builder->addDefinition($this->prefix("menu"))
      ->setFactory(self::class . "::createMenu", [$items]);
  }
  
  static function createMenu(array $items): Menu {
    $menu = new Menu;
    foreach($items as $text => $link) {
      $menu[] = new MenuItem($link, $text);
    }
    return $menu;
  }
}
?>