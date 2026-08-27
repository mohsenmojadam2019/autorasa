/******/ (() => { // webpackBootstrap
/*!**************************************************!*\
  !*** ./platform/plugins/sms/resources/js/sms.js ***!
  \**************************************************/
$(function () {
  $(document).on('click', '[data-bb-toggle="toggle-setting-form"]', function (e) {
    e.preventDefault();
    $(e.currentTarget).closest('.sms-gateway').find('.sms-gateway-content').slideToggle();
  }).on('click', '[data-bb-toggle="change-status"]', function (e) {
    e.preventDefault();
    var $currentTarget = $(e.currentTarget);
    $httpClient.make().withButtonLoading($currentTarget).post($currentTarget.data('url')).then(function (_ref) {
      var data = _ref.data;
      Botble.showSuccess(data.message);
      if (data.data.activated) {
        $currentTarget.hide();
        $currentTarget.siblings('[data-bb-toggle="toggle-setting-form"]').show();
        $currentTarget.closest('.sms-gateway').find('.sms-gateway-content').slideDown();
      } else {
        $currentTarget.closest('.sms-gateway').find('[data-bb-toggle="toggle-setting-form"]').hide();
        $currentTarget.closest('.sms-gateway').find('[data-bb-toggle="change-status"]').show();
        $currentTarget.closest('.sms-gateway').find('.sms-gateway-content').slideUp();
      }
    });
  }).on('submit', '.sms-gateway-form', function (e) {
    e.preventDefault();
    var $form = $(e.currentTarget);
    var $button = $(e.originalEvent.submitter);
    $httpClient.make().withButtonLoading($button).post($form.prop('action'), $form.serialize()).then(function (_ref2) {
      var data = _ref2.data;
      Botble.showSuccess(data.message);
    });
  }).on('show.bs.modal', '#test-sms-modal', function (e) {
    var $modal = $(e.currentTarget);
    var $relatedTarget = $(e.relatedTarget);
    $modal.find('[name="gateway"]').val($relatedTarget.data('gateway'));
  }).on('submit', '#test-sms-modal form', function (e) {
    e.preventDefault();
    var $form = $(e.currentTarget);
    var $modal = $form.closest('.modal');
    var $button = $form.find('button[type="submit"]');
    $httpClient.make().withButtonLoading($button).post($form.prop('action'), $form.serialize()).then(function (_ref3) {
      var data = _ref3.data;
      Botble.showSuccess(data.message);
      $modal.modal('hide');
    })["catch"](function (error) {
      if (error.response.status === 200) {
        $modal.modal('hide');
      }
    });
  });
});
/******/ })()
;