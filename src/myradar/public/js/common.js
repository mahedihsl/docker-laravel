function showToastMessage() {
    var source = $('input[name="toast"]');

    var toast_msg = source.val();
    var toast_type = parseInt(source.data('type'));

    if (toast_msg) {
        if (toast_type == 1) {
            toastr.success(toast_msg);
        } else if (toast_type == 2) {
            toastr.warning(toast_msg);
        } else {
            toastr.error(toast_msg);
        }
    }
}

$(function () {
    $('[data-real]').each(function (i) {
        $(this).val($(this).data('real'));
    });

    $('#nv-profile').click(function () {
        $(this).parent().toggleClass('open');
    });
    
    $('button.confirm').click(function() {
        var message = 'Are you sure you want to proceed ?'
        if (confirm(message)) {
            var parent = $(this).parent('form');
            console.log('checking parent of confirm button', parent)
            if (parent.is('form')) {
                parent.submit();
            }
        }
    })

    showToastMessage();
});
