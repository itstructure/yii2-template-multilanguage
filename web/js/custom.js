
// ISOTOPE FILTER
jQuery(document).ready(function($){

  if ( $('.iso-box-wrapper').length > 0 ) { 

      var $container  = $('.iso-box-wrapper'), 
        $imgs     = $('.iso-box img');

      $container.imagesLoaded(function () {

        $container.isotope({
        layoutMode: 'fitRows',
        itemSelector: '.iso-box'
        });

        $imgs.load(function(){
          $container.isotope('reLayout');
        })

      });

      //filter items on button click

      $('.filter-wrapper li a').click(function(){

          var $this = $(this), filterValue = $this.attr('data-filter');

      $container.isotope({ 
        filter: filterValue,
        animationOptions: { 
            duration: 750, 
            easing: 'linear', 
            queue: false, 
        }                
      });             

      // don't proceed if already selected 

      if ( $this.hasClass('selected') ) { 
        return false; 
      }

      var filter_wrapper = $this.closest('.filter-wrapper');
      filter_wrapper.find('.selected').removeClass('selected');
      $this.addClass('selected');

        return false;
      }); 

  }

});

// jQuery to collapse the navbar on scroll //
$(window).scroll(function() {
    if ($(".navbar").offset().top > 50) {
        $(".navbar-fixed-top").addClass("top-nav-collapse");
    } else {
        $(".navbar-fixed-top").removeClass("top-nav-collapse");
    }
});

/* HTML document is loaded. DOM is ready. 
-------------------------------------------*/
$(function(){

  // ------- WOW ANIMATED ------ //
  wow = new WOW(
  {
    mobile: false
  });
  wow.init();

  // HIDE MOBILE MENU AFTER CLIKING ON A LINK
  $('.navbar-collapse a').click(function(){
        $(".navbar-collapse").collapse('hide');
    });

  // NIVO LIGHTBOX
  $('.iso-box-section a').nivoLightbox({
        effect: 'fadeScale',
    });

});

/**
 * Serialize object to string.
 *
 * @param   {object} obj    - Object incoming
 * @returns {string}        - Object as Get params string
 */
function serializeParams(obj) {
    return Object.keys(obj).reduce(function(a,k) {a.push(k+'='+encodeURIComponent(obj[k]));return a},[]).join('&');
}

/**
 * AJAX function.
 *
 * @param {string} url     - Request URL
 * @param {string} method  - Request type ('post' || 'get')
 * @param {object} params  - Object with params (for files { name: 'sasha' (sended to $_POST[]), files: { custom_filename: element.files[0] } (sended to $_FILES[]))
 * @param {object} options - Object with options. Available options:
 *     response_json{bool} - Type of response (JSON or not)
 *     func_waiting{func}  - Function while waiting
 *     func_callback{func} - Function on success result
 *     func_error{func}    - Function on error result
 *     func_progress{func} - Function on uploading progress
 */
function AJAX(url, method, params, options) {
    var xhr = null;

    try { // For: chrome, firefox, safari, opera, yandex, ...
        xhr = new XMLHttpRequest();
    } catch(e) {
        try { // For: IE6+
            xhr = new ActiveXObject("Microsoft.XMLHTTP");
        } catch(e1) { // if JS not supported or disabled
            console.log("Browser Not supported!");
            return;
        }
    }

    xhr.onreadystatechange = function() {

        // ready states:
        // 0: uninitialized
        // 1: loading
        // 2: loaded
        // 3: interactive
        // 4: complete

        if (xhr.readyState == 4) { // when result is ready

            var response_text = xhr.responseText;

            if ('response_json' in options && options.response_json) {
                try {
                    response_text = JSON.parse(response_text);
                } catch (e) { }
            }

            if (xhr.status === 200) { // on success
                if ('func_callback' in options && typeof options.func_callback == 'function') {
                    var fc = options.func_callback;
                    fc(response_text);
                }
            } else { // on error
                console.log(xhr.status + ': ' + xhr.statusText);
                if ('func_error' in options && typeof options.func_error == 'function') {
                    var fe = options.func_error;
                    fe(response_text, xhr);
                }
            }
        } else { // waiting for result
            if ('func_waiting' in options && typeof options.func_waiting == 'function') {
                var fw = options.func_waiting;
                fw();
            }
        }
    };

    var data = null;

    if (params.files) {
        method = 'POST';

        data = new FormData();
        for (var index_param in params) {
            if (typeof params[index_param] == 'object') {
                for (var index_file in params[index_param]) {
                    data.append(index_file, params[index_param][index_file]);
                }
            } else {
                data.append(index_param, params[index_param]);
            }
        }

        if ('func_progress' in options && typeof options.func_progress == 'function') {
            xhr.upload.onprogress = function(event) {
                // 'progress: ' + event.loaded + ' / ' + event.total;
                var fp = options.func_progress;
                fp(event);
            }
        }
    } else {
        data = serializeParams(params);
    }

    method = method.toUpperCase();

    if (method == 'GET' && data) {
        url += '?' + data;
    }

    xhr.open(method, url, true);

    if ( ! params.files) {
        xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    }

    xhr.setRequestHeader("X-Requested-With", "XMLHttpRequest");
    xhr.send(data);
}

