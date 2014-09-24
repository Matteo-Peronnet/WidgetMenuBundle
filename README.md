You can use this widget menu in any web site. To get a full responsive menu, you can add these lines in your layout :

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
