module.exports =
/******/ (function(modules) { // webpackBootstrap
/******/ 	// The module cache
/******/ 	var installedModules = {};
/******/
/******/ 	// The require function
/******/ 	function __webpack_require__(moduleId) {
/******/
/******/ 		// Check if module is in cache
/******/ 		if(installedModules[moduleId]) {
/******/ 			return installedModules[moduleId].exports;
/******/ 		}
/******/ 		// Create a new module (and put it into the cache)
/******/ 		var module = installedModules[moduleId] = {
/******/ 			i: moduleId,
/******/ 			l: false,
/******/ 			exports: {}
/******/ 		};
/******/
/******/ 		// Execute the module function
/******/ 		modules[moduleId].call(module.exports, module, module.exports, __webpack_require__);
/******/
/******/ 		// Flag the module as loaded
/******/ 		module.l = true;
/******/
/******/ 		// Return the exports of the module
/******/ 		return module.exports;
/******/ 	}
/******/
/******/
/******/ 	// expose the modules object (__webpack_modules__)
/******/ 	__webpack_require__.m = modules;
/******/
/******/ 	// expose the module cache
/******/ 	__webpack_require__.c = installedModules;
/******/
/******/ 	// define getter function for harmony exports
/******/ 	__webpack_require__.d = function(exports, name, getter) {
/******/ 		if(!__webpack_require__.o(exports, name)) {
/******/ 			Object.defineProperty(exports, name, { enumerable: true, get: getter });
/******/ 		}
/******/ 	};
/******/
/******/ 	// define __esModule on exports
/******/ 	__webpack_require__.r = function(exports) {
/******/ 		if(typeof Symbol !== 'undefined' && Symbol.toStringTag) {
/******/ 			Object.defineProperty(exports, Symbol.toStringTag, { value: 'Module' });
/******/ 		}
/******/ 		Object.defineProperty(exports, '__esModule', { value: true });
/******/ 	};
/******/
/******/ 	// create a fake namespace object
/******/ 	// mode & 1: value is a module id, require it
/******/ 	// mode & 2: merge all properties of value into the ns
/******/ 	// mode & 4: return value when already ns object
/******/ 	// mode & 8|1: behave like require
/******/ 	__webpack_require__.t = function(value, mode) {
/******/ 		if(mode & 1) value = __webpack_require__(value);
/******/ 		if(mode & 8) return value;
/******/ 		if((mode & 4) && typeof value === 'object' && value && value.__esModule) return value;
/******/ 		var ns = Object.create(null);
/******/ 		__webpack_require__.r(ns);
/******/ 		Object.defineProperty(ns, 'default', { enumerable: true, value: value });
/******/ 		if(mode & 2 && typeof value != 'string') for(var key in value) __webpack_require__.d(ns, key, function(key) { return value[key]; }.bind(null, key));
/******/ 		return ns;
/******/ 	};
/******/
/******/ 	// getDefaultExport function for compatibility with non-harmony modules
/******/ 	__webpack_require__.n = function(module) {
/******/ 		var getter = module && module.__esModule ?
/******/ 			function getDefault() { return module['default']; } :
/******/ 			function getModuleExports() { return module; };
/******/ 		__webpack_require__.d(getter, 'a', getter);
/******/ 		return getter;
/******/ 	};
/******/
/******/ 	// Object.prototype.hasOwnProperty.call
/******/ 	__webpack_require__.o = function(object, property) { return Object.prototype.hasOwnProperty.call(object, property); };
/******/
/******/ 	// __webpack_public_path__
/******/ 	__webpack_require__.p = "";
/******/
/******/
/******/ 	// Load entry module and return exports
/******/ 	return __webpack_require__(__webpack_require__.s = "./forum.js");
/******/ })
/************************************************************************/
/******/ ({

/***/ "./forum.js":
/*!******************!*\
  !*** ./forum.js ***!
  \******************/
/*! no exports provided */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _src_forum__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./src/forum */ "./src/forum/index.js");
/* empty/unused harmony star reexport */

/***/ }),

