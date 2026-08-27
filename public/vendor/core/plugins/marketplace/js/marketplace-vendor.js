/******/ (() => { // webpackBootstrap
/*!******************************************************************************************!*\
  !*** ./platform/plugins/marketplace/resources/js/vendor-dashboard/marketplace-vendor.js ***!
  \******************************************************************************************/
$(function () {
  $(document).on('click', '#confirm-vendor-button', function (event) {
    event.preventDefault();
    var $button = $(event.currentTarget);
    var $form = $button.closest('form');
    var $modal = $button.closest('.modal');
    $httpClient.make().withButtonLoading($button).post($form.prop('action'), $form.serialize()).then(function (_ref) {
      var data = _ref.data;
      $modal.modal('hide');
      if (data.error) {
        Botble.showError(data.message);
      } else {
        Botble.showSuccess(data.message);
        setTimeout(function () {
          window.location.href = route('marketplace.unverified-vendors.index');
        }, 3000);
      }
    });
  });
});
/******/ })()
;