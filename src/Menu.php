<?php
declare(strict_types=1);

namespace Nexendrie\Menu;

use Nette\Localization\ITranslator,
    Nexendrie\Utils\Collection;

/**
 * Menu
 *
 * @author Jakub Konečný
 * @property string $title
 * @property-read string $name
 * @property string $htmlId
 * @property ITranslator $translator
 * @property-read MenuItem[] $allowedItems
 */
class Menu extends Collection {
  use \Nette\SmartObject;
  
  /** @var string */
  protected $class = MenuItem::class;
  /** @var string */
  protected $title = "";
  /** @var string */
  protected $name;
  /** @var string*/
  protected $htmlId;
  /** @var ITranslator */
  protected $translator;
  
  public function __construct(string $name = "default", string $htmlId = "menu") {
    $this->name = $name;
    $this->htmlId = $htmlId;
    $this->translator = new class implements ITranslator {
      public function translate($message, $count = NULL): string {
        return $message;
      }
    };
  }
  
  public function getTitle(): string {
    return $this->title;
  }
  
  public function setTitle(string $title) {
    $this->title = $title;
  }
  
  public function getName(): string {
    return $this->name;
  }
  
  public function getHtmlId(): string {
    return $this->htmlId;
  }
  
  public function setHtmlId(string $htmlId) {
    $this->htmlId = $htmlId;
  }
  
  public function getTranslator(): ITranslator {
    return $this->translator;
  }
  
  public function setTranslator(ITranslator $translator) {
    $this->translator = $translator;
  }
  
  /**
   * @return MenuItem[]
   */
  public function getAllowedItems(): array {
    return array_values(array_filter($this->items, function(MenuItem $item) {
      return $item->isAllowed();
    }));
  }
}
?>