/***/ "./node_modules/@babel/runtime/helpers/esm/extends.js":
/*!************************************************************!*\
  !*** ./node_modules/@babel/runtime/helpers/esm/extends.js ***!
  \************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "default", function() { return _extends; });
function _extends() {
  _extends = Object.assign || function (target) {
    for (var i = 1; i < arguments.length; i++) {
      var source = arguments[i];

      for (var key in source) {
        if (Object.prototype.hasOwnProperty.call(source, key)) {
          target[key] = source[key];
        }
      }
    }

    return target;
  };

  return _extends.apply(this, arguments);
}

/***/ }),

/***/ "./node_modules/@babel/runtime/helpers/esm/inheritsLoose.js":
/*!******************************************************************!*\
  !*** ./node_modules/@babel/runtime/helpers/esm/inheritsLoose.js ***!
  \******************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "default", function() { return _inheritsLoose; });
function _inheritsLoose(subClass, superClass) {
  subClass.prototype = Object.create(superClass.prototype);
  subClass.prototype.constructor = subClass;
  subClass.__proto__ = superClass;
}

/***/ }),

/***/ "./src/common/augmentEditUserModal.js":
/*!********************************************!*\
  !*** ./src/common/augmentEditUserModal.js ***!
  \********************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "default", function() { return augmentEditUserModal; });
/* harmony import */ var flarum_common_extend__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! flarum/common/extend */ "flarum/common/extend");
/* harmony import */ var flarum_common_extend__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(flarum_common_extend__WEBPACK_IMPORTED_MODULE_0__);
/* harmony import */ var flarum_common_components_EditUserModal__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! flarum/common/components/EditUserModal */ "flarum/common/components/EditUserModal");
/* harmony import */ var flarum_common_components_EditUserModal__WEBPACK_IMPORTED_MODULE_1___default = /*#__PURE__*/__webpack_require__.n(flarum_common_components_EditUserModal__WEBPACK_IMPORTED_MODULE_1__);
/* harmony import */ var flarum_common_components_GroupBadge__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! flarum/common/components/GroupBadge */ "flarum/common/components/GroupBadge");
/* harmony import */ var flarum_common_components_GroupBadge__WEBPACK_IMPORTED_MODULE_2___default = /*#__PURE__*/__webpack_require__.n(flarum_common_components_GroupBadge__WEBPACK_IMPORTED_MODULE_2__);
/* harmony import */ var flarum_common_components_LoadingIndicator__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! flarum/common/components/LoadingIndicator */ "flarum/common/components/LoadingIndicator");
/* harmony import */ var flarum_common_components_LoadingIndicator__WEBPACK_IMPORTED_MODULE_3___default = /*#__PURE__*/__webpack_require__.n(flarum_common_components_LoadingIndicator__WEBPACK_IMPORTED_MODULE_3__);
/* harmony import */ var flarum_common_utils_ItemList__WEBPACK_IMPORTED_MODULE_4__ = __webpack_require__(/*! flarum/common/utils/ItemList */ "flarum/common/utils/ItemList");
/* harmony import */ var flarum_common_utils_ItemList__WEBPACK_IMPORTED_MODULE_4___default = /*#__PURE__*/__webpack_require__.n(flarum_common_utils_ItemList__WEBPACK_IMPORTED_MODULE_4__);
/* harmony import */ var _utils_managedGroups__WEBPACK_IMPORTED_MODULE_5__ = __webpack_require__(/*! ./utils/managedGroups */ "./src/common/utils/managedGroups.js");






