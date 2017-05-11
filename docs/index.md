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

. This creates menu with 2 items. Format for items is simple: Text: Destination. Currently you can only create links to presenters in your application.

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

Menu types
----------

By default, all items will be printed to a single row. If you prefer your menu being rendered as a list, use this:

```
{control menu:list}
```

. For list-style menu you can define title. It will be displayed as heading before the items.

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
    $control->addMenuType("custom", __DIR__ . "");
    return $control;
  }
}
```

Then you can use it just like default types.

```
{control menu:custom}
```

Alternatively, you can define new menu type via neon.

```yaml
menu:
    menu_types:
        custom: path/to/template
```

Multiple menus
--------------

If you want, you can define multiple menus and decide which one you want to show in the template. Just add next section to your config

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