/******/ (function() { // webpackBootstrap
/******/ 	var __webpack_modules__ = ({

/***/ "./assets/src/js/one-author-ajax.js":
/*!******************************************!*\
  !*** ./assets/src/js/one-author-ajax.js ***!
  \******************************************/
/***/ (function() {

(function () {
  /**
   * Function used for enabling the disabled element.
   * @param {HTMLElement} element element which going to re-enable.
   */
  function enableIt(element) {
    element.setAttribute('disabled', false);
    element.style.cursor = 'pointer';
    element.style.opacity = 1;
  }
  var loadingEvent = new CustomEvent('waitPlease');
  var stopLoadEvent = new CustomEvent('noMoreWait');
  var idChangeEvent = new CustomEvent('idChanged');
  if (AjaxData) {
    var AjaxUrl = AjaxData.ajax_url;
    var AjaxNonce = AjaxData.ajax_nonce;
    var idElement = document.getElementById('one_auth_id');
    var nameElement = document.getElementById('one_auth_name');
    var authForm = document.getElementById('author-form');
    var imageTag = document.getElementById('one_auth_avatar');
    var submitImg = document.getElementById('avatar_submit');
    var alertsDiv = document.getElementById('alerts');
    var submitBtn = document.getElementById('one_auth_submit');
    alertsDiv.classList.add('hidden');
    submitImg.addEventListener('click', function () {
      submitImg.dispatchEvent(loadingEvent);
      var miniForm = new FormData(authForm);
      if (imageTag.files.length) {
        miniForm.append('one_auth_avatar', imageTag.files[0]);
        miniForm.append('mini_form_OTW', AjaxNonce);
        miniForm.append('action', 'reg_avatar');
        if (9 < miniForm.get('one_auth_id').length) {
          fetch(AjaxUrl, {
            method: 'POST',
            body: miniForm
          }).then(function (response) {
            return response.json();
          }).then(function (jsonRes) {
            if (jsonRes.success) {
              if (jsonRes.url) {
                document.getElementById('one_auth_img').setAttribute('src', jsonRes.url);
                enableIt(submitBtn);
              }
            }
          });
        } else {
          alertsDiv.classList.remove('hidden');
          var alert1 = document.createElement('li');
          alert1.innerHTML = 'Please select the user';
          alertsDiv.append(alert1);
        }
      } else {
        alertsDiv.classList.remove('hidden');
        var _alert = document.createElement('li');
        _alert.innerHTML = 'Please select the avatar image';
        alertsDiv.append(_alert);
      }
      submitImg.dispatchEvent(stopLoadEvent);
      submitBtn.innerHTML = 'Edit';
    });
    idElement.addEventListener('onAdminDemands', function () {
      submitImg.dispatchEvent(loadingEvent);
      var miniForm = new FormData();
      miniForm.append('mini_form_OTW', AjaxNonce);
      miniForm.append('action', 'gods_eye');
      miniForm.append('one_auth_id', idElement.value);
      fetch(AjaxUrl, {
        method: 'POST',
        body: miniForm
      }).then(function (response) {
        return response.json();
      }).then(function (jsonRes) {
        if (jsonRes.success) {
          document.getElementById('one_auth_img').setAttribute('src', jsonRes.author_display_img);
          document.getElementById('one_auth_display_name').value = jsonRes.author_name;
          document.getElementById('one_auth_punch_line').value = jsonRes.author_punch_line;
          document.getElementById('one_auth_description').value = jsonRes.author_about;
          for (var count in jsonRes.author_social_media) {
            var selectTag = document.getElementById('one_auth_select_' + parseInt(parseInt(count) + 1));
            var handle = jsonRes.author_social_media[count].handle;
            var url = jsonRes.author_social_media[count].url;
            selectTag.querySelector('option[value="' + handle + '"]').selected = true;
            document.getElementById('one_auth_social_' + parseInt(parseInt(count) + 1)).value = url;
            if (url) {
              enableIt(submitBtn);
            }
          }
        } else {
          var selectedUser = document.getElementById('one_auth_name').value;
          document.getElementById('author-form').reset();
          document.querySelector('option[value="' + selectedUser + '"]').selected = true;
          nameElement.dispatchEvent(idChangeEvent);
        }
        submitImg.dispatchEvent(stopLoadEvent);
      });
    });
    submitImg.addEventListener('waitPlease', function () {
      submitImg.classList.add('loader');
      submitImg.classList.remove('submit-btn');
    });
    submitImg.addEventListener('noMoreWait', function () {
      submitImg.classList.add('submit-btn');
      submitImg.classList.remove('loader');
    });
  }
})();

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
/******/ 	/* webpack/runtime/compat get default export */
/******/ 	!function() {
/******/ 		// getDefaultExport function for compatibility with non-harmony modules
/******/ 		__webpack_require__.n = function(module) {
/******/ 			var getter = module && module.__esModule ?
/******/ 				function() { return module['default']; } :
/******/ 				function() { return module; };
/******/ 			__webpack_require__.d(getter, { a: getter });
/******/ 			return getter;
/******/ 		};
/******/ 	}();
/******/ 	
/******/ 	/* webpack/runtime/define property getters */
/******/ 	!function() {
/******/ 		// define getter functions for harmony exports
/******/ 		__webpack_require__.d = function(exports, definition) {
/******/ 			for(var key in definition) {
/******/ 				if(__webpack_require__.o(definition, key) && !__webpack_require__.o(exports, key)) {
/******/ 					Object.defineProperty(exports, key, { enumerable: true, get: definition[key] });
/******/ 				}
/******/ 			}
/******/ 		};
/******/ 	}();
/******/ 	
/******/ 	/* webpack/runtime/hasOwnProperty shorthand */
/******/ 	!function() {
/******/ 		__webpack_require__.o = function(obj, prop) { return Object.prototype.hasOwnProperty.call(obj, prop); }
/******/ 	}();
/******/ 	
/******/ 	/* webpack/runtime/make namespace object */
/******/ 	!function() {
/******/ 		// define __esModule on exports
/******/ 		__webpack_require__.r = function(exports) {
/******/ 			if(typeof Symbol !== 'undefined' && Symbol.toStringTag) {
/******/ 				Object.defineProperty(exports, Symbol.toStringTag, { value: 'Module' });
/******/ 			}
/******/ 			Object.defineProperty(exports, '__esModule', { value: true });
/******/ 		};
/******/ 	}();
/******/ 	
/************************************************************************/
var __webpack_exports__ = {};
// This entry need to be wrapped in an IIFE because it need to be in strict mode.
!function() {
"use strict";
/*!*************************************!*\
  !*** ./assets/src/js/one-author.js ***!
  \*************************************/
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _one_author_ajax_js__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./one-author-ajax.js */ "./assets/src/js/one-author-ajax.js");
/* harmony import */ var _one_author_ajax_js__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(_one_author_ajax_js__WEBPACK_IMPORTED_MODULE_0__);

(function () {
  // /////////////////////////////////////////////////////////////////////// HTML Element selection  ///////////////////////////////
  var idElement = document.getElementById('one_auth_id');
  var nameElement = document.getElementById('one_auth_name');
  var submitBtn = document.getElementById('one_auth_submit');

  // /////////////////////////////////////////////////////////////////////// Function Declarations ///////////////////////////////
  /**
   * This function pulls out the value of 'data' attribute from the 'fromElement', and put it into 'toElement' as a value or innerHTML.
   * @param {HTMLElement} fromElement : HTML Element from which data attribute to be read.
   * @param {HTMLElement} toElement   : HTML Element to which read value write.
   */
  function setId(fromElement, toElement) {
    var idValue = fromElement.getAttribute('data');
    if (idValue) {
      toElement.value = 'User Id: ' + idValue;
    }
  }

  /**
   * Function used for disabling the element, Rejects the clicks and reduces the opacity of the element.
   * @param {HTMLElement} element element which going to disable.
   */
  function disabledIt(element) {
    element.setAttribute('disabled', true);
    element.style.cursor = 'not-allowed';
    element.style.opacity = 0.66;
  }
  var adminDemands = new CustomEvent('onAdminDemands');
  // ///////////////////////////////////////////////////////////////////////////// Actual Flow //////////////////////////////////

  disabledIt(submitBtn);
  if (nameElement && idElement) {
    setId(nameElement, idElement);
    ['change', 'idChanged'].forEach(function (event_) {
      nameElement.addEventListener(event_, function (event) {
        var subjectedElement = event.target;
        var optionNumber = subjectedElement.selectedIndex;
        var option = subjectedElement[optionNumber];
        setId(option, idElement);
        if (1 < nameElement.length) {
          idElement.dispatchEvent(adminDemands);
        }
        disabledIt(submitBtn);
      });
    });
  }
})();
}();
/******/ })()
;
//# sourceMappingURL=one-author-min.js.map