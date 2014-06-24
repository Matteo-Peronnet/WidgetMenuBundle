/*global menus, $ */


function Menu(el)
{
    this.el = el;
    
    var parentEl = $(el).parent().parent().parent('ul').parent().parent().parent().parent('ul');
    
    if (parentEl.length > 0) {
        var parentAttrId = parentEl.attr('id');
        if (parentAttrId === undefined) {
            this.parentId = null;
        } else {
            this.parentId = parseInt(parentAttrId.replace('menu-', ''), 0);
        }
    } else {
        this.parentId = null;
    }

    this.item = $(el).parent().parent().parent('ul').children('div').children('li').children('div').length;
    this.newForm = '';
    
    this.id = this.item;
    
    while (menus[this.id] !== undefined) {
        this.id = this.id + 1;
    }
    
    this.index = this.item;
    
    console.log(this.id);
    console.log(this.parentId);
    
    menus[this.id] = this;
    
    //get the parent by its id
    if (this.parentId === null) {
        this.parent = null;
    } else {
        this.parent = menus[this.parentId];    
    }
}

function addRow(el)
{
    var menu = new Menu(el);
    menu.init();
    menu.append();
}

function deleteRow(el)
{
    $(el).children('ul').each(function (elem) {
        var menuId = $(elem).attr('id').replace('menu-', '');
        menus[menuId] = undefined;
    });
    
    if ($(el).parent('span').parent('div').parent('li').parent('ul').children('li').length === 1) {
        $(el).parent('span').parent('div').parent('li').parent('ul').html('');
    } else {
        $(el).parent('span').parent('div').parent('li').remove();
    }
}

function initMenus()
{
    var links = $('.add_menu_link');
    var menu = null;
    
    //we want the links from the bottom to the top
    $.each(links.get().reverse(), function (index, link) {
        menu = new Menu(link);
        
        //we update the item id with the generated one
        $(link).parent().parent().parent('ul').attr('id', 'menu-' + menu.id);
        //we update the index of the menu
        var dataIndex = $(link).parent().parent().parent('ul').attr('data-index');
        if (dataIndex === undefined) {
            menu.index = 0;
        } else {
            menu.index = dataIndex;
        }
    });
}

Menu.prototype.init = function ()
{
    var currentMenu = this;
    var name = '';
    var i = 0;
    do {
        i++;
        if (currentMenu.parent === null) {
            name = '[' + currentMenu.index + ']' + name;
        } else {
            name = '[items][' + currentMenu.index + ']' + name;
        }
        currentMenu = currentMenu.parent;
    } while (currentMenu !== null && i < 10);

    var newForm = prototype.replace(/\[__name__\]/g, name);
    newForm = newForm.replace(/__name__/g, name.replace('][', '_').replace('[', '').replace(']', ''));
    this.newForm = newForm.replace(/__menu_id__/g, this.id);
};

Menu.prototype.append = function ()
{
    $(this.el).parent('span').parent('div').parent('ul').children().first().append('<li>' + this.newForm + '</li>');
};

