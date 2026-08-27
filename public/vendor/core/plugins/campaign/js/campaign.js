/******/ (() => { // webpackBootstrap
/*!************************************************************!*\
  !*** ./platform/plugins/campaign/resources/js/campaign.js ***!
  \************************************************************/
$(function () {
  var $campaignPopup = $('#campaign-popup');
  var dontShowAgain = function dontShowAgain(time) {
    var date = new Date();
    date.setTime(date.getTime() + time);
    document.cookie = "campaign_popup=1; expires=".concat(date.toUTCString(), "; path=/");
  };
  if ($campaignPopup.length > 0) {
    if (document.cookie.indexOf('campaign_popup=1') === -1) {
      setTimeout(function () {
        $campaignPopup.modal('show');
      }, $campaignPopup.data('delay') * 1000);
    }
    $campaignPopup.on('show.bs.modal', function () {
      var dialog = $campaignPopup.find('.modal-dialog');
      dialog.css('margin-top', Math.max(0, ($(window).height() - dialog.height()) / 2) / 2);
    }).on('hide.bs.modal', function () {
      var checkbox = $campaignPopup.find('form').find('input[name="dont_show_again"]');
      if (checkbox.is(':checked')) {
        dontShowAgain(3 * 24 * 60 * 60 * 1000); // 1 day
      } else {
        dontShowAgain(60 * 60 * 1000); // 1 hour
      }
    });
    document.addEventListener('campaign.subscribed', function () {
      return dontShowAgain();
    });
    var showError = function showError(message) {
      $('.campaign-error-message').html(message).show();
    };
    var showSuccess = function showSuccess(message) {
      $('.campaign-success-message').html(message).show();
    };
    var handleError = function handleError(data) {
      if (typeof data.errors !== 'undefined' && data.errors.length) {
        handleValidationError(data.errors);
      } else {
        if (typeof data.responseJSON !== 'undefined') {
          if (typeof data.responseJSON.errors !== 'undefined') {
            if (data.status === 422) {
              handleValidationError(data.responseJSON.errors);
            }
          } else if (typeof data.responseJSON.message !== 'undefined') {
            showError(data.responseJSON.message);
          } else {
            $.each(data.responseJSON, function (index, el) {
              $.each(el, function (key, item) {
                showError(item);
              });
            });
          }
        } else {
          showError(data.statusText);
        }
      }
    };
    var handleValidationError = function handleValidationError(errors) {
      var message = '';
      $.each(errors, function (index, item) {
        if (message !== '') {
          message += '<br />';
        }
        message += item;
      });
      showError(message);
    };
    $(document).on('submit', 'form.bb-campaign-popup-form', function (e) {
      e.preventDefault();
      var $form = $(e.currentTarget);
      var $button = $form.find('button[type=submit]');
      $('.campaign-success-message').html('').hide();
      $('.campaign-error-message').html('').hide();
      $.ajax({
        type: 'POST',
        cache: false,
        url: $form.prop('action'),
        data: new FormData($form[0]),
        contentType: false,
        processData: false,
        beforeSend: function beforeSend() {
          return $button.prop('disabled', true).addClass('btn-loading');
        },
        success: function success(_ref) {
          var error = _ref.error,
            message = _ref.message;
          if (error) {
            showError(message);
            return;
          }
          $form.find('input[name="email"]').val('');
          showSuccess(message);
          document.dispatchEvent(new CustomEvent('campaign.subscribed'));
          setTimeout(function () {
            $campaignPopup.modal('hide');
          }, 5000);
        },
        error: function error(_error) {
          return handleError(_error);
        },
        complete: function complete() {
          if (typeof refreshRecaptcha !== 'undefined') {
            refreshRecaptcha();
          }
          $button.prop('disabled', false).removeClass('btn-loading');
        }
      });
    });
  }
});
/******/ })()
;