function augmentEditUserModal() {
  Object(flarum_common_extend__WEBPACK_IMPORTED_MODULE_0__["extend"])(flarum_common_components_EditUserModal__WEBPACK_IMPORTED_MODULE_1___default.a.prototype, "oninit", function () {
    var _this = this;

    this.loading = true;
    app.store.find("criteria").then(function (criteria) {
      Object(_utils_managedGroups__WEBPACK_IMPORTED_MODULE_5__["default"])(criteria).forEach(function (group) {
        return delete _this.groups[group.id()];
      });
      _this.loading = false;
      m.redraw();
    });
  });
  Object(flarum_common_extend__WEBPACK_IMPORTED_MODULE_0__["override"])(flarum_common_components_EditUserModal__WEBPACK_IMPORTED_MODULE_1___default.a.prototype, "fields", function (original) {
    var _this2 = this;

    if (this.loading) {
      var _items = new flarum_common_utils_ItemList__WEBPACK_IMPORTED_MODULE_4___default.a();

      _items.add("loading", m(flarum_common_components_LoadingIndicator__WEBPACK_IMPORTED_MODULE_3___default.a, null));

      return _items;
    }

    var items = original();
    items.add("Criteria", m("div", {
      className: "Form-group"
    }, m("label", null, app.translator.trans("askvortsov-auto-moderator.forum.edit_user.managed_groups_heading")), Object(_utils_managedGroups__WEBPACK_IMPORTED_MODULE_5__["default"])(app.store.all("criteria")).map(function (group) {
      return m("label", {
        className: "checkbox"
      }, m("input", {
        type: "checkbox",
        checked: _this2.attrs.user.groups().includes(group),
        disabled: true
      }), app.translator.trans("askvortsov-auto-moderator.forum.edit_user.managed_group", {
        badge: flarum_common_components_GroupBadge__WEBPACK_IMPORTED_MODULE_2___default.a.component({
          group: group,
          label: ""
        }),
        groupName: Criterion.group().nameSingular()
      }));
    }), m("p", null, app.translator.trans("askvortsov-auto-moderator.forum.edit_user.groups_not_editable"))), 10);
    return items;
  });
}

/***/ }),

/***/ "./src/common/models/Criterion.js":
/*!****************************************!*\
  !*** ./src/common/models/Criterion.js ***!
  \****************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "default", function() { return Criterion; });
/* harmony import */ var _babel_runtime_helpers_esm_extends__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! @babel/runtime/helpers/esm/extends */ "./node_modules/@babel/runtime/helpers/esm/extends.js");
/* harmony import */ var _babel_runtime_helpers_esm_inheritsLoose__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! @babel/runtime/helpers/esm/inheritsLoose */ "./node_modules/@babel/runtime/helpers/esm/inheritsLoose.js");
/* harmony import */ var flarum_Model__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! flarum/Model */ "flarum/Model");
/* harmony import */ var flarum_Model__WEBPACK_IMPORTED_MODULE_2___default = /*#__PURE__*/__webpack_require__.n(flarum_Model__WEBPACK_IMPORTED_MODULE_2__);




var Criterion = /*#__PURE__*/function (_Model) {
  Object(_babel_runtime_helpers_esm_inheritsLoose__WEBPACK_IMPORTED_MODULE_1__["default"])(Criterion, _Model);

  function Criterion() {
    return _Model.apply(this, arguments) || this;
  }

  return Criterion;
}(flarum_Model__WEBPACK_IMPORTED_MODULE_2___default.a);



Object(_babel_runtime_helpers_esm_extends__WEBPACK_IMPORTED_MODULE_0__["default"])(Criterion.prototype, {
  name: flarum_Model__WEBPACK_IMPORTED_MODULE_2___default.a.attribute("name"),
  description: flarum_Model__WEBPACK_IMPORTED_MODULE_2___default.a.attribute("description"),
  actions: flarum_Model__WEBPACK_IMPORTED_MODULE_2___default.a.attribute("actions"),
  metrics: flarum_Model__WEBPACK_IMPORTED_MODULE_2___default.a.attribute("metrics"),
  requirements: flarum_Model__WEBPACK_IMPORTED_MODULE_2___default.a.attribute("requirements"),
  isValid: flarum_Model__WEBPACK_IMPORTED_MODULE_2___default.a.attribute("isValid"),
  invalidActionSettings: flarum_Model__WEBPACK_IMPORTED_MODULE_2___default.a.attribute("invalidActionSettings")
});

/***/ }),

/***/ "./src/common/registerModels.js":
/*!**************************************!*\
  !*** ./src/common/registerModels.js ***!
  \**************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "default", function() { return registerModels; });
/* harmony import */ var flarum_Model__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! flarum/Model */ "flarum/Model");
/* harmony import */ var flarum_Model__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(flarum_Model__WEBPACK_IMPORTED_MODULE_0__);
/* harmony import */ var flarum_models_User__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! flarum/models/User */ "flarum/models/User");
/* harmony import */ var flarum_models_User__WEBPACK_IMPORTED_MODULE_1___default = /*#__PURE__*/__webpack_require__.n(flarum_models_User__WEBPACK_IMPORTED_MODULE_1__);
/* harmony import */ var _models_Criterion__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ./models/Criterion */ "./src/common/models/Criterion.js");



