<?php
declare(strict_types=1);

namespace Nexendrie\Menu;

use Nette\Localization\Translator;

/**
 * Menu
 *
 * @author Jakub Konečný
 */
class Menu extends Collection {
  public string $title = "";
  public string $name;
  public string $htmlId;
  public Translator $translator;
  
  public function __construct(string $name = "default", string $htmlId = "menu") {
    parent::__construct();
    $this->name = $name;
    $this->htmlId = $htmlId;
    $this->translator = new class implements Translator {
      public function translate($message, ... $parameters): string {
        return $message;
      }
    };
  }

  /**
   * @deprecated Access the property directly
   */
  public function getTitle(): string {
    return $this->title;
  }

  /**
   * @deprecated Access the property directly
   */
  public function setTitle(string $title): void {
    $this->title = $title;
  }

  /**
   * @deprecated Access the property directly
   */
  public function getName(): string {
    return $this->name;
  }

  protected function setName(string $name): void {
    $this->name = $name;
  }

  /**
   * @deprecated Access the property directly
   */
  public function getHtmlId(): string {
    return $this->htmlId;
  }

  /**
   * @deprecated Access the property directly
   */
  public function setHtmlId(string $htmlId): void {
    $this->htmlId = $htmlId;
  }

  /**
   * @deprecated Access the property directly
   */
  public function getTranslator(): Translator {
    return $this->translator;
  }

  /**
   * @deprecated Access the property directly
   */
  public function setTranslator(Translator $translator): void {
    $this->translator = $translator;
  }
}
?>