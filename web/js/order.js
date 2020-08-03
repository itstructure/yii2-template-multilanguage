/**
 * @param id
 * @param count
 */
function putToBasket(id, count) {
    var url = "/ajax/order-ajax/put-to-basket";
    var params = {
        _csrf: window.yii.getCsrfToken(),
        id: id,
        count: count !== undefined ? count : 1
    };
    AJAX(url, 'POST', params, {
        response_json: true,
        func_callback: function (resp) {
            if (resp.meta.status == 'success') {
                $('[role="total_amount"]').html(resp.data.total_amount);
            }
        },
        func_error: function (resp, xhr) {
            console.error(resp.message);
        }
    });
}

/**
 * @param id
 * @param count
 */
function setCountInBasket(id, count) {
    var url = "/ajax/order-ajax/set-count-in-basket";
    var params = {
        _csrf: window.yii.getCsrfToken(),
        id: id,
        count: count
    };
    AJAX(url, 'POST', params, {
        response_json: true,
        func_callback: function (resp) {
            if (resp.meta.status == 'success') {
                $('[role="total_amount"]').html(resp.data.total_amount);
                $('#item_price_'+id).html(resp.data.item_price);
                $('#total_price_'+id).html(parseInt(count)*parseFloat(resp.data.item_price));
            }
        },
        func_error: function (resp, xhr) {
            console.error(resp.message);
        }
    });
}

/**
 * @param id
 */
function removeFromBasket(id) {
    var url = "/ajax/order-ajax/remove-from-basket";
    var params = {
        _csrf: window.yii.getCsrfToken(),
        id: id
    };
    AJAX(url, 'POST', params, {
        response_json: true,
        func_callback: function (resp) {
            if (resp.meta.status == 'success') {
                $('#row_order_'+id).remove();
                $('[role="total_amount"]').html(resp.data.total_amount);
                if (resp.data.total_count == 0) {
                    var send_order_el = $('#send_order_block');
                    if (!send_order_el.hasClass('hidden')) {
                        send_order_el.addClass('hidden');
                    }
                }
            }
        },
        func_error: function (resp, xhr) {
            console.error(resp.message);
        }
    });
}

$(document).ready(function() {

    var sendOrderForm = $('#main_order_form');
    sendOrderForm.on("click", '[role="send"]', function(e) {
        e.preventDefault();
        if (recaptcha_status == 'passive' || recaptcha_status == 'unvalid') {
            var textAlert;
            switch (recaptcha_status) {
                case 'passive':
                    textAlert = window.need_captcha;
                    break;
                case 'unvalid':
                    textAlert = window.error_captcha;
                    break;
            }
            showAlert(sendOrderForm, textAlert, 'danger');
            return;
        }
        closeAlert(sendOrderForm);

        var url = '/ajax/order-ajax/send-order',
            nameBlock = sendOrderForm.find('[role="name"]'),
            emailBlock = sendOrderForm.find('[role="email"]'),
            commentBlock = sendOrderForm.find('[role="comment"]'),
            params = {
                _csrf: window.yii.getCsrfToken(),
                name: nameBlock.val(),
                email: emailBlock.val(),
                comment: commentBlock.val()
            };

        var quantityBlocks = sendOrderForm.find('[role="quantity"]');
        quantityBlocks.each(function () {
            params[$(this)[0].name] = $(this)[0].value;
        });

        AJAX(url, 'POST', params, {
            response_json: true,
            func_waiting: function () {
                showPreloader();
            },
            func_callback: function (resp) {
                hidePreloader();
                if (resp.meta.status == 'success') {

                    sendOrderForm.find('.form-group').each(function () {
                        if ($(this).hasClass('has-error')) {
                            $(this).removeClass('has-error');
                        }
                        $(this).find('.help-block').text('');
                        $(this).find('.form-control').val('');
                    });

                    $('#cart_items').remove();
                    $('#send_order_block').remove();
                    $('[role="total_amount"]').html(0);
                    showAlert(sendOrderForm, resp.meta.message, 'success');

                } else if (resp.meta.status == 'fail') {
                    var errors = resp.data.errors;
                    sendOrderForm.find('.form-group').each(function () {
                        var dataGroup = $(this).attr('data-group');
                        var help_block = $('#help_block_'+dataGroup);
                        if (dataGroup in errors) {
                            if (!$(this).hasClass('has-error')) {
                                $(this).addClass('has-error');
                            }
                            help_block.text(errors[dataGroup][0]);
                        } else {
                            if ($(this).hasClass('has-error')) {
                                $(this).removeClass('has-error');
                            }
                            help_block.text('');
                        }
                    });
                }
            },
            func_error: function (resp) {
                console.log(resp.message);
            }
        });
    });
});

var validateRecaptchaOrder = function () {
    validateRecaptcha({
        func_waiting: function () {

        },
        func_callback_error: function () {
            recaptcha_status = 'unvalid';
        },
        func_callback_success: function () {
            recaptcha_status = 'valid';
        }
    });
};
