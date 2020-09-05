Version 2.4.0
- raised minimal version of PHP to 7.4
- used typed properties (possible BC break)

Version 2.3.0
- raised minimal version of PHP to 7.3
- deprecated getters and setters of Collection, Menu and MenuItem
- made Menu::$name writable
- MenuItem::$link is deprecated for raw link, use MenuItem::$rawLink instead

Version 2.2.1
- re-added support for Latte 2.5

Version 2.2.0
- dropped support for Nette 2.4

Version 2.1.0
- added property MenuItem::$rawLink
- raised minimal version of PHP to 7.2

Version 2.0.0
- removed support for section menu.conditions
- marked some classes as final
- introduced menu item link renders
- allowed absolute urls as link target
- added support for subitems

Version 1.2.2
- code cleaning
- fixed some exception messages
- removed indirect dependency on nette/reflection

Version 1.2.1
- removed build.xml from releases
- deprecated constant MenuExtension::SECTION_CONDITIONS (was forgotten in 1.1.0)

Version 1.2.0
- added virtual property Menu::$allowedItems
- added dependency on nexendrie/utils
- added BaseCondition

Version 1.1.0
- menu item conditions can be manually registered as services now
- deprecated section menu.conditions
- MenuFactory is not autowired anymore

Version 1.0.0
- added conditional menu items
- menus are now created by a factory (in DIC extension)
- renamed constants in MenuExtension

Version 0.3.0
- it is possible to define new menu types from neon
- added support for translating

Version 0.2.0
- allowed setting menu's html id
- menu type's is now determined in template, see documentation
- changed thrown exceptions
- added support for custom menu types

Version 0.1.0
- first version
