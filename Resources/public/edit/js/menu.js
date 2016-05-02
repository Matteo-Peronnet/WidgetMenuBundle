/*global menus, $ */


function Menu(menuElement)
{
    this.element = $vic(menuElement);
    this.prototypeHtml = $vic(menuElement).parents('div.menus').attr('data-prototype');
    if ($vic(menuElement).data('index')) {
        this.index = $vic(menuElement).data('index');
    } else {
        this.index = $vic(menuElement).children('[data-init="true"]').length;
    }

    var lastMaxId = 0;
    $vic('[data-init=true]').each(function(index, el) {

        if (!isNaN($vic(el).attr('data-menu'))
            && $vic(el).attr('data-menu') > lastMaxId) {
            lastMaxId = parseInt($vic(el).attr('data-menu'));
        }
    });
    this.id = lastMaxId + 1;

    this.parentId =  $vic(menuElement).parents('li[role="menu"]').first().data('menu');
    //get the parent by its id
    if (this.parentId == null || this.parentId == 0) {
        this.parent = null;
        this.parentId = 0;
    } else {
        this.parent = menus[this.parentId];
    }
    menus[this.id] = this;


}

function addRootItem(el)
{
    var menuElement = $vic(el).parents('.vic-add_menu_sibling-Container').first().prev('ul');
    // var parentMenu = $vic('#menu-items');
    var menu = new Menu(menuElement);
    menu.init();
    menu.append();
}
function addRow(el)
{
    var menuElement = $vic(el).parents('.vic-menuform-listitemform').first().siblings('ul');
    var menu = new Menu(menuElement);
    menu.init();
    menu.append();
}

function deleteRow(el)
{
    var menu = $vic(el).parents('li[role="menu"]').first();
    menus[menu.data('menu')] = undefined;
    menu.remove();

}

function initMenus(formSelector)
{
    var links = $vic(formSelector + ' .add_menu_link');
    var menu = {id: 0};

    //we want the links from the bottom to the top
    $vic.each(links, function (index, link) {

        var menuElement = $vic(link).parents('li[role="menu"]').first();
        if (menuElement.length > 0) {
            menu = new Menu(menuElement);

            menu.update();
        }
    });

    //This is exactly the same loop as the one just before
    //We need to close the previous loop and iterate on a new one because
    //we operated on the DOM that is updated only when the loop ends.
    $vic.each(links, function (index, link) {
        var menuElement = $vic(link).parents('li[role="menu"]').first();
        var menu = menus[menuElement.attr('data-menu')];

        var parentMenuElement = $vic(menuElement).parents('li[role="menu"]').first();

        var parentMenu = menus[parentMenuElement.attr('data-menu')];
        if (parentMenu != undefined) {
            menu.parentId = parentMenu.id;
            menu.parent = parentMenu;

            menus[menu.id] = menu;
        }
    });
}

Menu.prototype.init = function ()
{
    var currentMenu = this;
    var name = '[' + currentMenu.index + ']';
    var i = 0;
    do {
        i++;
        if (currentMenu.parent != null) {
            name = '[' + currentMenu.parent.index + '][items]' + name;
        }
        currentMenu = currentMenu.parent;
    } while (currentMenu != null && i < 10);
    var newForm = this.prototypeHtml.replace(/\[__name__\]/g, name);
    var name =  name.replace(/\]\[/g, '_');
    var name =  name.replace(/\]/g, '_');
    var name =  name.replace(/\[/g, '_');
    var newForm = newForm.replace(/__name__/g, name);
    var newForm = newForm.replace(/__menu_id__/g, this.id);
    var newForm = newForm.replace(/__menu_index__/g, this.index);
    this.newForm = $vic.parseHTML(newForm);
    $vic(this.newForm).attr('data-init', "true");
};

Menu.prototype.update = function ()
{
    $vic(this.element).replaceWith(this.element);
    $vic(this.element).attr('data-menu', this.id);
    $vic(this.element).attr('data-init', "true");
};
Menu.prototype.append = function ()
{
    $vic('form[name="' + $vic(this.element).parents('form').attr('name')  + '"]').find('[data-menu="' + this.parentId + '"]').first().find('[role="menu-container"]').first().append(this.newForm);
};
