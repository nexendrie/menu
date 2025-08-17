<?php
declare(strict_types=1);

namespace Nexendrie\Menu;

/**
 * Translator
 *
 * @author Jakub Konečný
 */
final class Translator implements \Nette\Localization\Translator {
  /**
   * @param string $message
   */
  public function translate($message, ... $parameters): string {
    return "1$message";
  }
}
?>