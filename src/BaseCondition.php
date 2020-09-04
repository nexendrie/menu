<?php
declare(strict_types=1);

namespace Nexendrie\Menu;

use Nette\Utils\Strings;

/**
 * BaseCondition
 *
 * @author Jakub Konečný
 * @property-read string $name
 */
abstract class BaseCondition implements IMenuItemCondition {
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
    if(str_starts_with($class, "Condition")) {
      $class = (string) Strings::after($class, "Condition");
    }
    return Strings::lower($class);
  }
}
?>