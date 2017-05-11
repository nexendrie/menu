<?php
declare(strict_types=1);

namespace Nexendrie\Menu;

use Nette\Localization\ITranslator;

/**
 * Translator
 *
 * @author Jakub Konečný
 */
class Translator implements ITranslator {
  function translate($message, $count = NULL): string {
    return "1$message";
  }
}
?>