function registerModels() {
  app.store.models.criteria = _models_Criterion__WEBPACK_IMPORTED_MODULE_2__["default"];
  flarum_models_User__WEBPACK_IMPORTED_MODULE_1___default.a.prototype.criteria = flarum_Model__WEBPACK_IMPORTED_MODULE_0___default.a.hasMany("criteria");
}

/***/ }),

/***/ "./src/common/utils/managedGroups.js":
/*!*******************************************!*\
  !*** ./src/common/utils/managedGroups.js ***!
  \*******************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "default", function() { return managedGroups; });
function managedGroups(criteria) {
  return criteria.filter(function (criterion) {
    return criterion.actions();
  }).reduce(function (acc, criterion) {
    var ids = criterion.actions().filter(function (a) {
      return a.type === 'add_to_group' || a.type === 'remove_from_group';
    }).map(function (a) {
      return a.settings['group_id'];
    });
    acc.push.apply(acc, ids);
  }, []).map(function (groupId) {
    return app.store.getById('groups', groupId);
  }).filter(function (g) {
    return g;
  });
}

/***/ }),

/***/ "./src/forum/index.js":
/*!****************************!*\
  !*** ./src/forum/index.js ***!
  \****************************/
/*! no exports provided */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _common_augmentEditUserModal__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ../common/augmentEditUserModal */ "./src/common/augmentEditUserModal.js");
/* harmony import */ var _common_registerModels__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ../common/registerModels */ "./src/common/registerModels.js");


app.initializers.add("askvortsov/flarum-auto-moderator", function () {
  Object(_common_registerModels__WEBPACK_IMPORTED_MODULE_1__["default"])();
  Object(_common_augmentEditUserModal__WEBPACK_IMPORTED_MODULE_0__["default"])();
});

/***/ }),

/***/ "flarum/Model":
/*!**********************************************!*\
  !*** external "flarum.core.compat['Model']" ***!
  \**********************************************/
/*! no static exports found */
/***/ (function(module, exports) {

module.exports = flarum.core.compat['Model'];

/***/ }),

/***/ "flarum/common/components/EditUserModal":
/*!************************************************************************!*\
  !*** external "flarum.core.compat['common/components/EditUserModal']" ***!
  \************************************************************************/
/*! no static exports found */
/***/ (function(module, exports) {

module.exports = flarum.core.compat['common/components/EditUserModal'];

/***/ }),

/***/ "flarum/common/components/GroupBadge":
/*!*********************************************************************!*\
  !*** external "flarum.core.compat['common/components/GroupBadge']" ***!
  \*********************************************************************/
/*! no static exports found */
/***/ (function(module, exports) {

module.exports = flarum.core.compat['common/components/GroupBadge'];

/***/ }),

/***/ "flarum/common/components/LoadingIndicator":
/*!***************************************************************************!*\
  !*** external "flarum.core.compat['common/components/LoadingIndicator']" ***!
  \***************************************************************************/
/*! no static exports found */
/***/ (function(module, exports) {

module.exports = flarum.core.compat['common/components/LoadingIndicator'];

/***/ }),

/***/ "flarum/common/extend":
/*!******************************************************!*\
  !*** external "flarum.core.compat['common/extend']" ***!
  \******************************************************/
/*! no static exports found */
/***/ (function(module, exports) {

module.exports = flarum.core.compat['common/extend'];

/***/ }),

/***/ "flarum/common/utils/ItemList":
/*!**************************************************************!*\
  !*** external "flarum.core.compat['common/utils/ItemList']" ***!
  \**************************************************************/
/*! no static exports found */
/***/ (function(module, exports) {

module.exports = flarum.core.compat['common/utils/ItemList'];

/***/ }),

/***/ "flarum/models/User":
/*!****************************************************!*\
  !*** external "flarum.core.compat['models/User']" ***!
  \****************************************************/
/*! no static exports found */
/***/ (function(module, exports) {

module.exports = flarum.core.compat['models/User'];

/***/ })

/******/ });
//# sourceMappingURL=forum.js.map