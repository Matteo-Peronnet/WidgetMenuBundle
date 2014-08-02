$vic(document).on('change', $vic("[id$='linkType']"), function(el) {
    var select = el.target;

    if($vic(select).val() == 'page') {
        $vic(select).siblings('.page-type').show();
        $vic(select).siblings('.url-type').hide();
    } else if($vic(select).val() == 'url') {
        $vic(select).siblings('.page-type').hide();
        $vic(select).siblings('.url-type').show();
    }
});
