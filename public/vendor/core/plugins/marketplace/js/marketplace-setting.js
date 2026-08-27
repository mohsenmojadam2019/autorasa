/******/ (() => { // webpackBootstrap
/*!**************************************************************************!*\
  !*** ./platform/plugins/marketplace/resources/js/marketplace-setting.js ***!
  \**************************************************************************/
function _typeof(o) { "@babel/helpers - typeof"; return _typeof = "function" == typeof Symbol && "symbol" == typeof Symbol.iterator ? function (o) { return typeof o; } : function (o) { return o && "function" == typeof Symbol && o.constructor === Symbol && o !== Symbol.prototype ? "symbol" : typeof o; }, _typeof(o); }
function _classCallCheck(a, n) { if (!(a instanceof n)) throw new TypeError("Cannot call a class as a function"); }
function _defineProperties(e, r) { for (var t = 0; t < r.length; t++) { var o = r[t]; o.enumerable = o.enumerable || !1, o.configurable = !0, "value" in o && (o.writable = !0), Object.defineProperty(e, _toPropertyKey(o.key), o); } }
function _createClass(e, r, t) { return r && _defineProperties(e.prototype, r), t && _defineProperties(e, t), Object.defineProperty(e, "prototype", { writable: !1 }), e; }
function _toPropertyKey(t) { var i = _toPrimitive(t, "string"); return "symbol" == _typeof(i) ? i : i + ""; }
function _toPrimitive(t, r) { if ("object" != _typeof(t) || !t) return t; var e = t[Symbol.toPrimitive]; if (void 0 !== e) { var i = e.call(t, r || "default"); if ("object" != _typeof(i)) return i; throw new TypeError("@@toPrimitive must return a primitive value."); } return ("string" === r ? String : Number)(t); }
var MarketplaceSetting = /*#__PURE__*/function () {
  function MarketplaceSetting() {
    _classCallCheck(this, MarketplaceSetting);
    this.eventListeners();
  }
  return _createClass(MarketplaceSetting, [{
    key: "eventListeners",
    value: function eventListeners() {
      var _this = this;
      $(document).on('click', '[data-bb-toggle="commission-category-add"]', function (event) {
        event.preventDefault();
        event.stopPropagation();
        _this.addNewCommissionSetting(event.currentTarget);
        return false;
      });
      this.initRemoveCommissionEvent();
      var input = document.querySelectorAll('.tagify-commission-setting');
      input.forEach(function (element) {
        _this.tagify(element);
      });
    }
  }, {
    key: "tagify",
    value: function tagify(element) {
      var self = this;
      new Tagify(element, {
        delimiters: null,
        enforceWhitelist: true,
        whitelist: self.formatWhitelist(),
        dropdown: {
          enabled: 1,
          // suggest tags after a single character input
          classname: 'extra-properties',
          // custom class for the suggestion dropdown,
          searchBy: ['name']
        }
      });
    }
  }, {
    key: "formatWhitelist",
    value: function formatWhitelist() {
      var data = [];
      window.tagifyWhitelist.map(function (item) {
        data.push({
          value: item.name,
          id: item.id
        });
      });
      return data;
    }
  }, {
    key: "addNewCommissionSetting",
    value: function addNewCommissionSetting() {
      var tpl = $('#commission-setting-item-template').html();
      var index = $('.commission-setting-item').length;
      var html = tpl.replace(/__index__/g, index);
      $('.commission-setting-item-wrapper').append(html);
      var element = document.querySelector("#commission-setting-item-".concat(index, " .tagify-commission-setting"));
      this.tagify(element);
      this.initRemoveCommissionEvent();
    }
  }, {
    key: "initRemoveCommissionEvent",
    value: function initRemoveCommissionEvent() {
      $(document).on('click', '[data-bb-toggle="commission-remove"]', function (e) {
        e.preventDefault();
        e.stopPropagation();
        $(e.target).closest('.commission-setting-item').remove();
      });
    }
  }]);
}();
$(document).ready(function () {
  new MarketplaceSetting();
});
/******/ })()
;