/**
 * Add cross browser event to DOM element
 *
 * @param {object} element			- Element for adding event
 * @param {string} event_name   	- Event name
 * @param {function} event_handler	- Event handler
 */
function addEvent(element, event_name, event_handler) {
    if (event_name == 'ready') {
        if (document.addEventListener) {
            document.addEventListener("DOMContentLoaded", event_handler, false);
        } else if (document.attachEvent) {
            document.attachEvent("onreadystatechange", function() {
                if (document.readyState === "complete" ) {
                    event_handler();
                }
            });
        }
    } else {
        if (element.addEventListener) {
            element.addEventListener(event_name, event_handler, false);
        } else if (element.attachEvent) {
            element.attachEvent('on' + event_name, event_handler);
        }
    }
}

// FEEDBACK

var recaptcha_status = 'passive';

$(document).ready(function() {
    /**
     * Single upload file.
     */
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
                message: messageBlock.val(),
                short_language: window.short_language
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

/**
 * @param {element} parentBlock
 * @param {string} textAlert
 * @param {string} status
 *      success
 *      info
 *      warning
 *      danger
 */
function showAlert(parentBlock, textAlert, status) {
    var possibleStatuses = [
        'success',
        'info',
        'warning',
        'danger'
    ];
    var alertBlock = parentBlock.find('[role="alert"]');
    if (alertBlock.hasClass('nodisplay')) {
        alertBlock.removeClass('nodisplay');
    }
    if (!alertBlock.hasClass('display')) {
        alertBlock.addClass('display');
    }
    for (var i = 0; i < possibleStatuses.length; i++) {
        if (status != possibleStatuses[i]) {
            if (alertBlock.hasClass('alert-'+possibleStatuses[i])) {
                alertBlock.removeClass('alert-'+possibleStatuses[i]);
            }
        } else {
            if (!alertBlock.hasClass('alert-'+status)) {
                alertBlock.addClass('alert-'+status);
            }
        }
    }
    alertBlock.text(textAlert);
}

/**
 * @param parentBlock
 */
function closeAlert(parentBlock) {
    var possibleStatuses = [
        'success',
        'info',
        'warning',
        'danger'
    ];
    var alertBlock = parentBlock.find('[role="alert"]');
    if (alertBlock.hasClass('display')) {
        alertBlock.removeClass('display');
    }
    if (!alertBlock.hasClass('nodisplay')) {
        alertBlock.addClass('nodisplay');
    }
    for (var i = 0; i < possibleStatuses.length; i++) {
        if (alertBlock.hasClass('alert-'+possibleStatuses[i])) {
            alertBlock.removeClass('alert-'+possibleStatuses[i]);
        }
    }
    alertBlock.text('');
}

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

// CAPTCHA

function grecaptcha_reset() {
    grecaptcha.reset();
}

function grecaptcha_execute() {
    grecaptcha.execute();
}

/**
 * Validate recaptcha, using ajax request to the google recaptcha service.
 *
 * @param callbacks
 *     func_waiting{func}  - Function while waiting
 *     func_callback_success{func} - Function on success result with status 200
 *     func_callback_error{Func} - Function on error result with status 200
 */
function validateRecaptcha(callbacks) {
    var url = "/ajax/recaptcha-ajax/validate";
    var params = {
        _csrf: window.yii.getCsrfToken(),
        g_recaptcha_response: grecaptcha.getResponse()
    };
    AJAX(url, 'POST', params, {
        response_json: true,
        func_waiting: function () {
            if ('func_waiting' in callbacks && typeof callbacks.func_waiting == 'function') {
                var fw = callbacks.func_waiting;
                fw();
            }
        },
        func_callback: function (resp) {
            if (resp.meta.status == 'success') {
                if ('func_callback_success' in callbacks && typeof callbacks.func_callback_success == 'function') {
                    var fcs = callbacks.func_callback_success;
                    fcs(resp);
                }
            } else if (resp.meta.status == 'fail') {
                if ('func_callback_error' in callbacks && typeof callbacks.func_callback_error == 'function') {
                    var fce = callbacks.func_callback_error;
                    fce(resp);
                }
                grecaptcha_reset();
            }
        },
        func_error: function (resp, xhr) {
            grecaptcha_reset();
        }
    });
}
