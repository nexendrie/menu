<?php
declare(strict_types=1);

namespace Nexendrie\Menu;

use Nette\Utils\Strings;

/**
 * BaseLinkRender
 *
 * @author Jakub Konečný
 * @property-read string $name
 */
abstract class BaseLinkRender implements IMenuItemLinkRender {
  use \Nette\SmartObject;

  protected string $name;
  
  public function getName(): string {
    $reflection = new \ReflectionClass($this);
    if($reflection->hasProperty("name")) {
      if(isset($this->name)) {
        return $this->name;
      }
    }
    $class = (string) Strings::after(static::class, "\\", -1);
    if(str_starts_with($class, "LinkRender")) {
      $class = (string) Strings::after($class, "LinkRender");
    }
    return Strings::lower($class);
  }
}
?>