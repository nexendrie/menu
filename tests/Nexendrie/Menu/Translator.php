<?php
declare(strict_types=1);

namespace Nexendrie\Menu;

use Nette\Localization\ITranslator;

/**
 * Translator
 *
 * @author Jakub Konečný
 */
final class Translator implements ITranslator {
  /**
   * @param string $message
   */
  public function translate($message, ... $parameters): string {
    return "1$message";
  }
}
?>