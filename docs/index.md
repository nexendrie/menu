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

```
extensions:
    menu: Nexendrie\Menu\DI\MenuExtension
```

and define your menu

```
menu:
    default:
        items:
            Test: "Test:"
            New Test: Test:new
```

. This creates menu with 2 items. Format for items is simple: Links's title: Destination. Currently you can only create links to presenters in your application.

Then inject the control to your presenter

```
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
menu:
    default:
        type: list
        items:
            ...
```

. For list-style menu you can define title. It will be displayed as heading before the items.

```
menu:
    default:
        type: list
        title: Menu
        items:
            ...
```

Multiple menus
--------------

If you want, you can define multiple menus and decide which one you want to show in the template. Just add next section to your config

```
menu:
    default:
        items:
            Test: "Test:"
            New Test: Test:new
    list:
        title: Menu
        type: list
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