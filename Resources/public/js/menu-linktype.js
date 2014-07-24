$(document).on('change', $("[id$='linkType']"), function(el) {
    console.log(1);
    if($(el).val() == 'page') {
        $(el).siblings('.page-type').show();
        $(el).siblings('.link-type').hide();
    } else {
        console.log($(el));
        $(el).siblings('.page-type').hide();
        $(el).siblings('.link-type').show();
    }
});