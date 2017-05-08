<?php
declare(strict_types=1);

namespace Nexendrie\Menu\DI;

use Nexendrie\Menu\IMenuControlFactory;

/**
 * MenuTypesExtension
 *
 * @author Jakub Konečný
 */
class MenuTypesExtension extends \Nette\DI\CompilerExtension {
  function beforeCompile(): void {
    $builder = $this->getContainerBuilder();
    $config = $this->getConfig();
    $component = $builder->getDefinitionByType(IMenuControlFactory::class);
    foreach($config as $type => $template) {
      $component->addSetup('?->addMenuType(?,?);', ["@self", $type, $template]);
    }
  }
}
?>