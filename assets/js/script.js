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

/***/ "./js/app/functions.js":
/*!*****************************!*\
  !*** ./js/app/functions.js ***!
  \*****************************/
/***/ ((__unused_webpack___webpack_module__, __webpack_exports__, __webpack_require__) => {

eval("__webpack_require__.r(__webpack_exports__);\n/* harmony export */ __webpack_require__.d(__webpack_exports__, {\n/* harmony export */   clamp: () => (/* binding */ clamp),\n/* harmony export */   isEven: () => (/* binding */ isEven),\n/* harmony export */   isjQuery: () => (/* binding */ isjQuery),\n/* harmony export */   paginateLinks: () => (/* binding */ paginateLinks),\n/* harmony export */   renderBlock: () => (/* binding */ renderBlock),\n/* harmony export */   videoResize: () => (/* binding */ videoResize)\n/* harmony export */ });\n/**\n * is jQuery\n * @param obj\n * @returns {*}\n */\nconst isjQuery = obj => obj instanceof jQuery ? obj[0] : obj;\n\n/**\n * is Even\n * @param num\n * @returns {boolean}\n */\nconst isEven = num => num % 2 === 0;\n\n/**\n * Video Adaptive Resize\n * @param elements\n * @param className\n */\nconst videoResize = (elements, className) => {\n  function wrapperVideo(parent, className) {\n    const wrapper = document.createElement('div');\n    if (className !== undefined) wrapper.classList = className;\n    wrapper.setAttribute('style', 'position: absolute;top: 0;left: 0;width: 100%;height: 100%;overflow: hidden;');\n    parent.parentNode.insertBefore(wrapper, parent);\n    wrapper.appendChild(parent);\n  }\n  document.querySelectorAll(elements).forEach(el => {\n    wrapperVideo(el, className);\n    let fnResize = () => {\n      // Get a native video size\n      let videoHeight = el.videoHeight;\n      let videoWidth = el.videoWidth;\n\n      // Get a wrapper size\n      let wrapperHeight = el.parentNode.offsetHeight;\n      let wrapperWidth = el.parentNode.offsetWidth;\n      if (wrapperWidth / videoWidth > wrapperHeight / videoHeight) {\n        el.setAttribute('style', 'width:' + (wrapperWidth + 3) + 'px;height:auto;position: absolute;top: 50%;left: 50%;transform: translate(-50%, -50%);');\n      } else {\n        el.setAttribute('style', 'width:auto;height:' + (wrapperHeight + 3) + 'px;position: absolute;top: 50%;left: 50%;transform: translate(-50%, -50%);');\n      }\n    };\n    fnResize();\n    window.addEventListener('resize', fnResize);\n  });\n};\n\n/**\n * Render Block\n * @param type\n * @param fn\n */\nconst renderBlock = (type = '', fn) => {\n  if (typeof wp !== 'undefined' && typeof wp.domReady !== 'undefined') {\n    wp.domReady(() => {\n      if (typeof wp.data !== 'undefined' && typeof wp.data.select('core/editor') !== 'undefined' && typeof acf !== 'undefined') {\n        let blockElement = el => {\n          let element = isjQuery(el).querySelector('.' + wp_ajax.prefix + '-' + type);\n          return !!element ? element : isjQuery(el);\n        };\n        acf.addAction('render_block_preview/type=' + type, el => fn(blockElement(el), true));\n      }\n    });\n  } else {\n    document.querySelectorAll('.' + wp_ajax.prefix + '-' + type).forEach(el => fn(el, false));\n  }\n};\n\n/**\n * Fluid-responsive\n * @param min_size\n * @param max_size\n * @param min_viewport\n * @param max_viewport\n * @returns {string}\n */\nconst clamp = (min_size, max_size, min_viewport = 576, max_viewport = 1400) => {\n  const view_port_width_offset = min_viewport / 100 / 16 + 'rem';\n  const size_difference = max_size - min_size;\n  const viewport_difference = max_viewport - min_viewport;\n  const linear_factor = (size_difference / viewport_difference * 100).toFixed(4);\n  const fluid_target_size = min_size / 16 + \"rem + ((1vw - \" + view_port_width_offset + \") * \" + linear_factor + \")\";\n  let result = \"\";\n  if (min_size === max_size) {\n    result = min_size / 16 + 'rem';\n  } else if (min_size > max_size) {\n    result = \"clamp(\" + max_size / 16 + \"rem, \" + fluid_target_size + \", \" + min_size / 16 + \"rem)\";\n  } else if (min_size < max_size) {\n    result = \"clamp(\" + min_size / 16 + \"rem, \" + fluid_target_size + \", \" + max_size / 16 + \"rem)\";\n  }\n  return result;\n};\n\n/**\n * Paginate Links\n * @param paginateWrap\n * @param total\n * @param current\n */\nconst paginateLinks = (paginateWrap, total, current) => {\n  if (total > 1) {\n    let page_links = '';\n    let prev_class = current && 1 < current ? 'prev' : 'paginate-none';\n    page_links += '<button class=\"' + prev_class + '\" data-page=\"' + (current - 1) + '\">Previous</button>';\n    let dots = false;\n    page_links += '<div class=\"paginate-wrap\">';\n    for (let n = 1; n <= total; n++) {\n      if (n === current) {\n        page_links += '<div class=\"current\">' + n + '</div>';\n        dots = true;\n      } else {\n        if (n <= 1 || current && n >= current - 1 && n <= current + 1 || n > total - 1) {\n          page_links += '<button class=\"page-numbers\" data-page=\"' + n + '\">' + n + '</button>';\n          dots = true;\n        } else if (dots) {\n          page_links += '<div class=\"dots\">&hellip;</div>';\n          dots = false;\n        }\n      }\n    }\n    page_links += '</div>';\n    let next_class = current && current < total ? 'next' : 'paginate-none';\n    page_links += '<button class=\"' + next_class + '\" data-page=\"' + (current + 1) + '\">Next</button>';\n    paginateWrap.style.display = '';\n    paginateWrap.innerHTML = page_links;\n  } else {\n    paginateWrap.style.display = 'none';\n    paginateWrap.innerHTML = '';\n  }\n};\n\n//# sourceURL=webpack://acf-blocks-theme/./js/app/functions.js?");

/***/ }),

