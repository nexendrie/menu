<?php
declare(strict_types=1);

namespace Nexendrie\Menu;

use Nette\Localization\ITranslator;

/**
 * Menu
 *
 * @author Jakub Konečný
 */
class Menu extends Collection {
  public string $title = "";
  public string $name;
  public string $htmlId;
  public ITranslator $translator;
  
  public function __construct(string $name = "default", string $htmlId = "menu") {
    parent::__construct();
    $this->name = $name;
    $this->htmlId = $htmlId;
    $this->translator = new class implements ITranslator {
      public function translate($message, ... $parameters): string {
        return $message;
      }
    };
  }

  /**
   * @internal
   */
  public function setTranslator(ITranslator $translator): void {
    $this->translator = $translator;
  }
}
?>