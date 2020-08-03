$(document).ready(function() {

    var feedbackBlock = $('#feedback');
    feedbackBlock.on("click", '[role="send"]', function(e) {
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
            showAlert(feedbackBlock, textAlert, 'danger');
            return;
        }
        closeAlert(feedbackBlock);

        var url = '/ajax/feedback-ajax/send',
            nameBlock = feedbackBlock.find('[role="name"]'),
            emailBlock = feedbackBlock.find('[role="email"]'),
            subjectBlock = feedbackBlock.find('[role="subject"]'),
            messageBlock = feedbackBlock.find('[role="message"]'),
            params = {
                _csrf: window.yii.getCsrfToken(),
                name: nameBlock.val(),
                email: emailBlock.val(),
                subject: subjectBlock.val(),
                message: messageBlock.val()//,
                //short_language: window.short_language
            };

        AJAX(url, 'POST', params, {
            response_json: true,
            func_waiting: function () {
                showPreloader();
            },
            func_callback: function (resp) {
                hidePreloader();
                if (resp.meta.status == 'success') {

                    feedbackBlock.find('.form-group').each(function () {
                        if ($(this).hasClass('has-error')) {
                            $(this).removeClass('has-error');
                        }
                        $(this).find('.help-block').text('');
                        $(this).find('.form-control').val('');
                    });

                    showAlert(feedbackBlock, window.sent_message, 'success');
                    setTimeout(function () {
                        closeAlert(feedbackBlock);
                        grecaptcha_reset();
                        recaptcha_status = 'passive';
                    }, 3000);

                } else if (resp.meta.status == 'fail') {
                    var errors = resp.data.errors;
                    feedbackBlock.find('.form-group').each(function () {
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

var validateRecaptchaFeedback = function () {
    validateRecaptcha({
        func_waiting: function () {
            showPreloader();
        },
        func_callback_error: function () {
            hidePreloader();
            recaptcha_status = 'unvalid';
        },
        func_callback_success: function () {
            hidePreloader();
            recaptcha_status = 'valid';
            closeAlert($('#feedback'));
        }
    });
};