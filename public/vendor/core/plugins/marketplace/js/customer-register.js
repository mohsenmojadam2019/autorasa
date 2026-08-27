/******/ (() => { // webpackBootstrap
/*!************************************************************************!*\
  !*** ./platform/plugins/marketplace/resources/js/customer-register.js ***!
  \************************************************************************/
$(function () {
  $(document).on('click', 'input[name=is_vendor]', function (e) {
    var currentTarget = $(e.currentTarget);
    if (currentTarget.val() == 1) {
      $('[data-bb-toggle="vendor-info"]').slideDown();
    } else {
      $('[data-bb-toggle="vendor-info"]').slideUp();
      currentTarget.closest('form').find('button[type=submit]').prop('disabled', false);
    }
  });
  $('form.js-base-form input[name="shop_url"]').on('change', function (e) {
    var currentTarget = $(e.currentTarget);
    var form = currentTarget.closest('form');
    var url = currentTarget.val();
    if (!url) {
      return;
    }
    var slug = form.find('[data-slug-value]');
    $.ajax({
      url: currentTarget.data('url'),
      type: 'POST',
      data: {
        url: url
      },
      beforeSend: function beforeSend() {
        currentTarget.prop('disabled', true);
        form.find('button[type=submit]').prop('disabled', true);
      },
      success: function success(_ref) {
        var error = _ref.error,
          message = _ref.message,
          data = _ref.data;
        if (error) {
          currentTarget.addClass('is-invalid').removeClass('is-valid');
          $('.shop-url-status').removeClass('text-success').addClass('text-danger').text(message);
        } else {
          currentTarget.removeClass('is-invalid').addClass('is-valid');
          $('.shop-url-status').removeClass('text-danger').addClass('text-success').text(message);
          form.find('button[type=submit]').prop('disabled', false);
        }
        if (data !== null && data !== void 0 && data.slug) {
          slug.html("".concat(slug.data('base-url'), "/<strong>").concat(data.slug.substring(0, 100).toLowerCase(), "</strong>"));
        }
      },
      complete: function complete() {
        return currentTarget.prop('disabled', false);
      }
    });
  });
  if ($('.become-vendor-form').length) {
    var certificateDropzone = new Dropzone('#certificate-dropzone', {
      url: '#',
      autoProcessQueue: false,
      paramName: 'certificate_file',
      maxFiles: 1,
      acceptedFiles: '.pdf,.jpg,.jpeg,.png',
      addRemoveLinks: true,
      dictDefaultMessage: $('#certificate-dropzone').data('placeholder'),
      maxfilesexceeded: function maxfilesexceeded(file) {
        this.removeFile(file);
      }
    });
    var governmentIdDropzone = new Dropzone('#government-id-dropzone', {
      url: '#',
      autoProcessQueue: false,
      paramName: 'government_id_file',
      maxFiles: 1,
      acceptedFiles: '.pdf,.jpg,.jpeg,.png',
      addRemoveLinks: true,
      dictDefaultMessage: $('#government-id-dropzone').data('placeholder'),
      maxfilesexceeded: function maxfilesexceeded(file) {
        this.removeFile(file);
      }
    });
    $('form.become-vendor-form').on('submit', function (e) {
      e.preventDefault();
      var form = $(e.currentTarget);
      var formData = new FormData(form.get(0));
      if (certificateDropzone.getQueuedFiles().length > 0) {
        formData.append('certificate_file', certificateDropzone.getQueuedFiles()[0]);
      }
      if (governmentIdDropzone.getQueuedFiles().length > 0) {
        formData.append('government_id_file', governmentIdDropzone.getQueuedFiles()[0]);
      }
      $.ajax({
        url: form.prop('action'),
        type: 'POST',
        data: formData,
        processData: false,
        contentType: false,
        success: function success(_ref2) {
          var data = _ref2.data;
          if (data !== null && data !== void 0 && data.redirect_url) {
            window.location.href = data.redirect_url;
          }
        },
        error: function error(response) {
          var errors = response.responseJSON.errors;
          form.find('input').removeClass('is-invalid').removeClass('is-valid');
          form.find('.invalid-feedback').remove();
          if (errors) {
            Object.keys(errors).forEach(function (key) {
              var input = form.find("input[name=\"".concat(key, "\"]"));
              var error = errors[key];
              if (['certificate_file', 'government_id_file'].includes(key)) {
                var wrapper = form.find("[data-field-name=\"".concat(key, "\"]"));
                wrapper.find('.invalid-feedback').remove();
                wrapper.append("<div class=\"invalid-feedback\" style=\"display: block\">".concat(error, "</div>"));
              } else {
                input.addClass('is-invalid').removeClass('is-valid');
                if (!input.is(':checkbox')) {
                  input.parent().append("<div class=\"invalid-feedback\">".concat(error, "</div>"));
                }
              }
            });
          }
        }
      });
    });
  }
});
/******/ })()
;