/******/ (() => { // webpackBootstrap
/*!******************************************************!*\
  !*** ./platform/themes/shofy/assets/js/ecommerce.js ***!
  \******************************************************/
function _typeof(o) { "@babel/helpers - typeof"; return _typeof = "function" == typeof Symbol && "symbol" == typeof Symbol.iterator ? function (o) { return typeof o; } : function (o) { return o && "function" == typeof Symbol && o.constructor === Symbol && o !== Symbol.prototype ? "symbol" : typeof o; }, _typeof(o); }
function _regeneratorRuntime() { "use strict"; /*! regenerator-runtime -- Copyright (c) 2014-present, Facebook, Inc. -- license (MIT): https://github.com/facebook/regenerator/blob/main/LICENSE */ _regeneratorRuntime = function _regeneratorRuntime() { return e; }; var t, e = {}, r = Object.prototype, n = r.hasOwnProperty, o = Object.defineProperty || function (t, e, r) { t[e] = r.value; }, i = "function" == typeof Symbol ? Symbol : {}, a = i.iterator || "@@iterator", c = i.asyncIterator || "@@asyncIterator", u = i.toStringTag || "@@toStringTag"; function define(t, e, r) { return Object.defineProperty(t, e, { value: r, enumerable: !0, configurable: !0, writable: !0 }), t[e]; } try { define({}, ""); } catch (t) { define = function define(t, e, r) { return t[e] = r; }; } function wrap(t, e, r, n) { var i = e && e.prototype instanceof Generator ? e : Generator, a = Object.create(i.prototype), c = new Context(n || []); return o(a, "_invoke", { value: makeInvokeMethod(t, r, c) }), a; } function tryCatch(t, e, r) { try { return { type: "normal", arg: t.call(e, r) }; } catch (t) { return { type: "throw", arg: t }; } } e.wrap = wrap; var h = "suspendedStart", l = "suspendedYield", f = "executing", s = "completed", y = {}; function Generator() {} function GeneratorFunction() {} function GeneratorFunctionPrototype() {} var p = {}; define(p, a, function () { return this; }); var d = Object.getPrototypeOf, v = d && d(d(values([]))); v && v !== r && n.call(v, a) && (p = v); var g = GeneratorFunctionPrototype.prototype = Generator.prototype = Object.create(p); function defineIteratorMethods(t) { ["next", "throw", "return"].forEach(function (e) { define(t, e, function (t) { return this._invoke(e, t); }); }); } function AsyncIterator(t, e) { function invoke(r, o, i, a) { var c = tryCatch(t[r], t, o); if ("throw" !== c.type) { var u = c.arg, h = u.value; return h && "object" == _typeof(h) && n.call(h, "__await") ? e.resolve(h.__await).then(function (t) { invoke("next", t, i, a); }, function (t) { invoke("throw", t, i, a); }) : e.resolve(h).then(function (t) { u.value = t, i(u); }, function (t) { return invoke("throw", t, i, a); }); } a(c.arg); } var r; o(this, "_invoke", { value: function value(t, n) { function callInvokeWithMethodAndArg() { return new e(function (e, r) { invoke(t, n, e, r); }); } return r = r ? r.then(callInvokeWithMethodAndArg, callInvokeWithMethodAndArg) : callInvokeWithMethodAndArg(); } }); } function makeInvokeMethod(e, r, n) { var o = h; return function (i, a) { if (o === f) throw Error("Generator is already running"); if (o === s) { if ("throw" === i) throw a; return { value: t, done: !0 }; } for (n.method = i, n.arg = a;;) { var c = n.delegate; if (c) { var u = maybeInvokeDelegate(c, n); if (u) { if (u === y) continue; return u; } } if ("next" === n.method) n.sent = n._sent = n.arg;else if ("throw" === n.method) { if (o === h) throw o = s, n.arg; n.dispatchException(n.arg); } else "return" === n.method && n.abrupt("return", n.arg); o = f; var p = tryCatch(e, r, n); if ("normal" === p.type) { if (o = n.done ? s : l, p.arg === y) continue; return { value: p.arg, done: n.done }; } "throw" === p.type && (o = s, n.method = "throw", n.arg = p.arg); } }; } function maybeInvokeDelegate(e, r) { var n = r.method, o = e.iterator[n]; if (o === t) return r.delegate = null, "throw" === n && e.iterator["return"] && (r.method = "return", r.arg = t, maybeInvokeDelegate(e, r), "throw" === r.method) || "return" !== n && (r.method = "throw", r.arg = new TypeError("The iterator does not provide a '" + n + "' method")), y; var i = tryCatch(o, e.iterator, r.arg); if ("throw" === i.type) return r.method = "throw", r.arg = i.arg, r.delegate = null, y; var a = i.arg; return a ? a.done ? (r[e.resultName] = a.value, r.next = e.nextLoc, "return" !== r.method && (r.method = "next", r.arg = t), r.delegate = null, y) : a : (r.method = "throw", r.arg = new TypeError("iterator result is not an object"), r.delegate = null, y); } function pushTryEntry(t) { var e = { tryLoc: t[0] }; 1 in t && (e.catchLoc = t[1]), 2 in t && (e.finallyLoc = t[2], e.afterLoc = t[3]), this.tryEntries.push(e); } function resetTryEntry(t) { var e = t.completion || {}; e.type = "normal", delete e.arg, t.completion = e; } function Context(t) { this.tryEntries = [{ tryLoc: "root" }], t.forEach(pushTryEntry, this), this.reset(!0); } function values(e) { if (e || "" === e) { var r = e[a]; if (r) return r.call(e); if ("function" == typeof e.next) return e; if (!isNaN(e.length)) { var o = -1, i = function next() { for (; ++o < e.length;) if (n.call(e, o)) return next.value = e[o], next.done = !1, next; return next.value = t, next.done = !0, next; }; return i.next = i; } } throw new TypeError(_typeof(e) + " is not iterable"); } return GeneratorFunction.prototype = GeneratorFunctionPrototype, o(g, "constructor", { value: GeneratorFunctionPrototype, configurable: !0 }), o(GeneratorFunctionPrototype, "constructor", { value: GeneratorFunction, configurable: !0 }), GeneratorFunction.displayName = define(GeneratorFunctionPrototype, u, "GeneratorFunction"), e.isGeneratorFunction = function (t) { var e = "function" == typeof t && t.constructor; return !!e && (e === GeneratorFunction || "GeneratorFunction" === (e.displayName || e.name)); }, e.mark = function (t) { return Object.setPrototypeOf ? Object.setPrototypeOf(t, GeneratorFunctionPrototype) : (t.__proto__ = GeneratorFunctionPrototype, define(t, u, "GeneratorFunction")), t.prototype = Object.create(g), t; }, e.awrap = function (t) { return { __await: t }; }, defineIteratorMethods(AsyncIterator.prototype), define(AsyncIterator.prototype, c, function () { return this; }), e.AsyncIterator = AsyncIterator, e.async = function (t, r, n, o, i) { void 0 === i && (i = Promise); var a = new AsyncIterator(wrap(t, r, n, o), i); return e.isGeneratorFunction(r) ? a : a.next().then(function (t) { return t.done ? t.value : a.next(); }); }, defineIteratorMethods(g), define(g, u, "Generator"), define(g, a, function () { return this; }), define(g, "toString", function () { return "[object Generator]"; }), e.keys = function (t) { var e = Object(t), r = []; for (var n in e) r.push(n); return r.reverse(), function next() { for (; r.length;) { var t = r.pop(); if (t in e) return next.value = t, next.done = !1, next; } return next.done = !0, next; }; }, e.values = values, Context.prototype = { constructor: Context, reset: function reset(e) { if (this.prev = 0, this.next = 0, this.sent = this._sent = t, this.done = !1, this.delegate = null, this.method = "next", this.arg = t, this.tryEntries.forEach(resetTryEntry), !e) for (var r in this) "t" === r.charAt(0) && n.call(this, r) && !isNaN(+r.slice(1)) && (this[r] = t); }, stop: function stop() { this.done = !0; var t = this.tryEntries[0].completion; if ("throw" === t.type) throw t.arg; return this.rval; }, dispatchException: function dispatchException(e) { if (this.done) throw e; var r = this; function handle(n, o) { return a.type = "throw", a.arg = e, r.next = n, o && (r.method = "next", r.arg = t), !!o; } for (var o = this.tryEntries.length - 1; o >= 0; --o) { var i = this.tryEntries[o], a = i.completion; if ("root" === i.tryLoc) return handle("end"); if (i.tryLoc <= this.prev) { var c = n.call(i, "catchLoc"), u = n.call(i, "finallyLoc"); if (c && u) { if (this.prev < i.catchLoc) return handle(i.catchLoc, !0); if (this.prev < i.finallyLoc) return handle(i.finallyLoc); } else if (c) { if (this.prev < i.catchLoc) return handle(i.catchLoc, !0); } else { if (!u) throw Error("try statement without catch or finally"); if (this.prev < i.finallyLoc) return handle(i.finallyLoc); } } } }, abrupt: function abrupt(t, e) { for (var r = this.tryEntries.length - 1; r >= 0; --r) { var o = this.tryEntries[r]; if (o.tryLoc <= this.prev && n.call(o, "finallyLoc") && this.prev < o.finallyLoc) { var i = o; break; } } i && ("break" === t || "continue" === t) && i.tryLoc <= e && e <= i.finallyLoc && (i = null); var a = i ? i.completion : {}; return a.type = t, a.arg = e, i ? (this.method = "next", this.next = i.finallyLoc, y) : this.complete(a); }, complete: function complete(t, e) { if ("throw" === t.type) throw t.arg; return "break" === t.type || "continue" === t.type ? this.next = t.arg : "return" === t.type ? (this.rval = this.arg = t.arg, this.method = "return", this.next = "end") : "normal" === t.type && e && (this.next = e), y; }, finish: function finish(t) { for (var e = this.tryEntries.length - 1; e >= 0; --e) { var r = this.tryEntries[e]; if (r.finallyLoc === t) return this.complete(r.completion, r.afterLoc), resetTryEntry(r), y; } }, "catch": function _catch(t) { for (var e = this.tryEntries.length - 1; e >= 0; --e) { var r = this.tryEntries[e]; if (r.tryLoc === t) { var n = r.completion; if ("throw" === n.type) { var o = n.arg; resetTryEntry(r); } return o; } } throw Error("illegal catch attempt"); }, delegateYield: function delegateYield(e, r, n) { return this.delegate = { iterator: values(e), resultName: r, nextLoc: n }, "next" === this.method && (this.arg = t), y; } }, e; }
function asyncGeneratorStep(n, t, e, r, o, a, c) { try { var i = n[a](c), u = i.value; } catch (n) { return void e(n); } i.done ? t(u) : Promise.resolve(u).then(r, o); }
function _asyncToGenerator(n) { return function () { var t = this, e = arguments; return new Promise(function (r, o) { var a = n.apply(t, e); function _next(n) { asyncGeneratorStep(a, r, o, _next, _throw, "next", n); } function _throw(n) { asyncGeneratorStep(a, r, o, _next, _throw, "throw", n); } _next(void 0); }); }; }
$(function () {
  'use strict';

  var loadAjaxCart = function loadAjaxCart(data) {
    $('.cartmini__area').html(data.cart_mini);
    $('[data-bb-value="cart-count"]').text(data.count);
    if ($('.tp-cart-area').length) {
      $('.tp-cart-area').replaceWith(data.cart_content);
    }
    if (typeof Theme.lazyLoadInstance !== 'undefined') {
      Theme.lazyLoadInstance.update();
    }
  };
  var handleUpdateCart = function handleUpdateCart(element) {
    var form;
    if (element) {
      form = $(element).closest('form');
    } else {
      form = $('form.cart-form');
    }
    $.ajax({
      type: 'POST',
      url: form.prop('action'),
      data: form.serialize(),
      success: function success(_ref) {
        var error = _ref.error,
          message = _ref.message,
          data = _ref.data;
        if (error) {
          Theme.showError(message);
        }
        loadAjaxCart(data);
      },
      error: function error(_error) {
        return Theme.handleError(_error);
      }
    });
  };

  /**
   * @param {Array<Number>} data
   * @param {jQuery} element
   */
  window.onBeforeChangeSwatches = function (data, element) {
    var form = element.closest('form');
    if (data) {
      form.find('button[type="submit"]').prop('disabled', true);
      form.find('button[data-bb-toggle="add-to-cart"]').prop('disabled', true);
    }
  };
  $(document).on('click', '[data-bb-toggle="remove-coupon"]', function (e) {
    e.preventDefault();
    var currentTarget = $(e.currentTarget);
    $.ajax({
      url: currentTarget.prop('href'),
      type: 'POST',
      success: function success(_ref2) {
        var error = _ref2.error,
          message = _ref2.message;
        if (error) {
          Theme.showError(message);
          return;
        }
        Theme.showSuccess(message);
        handleUpdateCart();
      },
      error: function error(_error2) {
        return Theme.handleError(_error2);
      }
    });
  }).on('click', '[data-bb-toggle="decrease-qty"]', function (e) {
    var $input = $(e.currentTarget).parent().find('input');
    var count = parseInt($input.val()) - 1;
    count = count < 1 ? 1 : count;
    $input.val(count);
    $input.trigger('change');
  }).on('click', '[data-bb-toggle="increase-qty"]', function (e) {
    var $input = $(e.currentTarget).parent().find('input');
    var max = $input.prop('max');
    if (max && parseInt($input.val()) >= parseInt(max)) {
      return;
    }
    $input.val(parseInt($input.val()) + 1);
    $input.trigger('change');
  }).on('change', '[data-bb-toggle="update-cart"]', function (e) {
    handleUpdateCart(e.currentTarget);
  }).on('click', '[data-bb-toggle="change-product-filter-layout"]', function (e) {
    e.preventDefault();
    var currentTarget = $(e.currentTarget);
    currentTarget.addClass('active');
    currentTarget.closest('li').siblings().find('button').removeClass('active');
    $('.bb-product-form-filter').find('[name="layout"]').val(currentTarget.data('value')).trigger('change');
  }).on('click', '[data-bb-toggle="copy-coupon"]', /*#__PURE__*/function () {
    var _ref3 = _asyncToGenerator(/*#__PURE__*/_regeneratorRuntime().mark(function _callee(e) {
      var currentTarget, value, previousText, tempInput;
      return _regeneratorRuntime().wrap(function _callee$(_context) {
        while (1) switch (_context.prev = _context.next) {
          case 0:
            e.preventDefault();
            currentTarget = $(e.currentTarget);
            value = currentTarget.data('value');
            previousText = currentTarget.find('span').text();
            if (!navigator.clipboard) {
              _context.next = 9;
              break;
            }
            _context.next = 7;
            return navigator.clipboard.writeText(value);
          case 7:
            _context.next = 15;
            break;
          case 9:
            tempInput = document.createElement('input');
            tempInput.value = value;
            document.body.appendChild(tempInput);
            tempInput.select();
            document.execCommand('copy');
            document.body.removeChild(tempInput);
          case 15:
            currentTarget.find('span').text(currentTarget.data('copied-message'));
            setTimeout(function () {
              return currentTarget.find('span').text(previousText);
            }, 2000);
          case 17:
          case "end":
            return _context.stop();
        }
      }, _callee);
    }));
    return function (_x) {
      return _ref3.apply(this, arguments);
    };
  }()).on('click', '[data-bb-toggle="scroll-to-review"]', function (e) {
    if ($('.nav-tabs button#nav-review-tab').length) {
      e.preventDefault();
      var $tab = $('.nav-tabs button#nav-review-tab');
      var $container = $('.product-review-container');
      if ($tab.length && $container.length) {
        $tab.tab('show');
        $('html, body').animate({
          scrollTop: $container.offset().top - 100
        });
      }
    }
  }).on('show.bs.modal', '#product-quick-view-modal', function (e) {
    var modal = $(e.currentTarget);
    var trigger = $(e.relatedTarget);
    $.ajax({
      url: trigger.data('url') || trigger.prop('href'),
      type: 'GET',
      beforeSend: function beforeSend() {
        trigger.addClass('btn-loading');
        modal.find('.modal-content').css('min-height', '40rem').html('<div class="loading-spinner"></div>');
      },
      success: function success(_ref4) {
        var error = _ref4.error,
          data = _ref4.data;
        if (error) {
          return;
        }
        modal.find('.modal-content').css('min-height', '0').html(data);
        if (typeof Theme.lazyLoadInstance !== 'undefined') {
          Theme.lazyLoadInstance.update();
        }
        setTimeout(function () {
          EcommerceApp.initProductGallery(true);
        }, 100);
        document.dispatchEvent(new CustomEvent('ecommerce.quick-view.initialized'));
      },
      complete: function complete() {
        return trigger.removeClass('btn-loading');
      }
    });
  }).on('submit', 'form#counpon-form', function (e) {
    e.preventDefault();
    var currentTarget = $(e.currentTarget);
    var button = currentTarget.find('button[type="submit"]');
    $.ajax({
      url: currentTarget.prop('action'),
      type: 'POST',
      data: currentTarget.serialize(),
      beforeSend: function beforeSend() {
        return button.prop('disabled', true).addClass('btn-loading');
      },
      success: function success(_ref5) {
        var error = _ref5.error,
          message = _ref5.message;
        if (error) {
          Theme.showError(message);
          return;
        }
        Theme.showSuccess(message);
        handleUpdateCart();
      },
      error: function error(_error3) {
        return Theme.handleError(_error3);
      },
      complete: function complete() {
        return button.prop('disabled', false).removeClass('btn-loading');
      }
    });
  }).on('keyup', 'form#counpon-form input', function (e) {
    var currentTarget = $(e.currentTarget);
    currentTarget.closest('form').find('button[type="submit"]').prop('disabled', !currentTarget.val());
  }).on('click', '.product-form button[type="submit"]', function (e) {
    e.preventDefault();
    var currentTarget = $(e.currentTarget);
    var form = currentTarget.closest('form');
    var data = form.serializeArray();
    if (form.find('input[name="id"]').val() === '') {
      return;
    }
    data.push({
      name: 'checkout',
      value: currentTarget.prop('name') === 'checkout' ? 1 : 0
    });
    $.ajax({
      type: 'POST',
      url: form.prop('action'),
      data: data,
      beforeSend: function beforeSend() {
        currentTarget.prop('disabled', true).addClass('btn-loading');
      },
      success: function success(_ref6) {
        var error = _ref6.error,
          message = _ref6.message,
          data = _ref6.data;
        if (error) {
          Theme.showError(message);
          if ((data === null || data === void 0 ? void 0 : data.next_url) !== undefined) {
            setTimeout(function () {
              window.location.href = data.next_url;
            }, 500);
          }
          return;
        }
        form.find('input[name="qty"]').val(1);
        if ((data === null || data === void 0 ? void 0 : data.next_url) !== undefined) {
          window.location.href = data.next_url;
        } else {
          loadAjaxCart(data);
          $('.cartmini__area').addClass('cartmini-opened');
          $('.body-overlay').addClass('opened');
        }
      },
      error: function error(_error4) {
        return Theme.handleError(_error4);
      },
      complete: function complete() {
        return currentTarget.prop('disabled', false).removeClass('btn-loading');
      }
    });
  }).on('click', '[data-bb-toggle="scroll-to-review"]', function (e) {
    if ($('.nav-tabs button#nav-review-tab').length) {
      e.preventDefault();
      var $tab = $('.nav-tabs button#nav-review-tab');
      var $container = $('.product-review-container');
      if ($tab.length && $container.length) {
        $tab.tab('show');
        $('html, body').animate({
          scrollTop: $container.offset().top - 100
        });
      }
    }
  }).on('click', '.js-sale-popup-quick-view-button', function (e) {
    e.preventDefault();
    $('#product-quick-view-modal').modal('show', e.currentTarget);
  }).on('change', '.tp-shop-top-select select', function (e) {
    var currentTarget = $(e.currentTarget);
    var form = $('.bb-product-form-filter');
    form.find("input[name=\"".concat(currentTarget.prop('name'), "\"]")).val(currentTarget.val()).trigger('submit');
  }).on('click', '.bb-product-items-wrapper .pagination a', function (e) {
    e.preventDefault();
    var currentTarget = $(e.currentTarget);
    var url = new URL(currentTarget.prop('href'));
    var page = url.searchParams.get('page');
    $('.bb-product-form-filter').find('[name="page"]').val(page).trigger('change');
  }).on('submit', 'form.subscribe-form', function (e) {
    e.preventDefault();
    var $form = $(e.currentTarget);
    var $button = $form.find('button[type=submit]');
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
      success: function success(_ref7) {
        var error = _ref7.error,
          message = _ref7.message;
        if (error) {
          Theme.showError(message);
          return;
        }
        $form.find('input').val('');
        Theme.showSuccess(message);
        document.dispatchEvent(new CustomEvent('newsletter.subscribed'));
      },
      error: function error(_error5) {
        if (typeof refreshRecaptcha !== 'undefined') {
          refreshRecaptcha();
        }
        Theme.handleError(_error5);
      },
      complete: function complete() {
        if (typeof refreshRecaptcha !== 'undefined') {
          refreshRecaptcha();
        }
        $button.prop('disabled', false).removeClass('btn-loading');
      }
    });
  }).on('click', '[data-bb-toggle="product-tab"]', function (e) {
    e.preventDefault();
    var currentTarget = $(e.currentTarget);
    var tabPane = currentTarget.closest('.tp-product-area').find('#productTabContent .tab-pane');
    var wrapper = tabPane.closest('.tp-product-area');
    var tooltip = currentTarget.find('span.tp-product-tab-tooltip');
    $.ajax({
      url: "".concat(currentTarget.closest('#productTab').data('ajax-url'), "&type=").concat(currentTarget.data('bb-value')),
      method: 'GET',
      dataType: 'json',
      beforeSend: function beforeSend() {
        tooltip.text('...');
        wrapper.append('<div class="loading-spinner"></div>');
      },
      success: function success(_ref8) {
        var data = _ref8.data;
        tooltip.text(data.count);
        tabPane.html(data.html);
        if (typeof Theme.lazyLoadInstance !== 'undefined') {
          Theme.lazyLoadInstance.update();
        }
      },
      error: function error(_error6) {
        return Theme.handleError(_error6);
      },
      complete: function complete() {
        return $('.loading-spinner').remove();
      }
    });
  }).on('submit', '.contact-form', function (e) {
    e.preventDefault();
    var $form = $(e.currentTarget);
    var $button = $form.find('button[type=submit]');
    $.ajax({
      type: 'POST',
      cache: false,
      url: $form.prop('action'),
      data: new FormData($form[0]),
      contentType: false,
      processData: false,
      beforeSend: function beforeSend() {
        return $button.addClass('button-loading');
      },
      success: function success(_ref9) {
        var error = _ref9.error,
          message = _ref9.message;
        if (!error) {
          $form[0].reset();
          Theme.showSuccess(message);
        } else {
          Theme.showError(message);
        }
      },
      error: function error(_error7) {
        return Theme.handleError(_error7);
      },
      complete: function complete() {
        if (typeof refreshRecaptcha !== 'undefined') {
          refreshRecaptcha();
        }
        $button.removeClass('button-loading');
      }
    });
  }).on('click', '.sticky-actions-button button', function (e) {
    e.preventDefault();
    var currentTarget = $(e.currentTarget);
    var form = $('form.product-form');
    if (currentTarget.prop('name') === 'add-to-cart') {
      form.find('button[type="submit"][name="add-to-cart"]').trigger('click');
    }
    if (currentTarget.prop('name') === 'checkout') {
      form.find('button[type="submit"][name="checkout"]').trigger('click');
    }
  }).on('click', '[data-bb-toggle="open-mini-cart"]', function (e) {
    $('[data-bb-toggle="mini-cart-content-slot"]').html('<div class="loading-spinner"></div>');
    $.ajax({
      url: $(e.currentTarget).data('url'),
      type: 'GET',
      success: function success(_ref10) {
        var data = _ref10.data;
        $('[data-bb-toggle="mini-cart-content-slot"]').html(data.content);
        $('[data-bb-toggle="mini-cart-footer-slot"]').html(data.footer);
        if (typeof Theme.lazyLoadInstance !== 'undefined') {
          Theme.lazyLoadInstance.update();
        }
      },
      error: function error(_error8) {
        return Theme.handleError(_error8);
      }
    });
  });
  document.addEventListener('ecommerce.quick-view.initialized', function () {
    $('[data-countdown]').countdown();
  });
  document.addEventListener('ecommerce.cart.added', function (e) {
    var data = e.detail.data;
    loadAjaxCart(data);
    $('.cartmini__area').addClass('cartmini-opened');
    $('.body-overlay').addClass('opened');
  });
  document.addEventListener('ecommerce.cart.removed', function (e) {
    var data = e.detail.data;
    if (data.count === 0) {
      $('.cartmini__area').removeClass('cartmini-opened');
      $('.body-overlay').removeClass('opened');
    }
    loadAjaxCart(data);
  });
  document.addEventListener('ecommerce.wishlist.removed', function (e) {
    var _e$detail = e.detail,
      data = _e$detail.data,
      element = _e$detail.element;
    element.closest('tr').remove();
    if (data.count === 0) {
      window.location.reload();
    }
    loadAjaxCart(data);
  });
  document.addEventListener('ecommerce.compare.added', function (e) {
    var element = e.detail.element;
    if (element.find('span')) {
      element.find('span').text(element.hasClass('active') ? element.data('remove-text') : element.data('add-text'));
    }
  });
  document.addEventListener('ecommerce.wishlist.added', function (e) {
    var _e$detail2 = e.detail,
      data = _e$detail2.data,
      element = _e$detail2.element;
    data.added ? element.addClass('active') : element.removeClass('active');
    if (element.find('span')) {
      element.find('span').text(data.added ? element.data('remove-text') : element.data('add-text'));
    }
  });
  document.addEventListener('ecommerce.compare.removed', function (e) {
    var element = e.detail.element;
    if (element.find('span')) {
      element.find('span').text(element.hasClass('active') ? element.data('remove-text') : element.data('add-text'));
    }
  });
  document.addEventListener('ecommerce.product-filter.before', function () {
    $('.tp-shop-area > .container, .bb-shop-detail > .container > .bb-shop-tab-content').append('<div class="loading-spinner"></div>');
  });
  document.addEventListener('ecommerce.product-filter.success', function (e) {
    var data = e.detail.data;
    $('.bb-product-items-wrapper').html(data.data);
    if (data.additional) {
      $('.bb-shop-sidebar').replaceWith(data.additional.filters_html);
    }
    $('.tp-shop-top-result p').text(data.message);
    if ($('.bb-product-price-filter').length) {
      EcommerceApp.initPriceFilter();
    }
    $('html, body').animate({
      scrollTop: $('.tp-shop-main-wrapper').offset().top - 120
    });
  });
  document.addEventListener('ecommerce.product-filter.completed', function () {
    $('.tp-shop-area > .container, .bb-shop-detail > .container > .bb-shop-tab-content').find('.loading-spinner').remove();
    if (typeof Theme.lazyLoadInstance !== 'undefined') {
      Theme.lazyLoadInstance.update();
    }
  });
  document.addEventListener('ecommerce.quick-shop.before-send', function (e) {
    var _e$detail3 = e.detail,
      element = _e$detail3.element,
      modal = _e$detail3.modal;
    element.addClass('btn-loading');
    modal.find('.modal-body').css('min-height', '16rem').html('<div class="loading-spinner"></div>');
  });
  document.addEventListener('ecommerce.quick-shop.completed', function (e) {
    var _e$detail4 = e.detail,
      element = _e$detail4.element,
      modal = _e$detail4.modal;
    element.removeClass('btn-loading');
    modal.find('.modal-body').css('min-height', '0');
  });
  if (window.location.hash === '#product-review') {
    $(document).find('[data-bb-toggle="scroll-to-review"]').trigger('click');
  }
  var triggerProductTab = function triggerProductTab() {
    $(document).find('[data-bb-toggle="product-tab"]').first().trigger('click');
  };
  triggerProductTab();
  document.addEventListener('shortcode.loaded', function (e) {
    var _e$detail5 = e.detail,
      name = _e$detail5.name,
      attributes = _e$detail5.attributes;
    if (name === 'ecommerce-product-groups' && attributes.style !== 'columns') {
      triggerProductTab();
    }
    $('[data-countdown]').countdown();
  });
});
/******/ })()
;