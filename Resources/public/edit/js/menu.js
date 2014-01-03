function addSubRow(el, menuId){
    $(el).attr('class', 'disabled');
    var childUl = $('ul#menu-' + menuId);
    $(childUl).show();
    addRow($(childUl).children('a.add_menu_link'));
}
function addRow(el){
    var menu = new Menu(el);
    menu.init();
    menu.append();
}
function deleteRow(el){
    $(el).children('ul').each(function(elem) {
        var menuId = $(elem).attr('id').replace('menu-', '');
        menus[menuId] = undefined;
    });
    if ($(el).parent('span').parent('li').parent('ul').children('li').length === 1) {
        $(el).parent('span').parent('li').parent('ul').html('');
    } else {
        $(el).parent('span').parent('li').remove();
    }
}

function Menu(el)  {
    console.log(el);
    this.el = el;
    this.parentId = parseInt($(el).parents('ul').attr('id').replace('menu-', ''));

    this.item = $(el).parent().children('li').length;
    this.newForm = '';
    var cnt = 0;
    for (var i = 0; i < menus.length; i++) {
        if (menus[i] !== undefined) {
            ++cnt;
        }
    }
    this.id = cnt + 1;
    menus[this.id] = this;
    this.parent = menus[this.parentId];
};
Menu.prototype.init = function()
{
    var currentMenu = this;
    var name = '';
    var i = 0;
    do {
        i++;
        if (currentMenu.parent === undefined) {
            name = '[' + currentMenu.item + ']' + name;
        } else {
            name = '[items][' + currentMenu.item + ']' + name;
        }
        currentMenu = currentMenu.parent;
    } while (currentMenu != null && i < 10);

    var newForm = prototype.replace(/\[__name__\]/g, name);
    newForm = newForm.replace(/__name__/g, name.replace('][', '_').replace('[', '').replace(']', ''));
    this.newForm = newForm.replace(/__menu_id__/g, this.id);
};
Menu.prototype.append = function()
{
    $(this.el).before($('<li></li>').append(this.newForm));
};
