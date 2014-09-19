/*global menus, $ */


function Menu(parent)
{

    this.index = $vic(parent).children('li').length;
    var lastMaxId = 0;
    $vic('[data-menu]').each(function() {
        if (!isNaN($vic(this).attr('data-menu')) && $vic(this).attr('data-menu') > lastMaxId) {
            lastMaxId = parseInt($vic(this).attr('data-menu'));
        }
    });
    this.id = lastMaxId + 1;
    this.parentId = $vic(parent).attr('data-menu');
    //get the parent by its id
    if (this.parentId == null || this.parentId == 0) {
        this.parent = null;
    } else {
        this.parent = menus[this.parentId];
    }

    menus[this.id] = this;

}

function addRootItem(el)
{
    var menuItems = $vic(el).parents('div').first().prev('ul');
    // var parentMenu = $vic('#menu-items');
    var menu = new Menu(menuItems);
    menu.init();
    menu.append();
}
function addRow(el)
{
    var menuItems = $vic(el).parents('div').first().prev('ul');
    // var parentMenu = $vic(el).parents('[role="menu-item"]').first();
    var menu = new Menu(menuItems);
    menu.init();
    menu.append();
}

function deleteRow(el)
{
    var menu = $vic(el).parents('li[role="menu-item"]').first();
    menus[menu.data('menu')] = undefined;
    menu.remove();

}

function initMenus()
{
    var links = $vic('.add_menu_link');
    var menu = null;

    //we want the links from the bottom to the top
    $vic.each(links, function (index, link) {

        var parentMenu = $vic(link).parents('[role="menu-item"]').first();

        var menuItems = $vic(link).parents('div').first().prev('ul');
        menu = new Menu(menuItems);
        //we update the item id with the generated one
        $vic(menuItems).attr('data-menu', menu.id);
        //we update the index of the menu
        // var dataIndex = $vic(parentMenu).attr('data-index');
        // if (dataIndex === undefined) {
        //     menu.index = 0;
        // } else {
        //     menu.index = dataIndex;
        // }
    });

    showSelectedLinkType($vic('.victoire-linkType'));
}

Menu.prototype.init = function ()
{
    var currentMenu = this;
    var name = '';
    var i = 0;
    do {
        i++;
        if (currentMenu.parent == null) {
            name = '[' + currentMenu.index + ']' + name;
        } else {
            name = '[items][' + currentMenu.index + ']' + name;
        }
        currentMenu = currentMenu.parent;
    } while (currentMenu != null && i < 10);

    var newForm = prototype.replace(/\[__name__\]/g, name);
    var name =  name.replace(/\]\[/g, '_');
    var name =  name.replace(/\]/g, '_');
    var name =  name.replace(/\[/g, '_');
    var newForm = newForm.replace(/__name__/g, name);
    var newForm = newForm.replace(/__menu_id__/g, this.id);
    this.newForm = newForm.replace(/__menu_index__/g, this.index);
};

Menu.prototype.append = function ()
{
    console.log(this.parentId);
    $vic('[data-menu="' + this.parentId + '"]').append(this.newForm);
    showSelectedLinkType($vic(this.newForm).find('.victoire-linkType'));
};

