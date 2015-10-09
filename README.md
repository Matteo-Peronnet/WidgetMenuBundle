#Victoire DCMS Menu Bundle
============

This bundle installs the Menu Widget on your Victoire project.
With this widget, you can install a header menu, footer menu, or a menu directly on a page.

The categories can link to :

* Internal pages
* URL
* A routing setting
* An anchor - i.e a widget within a page

##Set Up Victoire

If you haven't already, you can follow the steps to set up Victoire *[here](https://github.com/Victoire/victoire/blob/master/setup.md)*

##Install the Menu Bundle :

Run the following composer command :

    php composer.phar require friendsofvictoire/menu-widget

###Reminder

Do not forget to add the bundle in your AppKernel !

```php
    class AppKernel extends Kernel
    {
        public function registerBundles()
        {
            $bundles = array(
                ...
                new Victoire\Widget\MenuBundle\VictoireWidgetMenuBundle(),
            );

            return $bundles;
        }
    }
```
##Tricks

You can then use this widget menu in any web site. To get a full responsive menu, you can add these lines in your layout :

    <header id="header">
        <nav class="container">
            <div id="header-logo" class="vic-mini-slot">
                {{ cms_slot_widgets('header_logo') }}
            </div>

            <button id="header-links-list-trigger" class="hidden-md hidden-lg"><i class="fa fa-bars"></i></button>

            <div id="header-linkList" class="vic-mini-slot">
                {{ cms_slot_widgets('header_nav') }}
            </div>
        </nav>
    </header>
