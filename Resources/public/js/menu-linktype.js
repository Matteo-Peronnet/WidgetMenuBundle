//Initialization
$vic.each($vic("[id^='victoire_widget_form_menu_items'][id$='linkType']"), function() {
    trackMenuItemTypeChange(this);
});

/**
 * Track the menu item type change to set and display the right value field
 * @param DomElement select The select tag to track
 */
function trackMenuItemTypeChange(select) {
    if($vic(select).val() == 'page') {
        $vic(select).siblings('.page-type').show();
        $vic(select).siblings('.url-type').hide();
    } else if($vic(select).val() == 'url') {
        $vic(select).siblings('.page-type').hide();
        $vic(select).siblings('.url-type').show();
    }
}
