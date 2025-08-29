<?php
declare(strict_types=1);

namespace Nexendrie\Menu;

/**
 * Menu item
 *
 * @author Jakub Konečný
 * @property string $link
 * @property-read bool $allowed
 */
class MenuItem extends Collection
{
    protected string $link;
    public string $rawLink;
    /** @var array[] of [IMenuItemCondition, string] */
    protected array $conditions = [];
    /** @var IMenuItemLinkRender[] */
    protected array $linkRenders = [];

    public function __construct(string $link, public string $text)
    {
        parent::__construct();
        $this->setRawLink($link);
    }

    /**
     * @deprecated Access the property directly
     */
    public function getLink(): string
    {
        $link = $this->rawLink;
        foreach ($this->linkRenders as $render) {
            if ($render->isApplicable($link)) {
                $link = $render->renderLink($link);
                break;
            }
        }
        return $link;
    }

    /**
     * @deprecated Access the property directly
     */
    public function setLink(string $link): void
    {
        $this->setRawLink($link);
    }

    /**
     * @deprecated Access the property directly
     */
    public function getRawLink(): string
    {
        return $this->link;
    }

    protected function setRawLink(string $rawLink): void
    {
        $this->rawLink = $this->link = $rawLink;
    }

    /**
     * @deprecated Access the property directly
     */
    public function getText(): string
    {
        return $this->text;
    }

    /**
     * @deprecated Access the property directly
     */
    public function setText(string $text): void
    {
        $this->text = $text;
    }

    /**
     * @param mixed $parameter
     */
    public function addCondition(IMenuItemCondition $condition, $parameter): void
    {
        $this->conditions[$condition->getName()] = [$condition, $parameter];
    }

    public function addLinkRender(IMenuItemLinkRender $render): void
    {
        $this->linkRenders[$render->getName()] = $render;
    }

    /**
     * @deprecated Access the property directly
     */
    public function isAllowed(): bool
    {
        foreach ($this->conditions as $condition) {
            if (!$condition[0]->isAllowed($condition[1])) {
                return false;
            }
        }
        return true;
    }
}
