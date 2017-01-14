$('[data-confirm]').on('click', function() {
    let message = $(this).data('confirm');
    return confirm(message);
});
