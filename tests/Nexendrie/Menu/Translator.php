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
  public function translate($message, $count = null): string {
    return "1$message";
  }
}
?>