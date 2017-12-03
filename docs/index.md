Menu
====

With this package you can create menu(s) for your Nette application.

Links
-----

Primary repository: https://gitlab.com/nexendrie/menu
Github repository: https://github.com/nexendrie/menu
Packagist: https://packagist.org/packages/nexendrie/menu

Installation
------------
The best way to install it is via Composer. Just add **nexendrie/menu** to your dependencies.

Simple usage
------------

Register the extension in your config file

```yaml
extensions:
    menu: Nexendrie\Menu\DI\MenuExtension
```

and define your menu

```yaml
menu:
    default:
        items:
            Test: "Test:"
            New Test: Test:new
```

. This creates menu with 2 items. Format for items is simple: Text: Destination. Destination can be a presenter's action or absolute url (supported protocols are http and https).

Then inject the control to your presenter

```php
class BasePresenter extends \Nette\Application\UI\Presenter {
  /** @var \Nexendrie\Menu\IMenuControlFactory @inject */
  public $menuFactory;
  
  /**
   * @return \Nexendrie\Menu\MenuControl
   */
  protected function createComponentMenu() {
    return $this->menuFactory->create();
  }
}
```

and show it in template

```
{control menu}
```

.

Subitems
--------

Menu items can contain unlimited number (and level) of subitems. They can be defined from neon.

```yaml
menu:
    subitems:
        items:
            Structured:
                link: Test:structured
                items:
                    Subitem: Test:structured
```

Menu types
----------

By default, all items will be printed to a single row. If you prefer your menu being rendered as a list, use this:

```
{control menu:list}
```

. For a list-style menu, you can define title. It will be displayed as heading before the items.

```yaml
menu:
    default:
        title: Menu
        items:
            ...
```

### Custom menu types

It is possible to define custom menu types in MenuControl via method addMenuType. It expects type name and template's filename as arguments.

```php
class BasePresenter extends \Nette\Application\UI\Presenter {
  /** @var \Nexendrie\Menu\IMenuControlFactory @inject */
  public $menuFactory;
  
  /**
   * @return \Nexendrie\Menu\MenuControl
   */
  protected function createComponentMenu() {
    $control = $this->menuFactory->create();
    $control->addMenuType("custom", __DIR__ . "/customMenuTemplate.latte");
    return $control;
  }
}
```

Then you can use it just like the default types.

```
{control menu:custom}
```

Alternatively, you can define new menu types via neon.

```yaml
menu:
    menu_types:
        custom: path/to/template
```

In the template, you have the menu available in variable $menu. Its most notable properties are htmlId, title and allowedItems. Property allowedItems contains only item items for which all conditions to show are met. If you, for whatever reason, need access to all items, just loop over $menu variable. A menu item has properties link, text and allowed.

Multiple menus
--------------

If you want, you can define multiple menus and decide in the template which one you want to show. Just add next section to your config

```yaml
menu:
    default:
        items:
            Test: "Test:"
            New Test: Test:new
    list:
        title: Menu
        items:
            Test: "Test:"
            New Test: Test:new
```

and in template use


```
{control menu list}
```

or

```
{control menu}
```

for default menu.

Translating
-----------

It is possible to have links' text and menu's title translated. Just register your translator to DI and add translate: true to the menu's definition.

```yaml
menu:
    list:
        title: Menu
        translate: true
        items:
            Test: "Test:"
            New Test: Test:new
```

Conditional menu items
----------------------

Sometimes, you want to show certain menu items only if a condition is met. A few condition types are available by default and you can even define custom ones. Examples for default types:

```yaml
menu:
    default:
        items:
            Test: "Test:"
            New Test: Test:new
            Structured:
                link: Test:structured
                conditions:
                    loggedIn: false
                    role: guest
                    acl: resource:privilege
                    callback: some::callback
```

. If multiple conditions are used, ALL must be met else the item will not be shown.

### Custom conditions

You can define custom conditions in neon. Just register them as services:

```yaml
services:
    - App\Menu\CustomCondtion
```

. Then you can use it as any default condition:

```yaml
menu:
    default:
        items:
            Test: "Test:"
            New Test: Test:new
            Structured:
                link: Test:structured
                conditions:
                    custom: NULL
```

.

Classes with conditions have to implement Nexendrie\Menu\IMenuItemCondition interface.

```php
<?php
interface IMenuItemCondition {
  function getName(): string;
  function isAllowed($parameter = NULL): bool;
}
?>
```

Method isAllowed return true if the item should be shown, else false. It accepts one argument. All conditions are registered as services in DI container, so they can depend on other services.

Menu item link rendering
------------------------

Url of link is not created in the template, it is composed by link render. It is a service implementing Nexendrie\Menu\IMenuItemLinkRender interface.

```php
<?php
interface IMenuItemLinkRender {
  public function isApplicable(string $link): bool;
  public function renderLink(string $link): string;
  public function getName(): string;
}
?>
```

By default, there are renders for presenter's action, JavaScript action and absolute url. If you need more types, create your own classes implementing the interface and register them to DI container.
