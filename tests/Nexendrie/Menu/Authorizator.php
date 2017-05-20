<?php
declare(strict_types=1);

namespace Nexendrie\Menu;

/**
 * Authorizator
 *
 * @author Jakub Konečný
 */
class Authorizator extends \Nette\Security\Permission {
  function __construct() {
    $this->addRole("guest");
    $this->addRole("abc", "guest");
    $this->addResource("resource");
    $this->allow("guest", "resource", "privilege");
  }
}
?>