/***/ "./js/script.js":
/*!**********************!*\
  !*** ./js/script.js ***!
  \**********************/
/***/ ((__unused_webpack___webpack_module__, __webpack_exports__, __webpack_require__) => {

eval("__webpack_require__.r(__webpack_exports__);\n/* harmony import */ var _app_functions_js__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./app/functions.js */ \"./js/app/functions.js\");\n\n(function ($) {})(jQuery);\n\n// ------------ Deleting placeholder focus ------------ //\nfunction focusFnInput(target) {\n  if (target.getAttribute('placeholder') !== null) {\n    target.setAttribute('data-placeholder', target.getAttribute('placeholder'));\n    target.setAttribute('placeholder', '');\n  }\n}\ndocument.addEventListener('focus', function (event) {\n  for (let target = event.target; target && target !== this; target = target.parentNode) {\n    if (target.matches('input, textarea')) {\n      focusFnInput.call(this, target, event);\n      break;\n    }\n  }\n}, true);\nfunction blurFnInput(target) {\n  if (target.getAttribute('data-placeholder') !== null) {\n    target.setAttribute('placeholder', target.getAttribute('data-placeholder'));\n  }\n}\ndocument.addEventListener('blur', function (event) {\n  for (let target = event.target; target && target !== this; target = target.parentNode) {\n    if (target.matches('input, textarea')) {\n      blurFnInput.call(this, target, event);\n      break;\n    }\n  }\n}, true);\n// ---------- End Deleting placeholder focus ---------- //\n\n//# sourceURL=webpack://acf-blocks-theme/./js/script.js?");

/***/ })

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