/*
 * ATTENTION: The "eval" devtool has been used (maybe by default in mode: "development").
 * This devtool is neither made for production nor for readable output files.
 * It uses "eval()" calls to create a separate source file in the browser devtools.
 * If you are trying to read the output file, select a different devtool (https://webpack.js.org/configuration/devtool/)
 * or disable the default devtool with "devtool: false".
 * If you are looking for production-ready output files, see mode: "production" (https://webpack.js.org/configuration/mode/).
 */
/******/ (() => { // webpackBootstrap
/******/ 	"use strict";
/******/ 	var __webpack_modules__ = ({

/***/ "./js/app/functions.js"
/*!*****************************!*\
  !*** ./js/app/functions.js ***!
  \*****************************/
(__unused_webpack___webpack_module__, __webpack_exports__, __webpack_require__) {

eval("{__webpack_require__.r(__webpack_exports__);\n/* harmony export */ __webpack_require__.d(__webpack_exports__, {\n/* harmony export */   isEven: () => (/* binding */ isEven),\n/* harmony export */   isjQuery: () => (/* binding */ isjQuery),\n/* harmony export */   mathClamp: () => (/* binding */ mathClamp),\n/* harmony export */   paginateLinks: () => (/* binding */ paginateLinks),\n/* harmony export */   renderBlock: () => (/* binding */ renderBlock),\n/* harmony export */   videoResize: () => (/* binding */ videoResize)\n/* harmony export */ });\nfunction _slicedToArray(r, e) { return _arrayWithHoles(r) || _iterableToArrayLimit(r, e) || _unsupportedIterableToArray(r, e) || _nonIterableRest(); }\nfunction _nonIterableRest() { throw new TypeError(\"Invalid attempt to destructure non-iterable instance.\\nIn order to be iterable, non-array objects must have a [Symbol.iterator]() method.\"); }\nfunction _unsupportedIterableToArray(r, a) { if (r) { if (\"string\" == typeof r) return _arrayLikeToArray(r, a); var t = {}.toString.call(r).slice(8, -1); return \"Object\" === t && r.constructor && (t = r.constructor.name), \"Map\" === t || \"Set\" === t ? Array.from(r) : \"Arguments\" === t || /^(?:Ui|I)nt(?:8|16|32)(?:Clamped)?Array$/.test(t) ? _arrayLikeToArray(r, a) : void 0; } }\nfunction _arrayLikeToArray(r, a) { (null == a || a > r.length) && (a = r.length); for (var e = 0, n = Array(a); e < a; e++) n[e] = r[e]; return n; }\nfunction _iterableToArrayLimit(r, l) { var t = null == r ? null : \"undefined\" != typeof Symbol && r[Symbol.iterator] || r[\"@@iterator\"]; if (null != t) { var e, n, i, u, a = [], f = !0, o = !1; try { if (i = (t = t.call(r)).next, 0 === l) { if (Object(t) !== t) return; f = !1; } else for (; !(f = (e = i.call(t)).done) && (a.push(e.value), a.length !== l); f = !0); } catch (r) { o = !0, n = r; } finally { try { if (!f && null != t[\"return\"] && (u = t[\"return\"](), Object(u) !== u)) return; } finally { if (o) throw n; } } return a; } }\nfunction _arrayWithHoles(r) { if (Array.isArray(r)) return r; }\n/**\n * is jQuery\n * @param obj\n * @returns {*}\n */\nvar isjQuery = function isjQuery(obj) {\n  return obj instanceof jQuery ? obj[0] : obj;\n};\n\n/**\n * is Even\n * @param num\n * @returns {boolean}\n */\nvar isEven = function isEven(num) {\n  return num % 2 === 0;\n};\n\n/**\n * Video Adaptive Resize\n * @param elements\n * @param className\n */\nvar videoResize = function videoResize(elements, className) {\n  function wrapperVideo(parent, className) {\n    var wrapper = document.createElement('div');\n    if (className !== undefined) wrapper.classList = className;\n    wrapper.setAttribute('style', 'position: absolute;top: 0;left: 0;width: 100%;height: 100%;overflow: hidden;');\n    parent.parentNode.insertBefore(wrapper, parent);\n    wrapper.appendChild(parent);\n  }\n  document.querySelectorAll(elements).forEach(function (el) {\n    wrapperVideo(el, className);\n    var fnResize = function fnResize() {\n      // Get a native video size\n      var videoHeight = el.videoHeight;\n      var videoWidth = el.videoWidth;\n\n      // Get a wrapper size\n      var wrapperHeight = el.parentNode.offsetHeight;\n      var wrapperWidth = el.parentNode.offsetWidth;\n      if (wrapperWidth / videoWidth > wrapperHeight / videoHeight) {\n        el.setAttribute('style', 'width:' + (wrapperWidth + 3) + 'px;height:auto;position: absolute;top: 50%;left: 50%;transform: translate(-50%, -50%);');\n      } else {\n        el.setAttribute('style', 'width:auto;height:' + (wrapperHeight + 3) + 'px;position: absolute;top: 50%;left: 50%;transform: translate(-50%, -50%);');\n      }\n    };\n    fnResize();\n    window.addEventListener('resize', fnResize);\n  });\n};\n\n/**\n * Render Block\n * @param type\n * @param fn\n */\nvar renderBlock = function renderBlock() {\n  var type = arguments.length > 0 && arguments[0] !== undefined ? arguments[0] : '';\n  var fn = arguments.length > 1 ? arguments[1] : undefined;\n  var selector = '.' + wp_ajax.prefix + '-' + type;\n  var isGutenberg = typeof wp !== 'undefined' && typeof wp.domReady !== 'undefined' && typeof wp.data !== 'undefined';\n  if (isGutenberg) {\n    wp.domReady(function () {\n      var editorStore = wp.data.select('core/editor');\n      if (editorStore && typeof acf !== 'undefined') {\n        var getBlockEl = function getBlockEl(el) {\n          var _node$querySelector;\n          var node = el instanceof jQuery ? el[0] : el;\n          return (_node$querySelector = node.querySelector(selector)) !== null && _node$querySelector !== void 0 ? _node$querySelector : node;\n        };\n        acf.addAction('render_block_preview/type=' + type, function (el) {\n          return fn(getBlockEl(el), true);\n        });\n      }\n    });\n  } else {\n    document.querySelectorAll(selector).forEach(function (el) {\n      return fn(el, false);\n    });\n  }\n};\n\n/**\n * @param minSize\n * @param maxSize\n * @param minViewport\n * @param maxViewport\n * @param unit\n * @returns {string}\n */\nfunction mathClamp(minSize, maxSize) {\n  var minViewport = arguments.length > 2 && arguments[2] !== undefined ? arguments[2] : 768;\n  var maxViewport = arguments.length > 3 && arguments[3] !== undefined ? arguments[3] : 1400;\n  var unit = arguments.length > 4 && arguments[4] !== undefined ? arguments[4] : 'rem';\n  var toUnit = function toUnit(size) {\n    var context = 16;\n    switch (unit) {\n      case 'rem':\n        return \"\".concat(+(size / context).toFixed(6), \"rem\");\n      case 'em':\n        return \"\".concat(+(size / context).toFixed(6), \"em\");\n      default:\n        return \"\".concat(size, \"px\");\n    }\n  };\n  if (minSize === maxSize) return toUnit(minSize);\n  var viewPortWidthOffset = toUnit(minViewport / 100);\n  var sizeDifference = maxSize - minSize;\n  var viewportDifference = maxViewport - minViewport;\n  var linearFactor = Math.round(100 * (sizeDifference / viewportDifference) * 1000) / 1000;\n  var fluid = \"\".concat(toUnit(minSize), \" + ((1vw - \").concat(viewPortWidthOffset, \") * \").concat(linearFactor, \")\");\n  var _ref = minSize > maxSize ? [toUnit(maxSize), toUnit(minSize)] : [toUnit(minSize), toUnit(maxSize)],\n    _ref2 = _slicedToArray(_ref, 2),\n    clampMin = _ref2[0],\n    clampMax = _ref2[1];\n  return \"clamp(\".concat(clampMin, \", \").concat(fluid, \", \").concat(clampMax, \")\");\n}\n\n/**\n * Paginate Links\n * @param paginateWrap\n * @param total\n * @param current\n */\nvar paginateLinks = function paginateLinks(paginateWrap, total, current) {\n  if (total > 1) {\n    var page_links = '';\n    var prev_class = current && 1 < current ? 'prev' : 'paginate-none';\n    page_links += '<button class=\"' + prev_class + '\" data-page=\"' + (current - 1) + '\">Previous</button>';\n    var dots = false;\n    page_links += '<div class=\"paginate-wrap\">';\n    for (var n = 1; n <= total; n++) {\n      if (n === current) {\n        page_links += '<div class=\"current\">' + n + '</div>';\n        dots = true;\n      } else {\n        if (n <= 1 || current && n >= current - 1 && n <= current + 1 || n > total - 1) {\n          page_links += '<button class=\"page-numbers\" data-page=\"' + n + '\">' + n + '</button>';\n          dots = true;\n        } else if (dots) {\n          page_links += '<div class=\"dots\">&hellip;</div>';\n          dots = false;\n        }\n      }\n    }\n    page_links += '</div>';\n    var next_class = current && current < total ? 'next' : 'paginate-none';\n    page_links += '<button class=\"' + next_class + '\" data-page=\"' + (current + 1) + '\">Next</button>';\n    paginateWrap.style.display = '';\n    paginateWrap.innerHTML = page_links;\n  } else {\n    paginateWrap.style.display = 'none';\n    paginateWrap.innerHTML = '';\n  }\n};\n\n//# sourceURL=webpack://acf-blocks-theme/./js/app/functions.js?\n}");

/***/ },

/***/ "./js/script.js"
/*!**********************!*\
  !*** ./js/script.js ***!
  \**********************/
(__unused_webpack___webpack_module__, __webpack_exports__, __webpack_require__) {

eval("{__webpack_require__.r(__webpack_exports__);\n/* harmony import */ var _app_functions_js__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./app/functions.js */ \"./js/app/functions.js\");\n\n(function ($) {})(jQuery);\n\n// ------------ Deleting placeholder focus ------------ //\nfunction focusFnInput(target) {\n  if (target.getAttribute('placeholder') !== null) {\n    target.setAttribute('data-placeholder', target.getAttribute('placeholder'));\n    target.setAttribute('placeholder', '');\n  }\n}\ndocument.addEventListener('focus', function (event) {\n  for (var target = event.target; target && target !== this; target = target.parentNode) {\n    if (target.matches('input, textarea')) {\n      focusFnInput.call(this, target, event);\n      break;\n    }\n  }\n}, true);\nfunction blurFnInput(target) {\n  if (target.getAttribute('data-placeholder') !== null) {\n    target.setAttribute('placeholder', target.getAttribute('data-placeholder'));\n  }\n}\ndocument.addEventListener('blur', function (event) {\n  for (var target = event.target; target && target !== this; target = target.parentNode) {\n    if (target.matches('input, textarea')) {\n      blurFnInput.call(this, target, event);\n      break;\n    }\n  }\n}, true);\n// ---------- End Deleting placeholder focus ---------- //\n\n//# sourceURL=webpack://acf-blocks-theme/./js/script.js?\n}");

/***/ }

/******/ 	});
/************************************************************************/
/******/ 	// The module cache
/******/ 	var __webpack_module_cache__ = {};
/******/ 	
/******/ 	// The require function
/******/ 	function __webpack_require__(moduleId) {
/******/ 		// Check if module is in cache
/******/ 		var cachedModule = __webpack_module_cache__[moduleId];
/******/ 		if (cachedModule !== undefined) {
/******/ 			return cachedModule.exports;
/******/ 		}
/******/ 		// Create a new module (and put it into the cache)
/******/ 		var module = __webpack_module_cache__[moduleId] = {
/******/ 			// no module.id needed
/******/ 			// no module.loaded needed
/******/ 			exports: {}
/******/ 		};
/******/ 	
/******/ 		// Execute the module function
/******/ 		if (!(moduleId in __webpack_modules__)) {
/******/ 			delete __webpack_module_cache__[moduleId];
/******/ 			var e = new Error("Cannot find module '" + moduleId + "'");
/******/ 			e.code = 'MODULE_NOT_FOUND';
/******/ 			throw e;
/******/ 		}
/******/ 		__webpack_modules__[moduleId](module, module.exports, __webpack_require__);
/******/ 	
/******/ 		// Return the exports of the module
/******/ 		return module.exports;
/******/ 	}
/******/ 	
/************************************************************************/
/******/ 	/* webpack/runtime/define property getters */
/******/ 	(() => {
/******/ 		// define getter functions for harmony exports
/******/ 		__webpack_require__.d = (exports, definition) => {
/******/ 			for(var key in definition) {
/******/ 				if(__webpack_require__.o(definition, key) && !__webpack_require__.o(exports, key)) {
/******/ 					Object.defineProperty(exports, key, { enumerable: true, get: definition[key] });
/******/ 				}
/******/ 			}
/******/ 		};
/******/ 	})();
/******/ 	
/******/ 	/* webpack/runtime/hasOwnProperty shorthand */
/******/ 	(() => {
/******/ 		__webpack_require__.o = (obj, prop) => (Object.prototype.hasOwnProperty.call(obj, prop))
/******/ 	})();
/******/ 	
/******/ 	/* webpack/runtime/make namespace object */
/******/ 	(() => {
/******/ 		// define __esModule on exports
/******/ 		__webpack_require__.r = (exports) => {
/******/ 			if(typeof Symbol !== 'undefined' && Symbol.toStringTag) {
/******/ 				Object.defineProperty(exports, Symbol.toStringTag, { value: 'Module' });
/******/ 			}
/******/ 			Object.defineProperty(exports, '__esModule', { value: true });
/******/ 		};
/******/ 	})();
/******/ 	
/************************************************************************/
/******/ 	
/******/ 	// startup
/******/ 	// Load entry module and return exports
/******/ 	// This entry module can't be inlined because the eval devtool is used.
/******/ 	var __webpack_exports__ = __webpack_require__("./js/script.js");
/******/ 	
/******/ })()
;