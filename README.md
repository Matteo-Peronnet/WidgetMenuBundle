Victoire Menu Bundle
============

Need to add a menu in a victoire website ?
Get this listing bundle and so on

First you need to have a valid Symfony2 Victoire edition.
Then you just have to run the following composer command :

    php composer.phar require friendsofvictoire/menu-widget

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
