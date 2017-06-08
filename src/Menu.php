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
  
  /** @var MenuItem[] */
  protected $items = [];
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
  
  function __construct(string $name = "default", string $htmlId = "menu") {
    $this->name = $name;
    $this->htmlId = $htmlId;
    $this->translator = new class implements ITranslator {
      function translate($message, $count = NULL): string {
        return $message;
      }
    };
  }
  
  /**
   * @return string
   */
  function getTitle(): string {
    return $this->title;
  }
  
  /**
   * @param string $title
   */
  function setTitle(string $title) {
    $this->title = $title;
  }
  
  /**
   * @return string
   */
  function getName(): string {
    return $this->name;
  }
  
  /**
   * @return string
   */
  function getHtmlId(): string {
    return $this->htmlId;
  }
  
  /**
   * @param string $htmlId
   */
  function setHtmlId(string $htmlId) {
    $this->htmlId = $htmlId;
  }
  
  /**
   * @return ITranslator
   */
  function getTranslator(): ITranslator {
    return $this->translator;
  }
  
  /**
   * @param ITranslator $translator
   */
  function setTranslator(ITranslator $translator) {
    $this->translator = $translator;
  }
  
  /**
   * @return MenuItem[]
   */
  function getAllowedItems(): array {
    $items = [];
    foreach($this->items as $item) {
      if($item->isAllowed()) {
        $items[] = $item;
      }
    }
    return $items;
  }
}
?>