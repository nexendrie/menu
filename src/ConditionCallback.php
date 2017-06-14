<?php
declare(strict_types=1);

namespace Nexendrie\Menu;

/**
 * ConditionCallback
 *
 * @author Jakub Konečný
 */
class ConditionCallback implements IMenuItemCondition {
  use \Nette\SmartObject;
  
  /** @var string */
  protected $name = "callback";
  
  /**
   * @return string
   */
  function getName(): string {
    return $this->name;
  }
  
  /**
   * @param callable $parameter
   * @return bool
   * @throws \InvalidArgumentException
   * @throws \UnexpectedValueException
   */
  function isAllowed($parameter = NULL): bool {
    if(!is_callable($parameter)) {
      throw new \InvalidArgumentException("Method " . static::class . "::isAllowed expects callback as parameter.");
    }
    $result = call_user_func($parameter);
    if(!is_bool($result)) {
      throw new \UnexpectedValueException("The callback for method " . static::class . "::isAllowed has to return boolean, " . gettype($result) . " returned.");
    }
    return $result;
  }
}
?>