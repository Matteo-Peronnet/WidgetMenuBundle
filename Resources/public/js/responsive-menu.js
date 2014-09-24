$(document).on('click', '#header-links-list-trigger', function(event) {
    $('#header-linkList, .content, #header').toggleClass('is-in');
});

$(document).on('click', '#header-linkList a', function(event) {
    $('#header-linkList, .content, #header').removeClass('is-in');
});
