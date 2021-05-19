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
/******/ 	return __webpack_require__(__webpack_require__.s = "./admin.js");
/******/ })
/************************************************************************/
/******/ ({

/***/ "./admin.js":
/*!******************!*\
  !*** ./admin.js ***!
  \******************/
/*! no exports provided */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _src_admin__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./src/admin */ "./src/admin/index.js");
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

/***/ "./src/admin/components/AutoModeratorPage.js":
/*!***************************************************!*\
  !*** ./src/admin/components/AutoModeratorPage.js ***!
  \***************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "default", function() { return AutoModeratorPage; });
/* harmony import */ var _babel_runtime_helpers_esm_inheritsLoose__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! @babel/runtime/helpers/esm/inheritsLoose */ "./node_modules/@babel/runtime/helpers/esm/inheritsLoose.js");
/* harmony import */ var flarum_admin_components_ExtensionPage__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! flarum/admin/components/ExtensionPage */ "flarum/admin/components/ExtensionPage");
/* harmony import */ var flarum_admin_components_ExtensionPage__WEBPACK_IMPORTED_MODULE_1___default = /*#__PURE__*/__webpack_require__.n(flarum_admin_components_ExtensionPage__WEBPACK_IMPORTED_MODULE_1__);
/* harmony import */ var flarum_common_components_Link__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! flarum/common/components/Link */ "flarum/common/components/Link");
/* harmony import */ var flarum_common_components_Link__WEBPACK_IMPORTED_MODULE_2___default = /*#__PURE__*/__webpack_require__.n(flarum_common_components_Link__WEBPACK_IMPORTED_MODULE_2__);
/* harmony import */ var flarum_common_components_LoadingIndicator__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! flarum/common/components/LoadingIndicator */ "flarum/common/components/LoadingIndicator");
/* harmony import */ var flarum_common_components_LoadingIndicator__WEBPACK_IMPORTED_MODULE_3___default = /*#__PURE__*/__webpack_require__.n(flarum_common_components_LoadingIndicator__WEBPACK_IMPORTED_MODULE_3__);
/* harmony import */ var flarum_common_components_Tooltip__WEBPACK_IMPORTED_MODULE_4__ = __webpack_require__(/*! flarum/common/components/Tooltip */ "flarum/common/components/Tooltip");
/* harmony import */ var flarum_common_components_Tooltip__WEBPACK_IMPORTED_MODULE_4___default = /*#__PURE__*/__webpack_require__.n(flarum_common_components_Tooltip__WEBPACK_IMPORTED_MODULE_4__);
/* harmony import */ var flarum_common_helpers_icon__WEBPACK_IMPORTED_MODULE_5__ = __webpack_require__(/*! flarum/common/helpers/icon */ "flarum/common/helpers/icon");
/* harmony import */ var flarum_common_helpers_icon__WEBPACK_IMPORTED_MODULE_5___default = /*#__PURE__*/__webpack_require__.n(flarum_common_helpers_icon__WEBPACK_IMPORTED_MODULE_5__);
/* harmony import */ var flarum_common_utils_classList__WEBPACK_IMPORTED_MODULE_6__ = __webpack_require__(/*! flarum/common/utils/classList */ "flarum/common/utils/classList");
/* harmony import */ var flarum_common_utils_classList__WEBPACK_IMPORTED_MODULE_6___default = /*#__PURE__*/__webpack_require__.n(flarum_common_utils_classList__WEBPACK_IMPORTED_MODULE_6__);
/* harmony import */ var flarum_common_utils_stringToColor__WEBPACK_IMPORTED_MODULE_7__ = __webpack_require__(/*! flarum/common/utils/stringToColor */ "flarum/common/utils/stringToColor");
/* harmony import */ var flarum_common_utils_stringToColor__WEBPACK_IMPORTED_MODULE_7___default = /*#__PURE__*/__webpack_require__.n(flarum_common_utils_stringToColor__WEBPACK_IMPORTED_MODULE_7__);









function criterionItem(criterion) {
  var name = criterion ? criterion.name() : app.translator.trans("askvortsov-auto-moderator.admin.automoderator_page.create_criterion_button");
  var iconName = criterion ? 'fas fa-bolt' : "fas fa-plus";
  var style = criterion ? {
    "background-color": flarum_common_utils_stringToColor__WEBPACK_IMPORTED_MODULE_7___default()(criterion.name()),
    color: "white"
  } : "";
  return m(flarum_common_components_Link__WEBPACK_IMPORTED_MODULE_2___default.a, {
    className: "ExtensionListItem",
    href: app.route.criterion(criterion)
  }, m("span", {
    className: "ExtensionListItem-icon ExtensionIcon",
    style: style
  }, flarum_common_helpers_icon__WEBPACK_IMPORTED_MODULE_5___default()(iconName)), m("span", {
    className: flarum_common_utils_classList__WEBPACK_IMPORTED_MODULE_6___default()({
      'ExtensionListItem-title': true,
      'ExtensionListItem--invalid': criterion && !criterion.isValid()
    })
  }, criterion && !criterion.isValid() && m(flarum_common_components_Tooltip__WEBPACK_IMPORTED_MODULE_4___default.a, {
    text: app.translator.trans('askvortsov-auto-moderator.admin.automoderator_page.criterion_invalid')
  }, flarum_common_helpers_icon__WEBPACK_IMPORTED_MODULE_5___default()('fas fa-exclamation-triangle')), name));
}

var AutoModeratorPage = /*#__PURE__*/function (_ExtensionPage) {
  Object(_babel_runtime_helpers_esm_inheritsLoose__WEBPACK_IMPORTED_MODULE_0__["default"])(AutoModeratorPage, _ExtensionPage);

  function AutoModeratorPage() {
    return _ExtensionPage.apply(this, arguments) || this;
  }

  var _proto = AutoModeratorPage.prototype;

  _proto.oninit = function oninit(vnode) {
    var _this = this;

    _ExtensionPage.prototype.oninit.call(this, vnode);

    this.loading = true;
    app.store.find("criteria").then(function () {
      _this.loading = false;
      m.redraw();
    });
  };

  _proto.content = function content() {
    if (this.loading) {
      return m("div", {
        className: "Criteria"
      }, m("div", {
        className: "container"
      }, m(flarum_common_components_LoadingIndicator__WEBPACK_IMPORTED_MODULE_3___default.a, null)));
    }

    return m("div", {
      className: "Criteria"
    }, m("div", {
      className: "container"
    }, m("div", {
      className: "ExtensionsWidget-list Criteria-list"
    }, m("p", {
      className: "Criteria-list-heading"
    }, app.translator.trans("askvortsov-auto-moderator.admin.automoderator_page.list_heading")), m("div", {
      className: "ExtensionList"
    }, [].concat(app.store.all("criteria").map(criterionItem), [criterionItem()]))), m("div", {
      className: "Criteria-footer"
    }, m("p", null, app.translator.trans("askvortsov-auto-moderator.admin.automoderator_page.instructions_header")), m("ul", null, app.translator.trans("askvortsov-auto-moderator.admin.automoderator_page.instructions_text")))));
  };

  return AutoModeratorPage;
}(flarum_admin_components_ExtensionPage__WEBPACK_IMPORTED_MODULE_1___default.a);



/***/ }),

/***/ "./src/admin/components/CriterionPage.js":
/*!***********************************************!*\
  !*** ./src/admin/components/CriterionPage.js ***!
  \***********************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "default", function() { return CriterionPage; });
/* harmony import */ var _babel_runtime_helpers_esm_extends__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! @babel/runtime/helpers/esm/extends */ "./node_modules/@babel/runtime/helpers/esm/extends.js");
/* harmony import */ var _babel_runtime_helpers_esm_inheritsLoose__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! @babel/runtime/helpers/esm/inheritsLoose */ "./node_modules/@babel/runtime/helpers/esm/inheritsLoose.js");
/* harmony import */ var flarum_admin_components_AdminPage__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! flarum/admin/components/AdminPage */ "flarum/admin/components/AdminPage");
/* harmony import */ var flarum_admin_components_AdminPage__WEBPACK_IMPORTED_MODULE_2___default = /*#__PURE__*/__webpack_require__.n(flarum_admin_components_AdminPage__WEBPACK_IMPORTED_MODULE_2__);
/* harmony import */ var flarum_common_components_Alert__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! flarum/common/components/Alert */ "flarum/common/components/Alert");
/* harmony import */ var flarum_common_components_Alert__WEBPACK_IMPORTED_MODULE_3___default = /*#__PURE__*/__webpack_require__.n(flarum_common_components_Alert__WEBPACK_IMPORTED_MODULE_3__);
/* harmony import */ var flarum_common_components_Button__WEBPACK_IMPORTED_MODULE_4__ = __webpack_require__(/*! flarum/common/components/Button */ "flarum/common/components/Button");
/* harmony import */ var flarum_common_components_Button__WEBPACK_IMPORTED_MODULE_4___default = /*#__PURE__*/__webpack_require__.n(flarum_common_components_Button__WEBPACK_IMPORTED_MODULE_4__);
/* harmony import */ var flarum_common_components_LinkButton__WEBPACK_IMPORTED_MODULE_5__ = __webpack_require__(/*! flarum/common/components/LinkButton */ "flarum/common/components/LinkButton");
/* harmony import */ var flarum_common_components_LinkButton__WEBPACK_IMPORTED_MODULE_5___default = /*#__PURE__*/__webpack_require__.n(flarum_common_components_LinkButton__WEBPACK_IMPORTED_MODULE_5__);
/* harmony import */ var flarum_common_components_Select__WEBPACK_IMPORTED_MODULE_6__ = __webpack_require__(/*! flarum/common/components/Select */ "flarum/common/components/Select");
/* harmony import */ var flarum_common_components_Select__WEBPACK_IMPORTED_MODULE_6___default = /*#__PURE__*/__webpack_require__.n(flarum_common_components_Select__WEBPACK_IMPORTED_MODULE_6__);
/* harmony import */ var flarum_common_components_Tooltip__WEBPACK_IMPORTED_MODULE_7__ = __webpack_require__(/*! flarum/common/components/Tooltip */ "flarum/common/components/Tooltip");
/* harmony import */ var flarum_common_components_Tooltip__WEBPACK_IMPORTED_MODULE_7___default = /*#__PURE__*/__webpack_require__.n(flarum_common_components_Tooltip__WEBPACK_IMPORTED_MODULE_7__);
/* harmony import */ var flarum_common_components_LoadingIndicator__WEBPACK_IMPORTED_MODULE_8__ = __webpack_require__(/*! flarum/common/components/LoadingIndicator */ "flarum/common/components/LoadingIndicator");
/* harmony import */ var flarum_common_components_LoadingIndicator__WEBPACK_IMPORTED_MODULE_8___default = /*#__PURE__*/__webpack_require__.n(flarum_common_components_LoadingIndicator__WEBPACK_IMPORTED_MODULE_8__);
/* harmony import */ var flarum_common_helpers_icon__WEBPACK_IMPORTED_MODULE_9__ = __webpack_require__(/*! flarum/common/helpers/icon */ "flarum/common/helpers/icon");
/* harmony import */ var flarum_common_helpers_icon__WEBPACK_IMPORTED_MODULE_9___default = /*#__PURE__*/__webpack_require__.n(flarum_common_helpers_icon__WEBPACK_IMPORTED_MODULE_9__);
/* harmony import */ var flarum_common_utils_classList__WEBPACK_IMPORTED_MODULE_10__ = __webpack_require__(/*! flarum/common/utils/classList */ "flarum/common/utils/classList");
/* harmony import */ var flarum_common_utils_classList__WEBPACK_IMPORTED_MODULE_10___default = /*#__PURE__*/__webpack_require__.n(flarum_common_utils_classList__WEBPACK_IMPORTED_MODULE_10__);
/* harmony import */ var flarum_common_utils_Stream__WEBPACK_IMPORTED_MODULE_11__ = __webpack_require__(/*! flarum/common/utils/Stream */ "flarum/common/utils/Stream");
/* harmony import */ var flarum_common_utils_Stream__WEBPACK_IMPORTED_MODULE_11___default = /*#__PURE__*/__webpack_require__.n(flarum_common_utils_Stream__WEBPACK_IMPORTED_MODULE_11__);
/* harmony import */ var _MinMaxSelector__WEBPACK_IMPORTED_MODULE_12__ = __webpack_require__(/*! ./MinMaxSelector */ "./src/admin/components/MinMaxSelector.js");













var actionDefs;
var metricDefs;
var requirementDefs;

function metricItem(metric, selected) {
  var metricDef = metricDefs[metric.type];
  return m("li", null, m("div", {
    className: flarum_common_utils_classList__WEBPACK_IMPORTED_MODULE_10___default()({
      'DriverListItem-info': true,
      'DriverListItem--missingExt': metricDef.missingExt
    })
  }, metricDef.missingExt && m(flarum_common_components_Tooltip__WEBPACK_IMPORTED_MODULE_7___default.a, {
    text: app.translator.trans('askvortsov-auto-moderator.admin.criterion_page.driver_missing_ext')
  }, flarum_common_helpers_icon__WEBPACK_IMPORTED_MODULE_9___default()('fas fa-exclamation-triangle')), m("span", {
    className: "DriverListItem-name"
  }, app.translator.trans(metricDef.translationKey)), flarum_common_components_Button__WEBPACK_IMPORTED_MODULE_4___default.a.component({
    className: 'Button Button--link',
    icon: 'fas fa-trash-alt',
    onclick: function onclick() {
      return selected(selected().filter(function (val) {
        return val !== metric;
      }));
    }
  })), m(_MinMaxSelector__WEBPACK_IMPORTED_MODULE_12__["default"], {
    min: metric.min,
    max: metric.max
  }), m("hr", null));
}

function requirementItem(requirement) {}

function actionItem(action, selected) {
  var actionDef = actionDefs[action.type];
  var forms = app['askvortsov-auto-moderator'].actionDriverSettingsComponents;
  var settings;

  if (action.type in forms) {
    settings = forms[action.type].component({
      action: action,
      actionDef: actionDef
    });
  } else {
    settings = Object.keys(actionDef.availableSettings).map(function (s) {
      return m("div", {
        className: "Form-group"
      }, m("input", {
        className: "FormControl",
        value: action.settings[s],
        onchange: function onchange(e) {
          return action.settings[s] = e.target.value;
        },
        placeholder: app.translator.trans(actionDef.availableSettings[s])
      }));
    });
  }

  return m("li", null, m("div", {
    className: flarum_common_utils_classList__WEBPACK_IMPORTED_MODULE_10___default()({
      'DriverListItem-info': true,
      'DriverListItem--missingExt': actionDef.missingExt
    })
  }, actionDef.missingExt && m(flarum_common_components_Tooltip__WEBPACK_IMPORTED_MODULE_7___default.a, {
    text: app.translator.trans('askvortsov-auto-moderator.admin.criterion_page.driver_missing_ext')
  }, flarum_common_helpers_icon__WEBPACK_IMPORTED_MODULE_9___default()('fas fa-exclamation-triangle')), m("span", {
    className: "DriverListItem-name"
  }, app.translator.trans(actionDef.translationKey)), flarum_common_components_Button__WEBPACK_IMPORTED_MODULE_4___default.a.component({
    className: 'Button Button--link',
    icon: 'fas fa-trash-alt',
    onclick: function onclick() {
      return selected(selected().filter(function (val) {
        return val !== action;
      }));
    }
  }), m("div", {
    className: "DriverListItem-form"
  }, settings)), m("hr", null));
}

var CriterionPage = /*#__PURE__*/function (_AdminPage) {
  Object(_babel_runtime_helpers_esm_inheritsLoose__WEBPACK_IMPORTED_MODULE_1__["default"])(CriterionPage, _AdminPage);

  function CriterionPage() {
    return _AdminPage.apply(this, arguments) || this;
  }

  var _proto = CriterionPage.prototype;

  _proto.oninit = function oninit(vnode) {
    var _this = this;

    _AdminPage.prototype.oninit.call(this, vnode);

    this.id = m.route.param('id');
    this.name = flarum_common_utils_Stream__WEBPACK_IMPORTED_MODULE_11___default()('');
    this.description = flarum_common_utils_Stream__WEBPACK_IMPORTED_MODULE_11___default()('');
    this.actionsOnGain = flarum_common_utils_Stream__WEBPACK_IMPORTED_MODULE_11___default()([]);
    this.actionsOnLoss = flarum_common_utils_Stream__WEBPACK_IMPORTED_MODULE_11___default()([]);
    this.metrics = flarum_common_utils_Stream__WEBPACK_IMPORTED_MODULE_11___default()([]);
    this.requirements = flarum_common_utils_Stream__WEBPACK_IMPORTED_MODULE_11___default()([]);
    this.newMetric = flarum_common_utils_Stream__WEBPACK_IMPORTED_MODULE_11___default()('');
    this.newActionOnGain = flarum_common_utils_Stream__WEBPACK_IMPORTED_MODULE_11___default()('');
    this.newActionOnLoss = flarum_common_utils_Stream__WEBPACK_IMPORTED_MODULE_11___default()('');
    this.loadingDrivers = true;
    app.request({
      method: 'GET',
      url: app.forum.attribute('apiUrl') + '/automod_drivers'
    }).then(function (response) {
      actionDefs = response['data']['attributes']['action'];
      metricDefs = response['data']['attributes']['metric'];
      _this.loadingDrivers = false;
      m.redraw();
    });
    if (this.id === 'new') return;
    this.loadingCriterion = true;
    app.store.find('criteria', this.id).then(function (criterion) {
      _this.criterion = criterion;

      _this.name(criterion.name());

      _this.description(criterion.description());

      _this.metrics(criterion.metrics().map(function (m) {
        return {
          type: m.type,
          min: flarum_common_utils_Stream__WEBPACK_IMPORTED_MODULE_11___default()(m.min),
          max: flarum_common_utils_Stream__WEBPACK_IMPORTED_MODULE_11___default()(m.max)
        };
      }));

      _this.actionsOnGain(criterion.actions().filter(function (a) {
        return a.gain;
      }));

      _this.actionsOnLoss(criterion.actions().filter(function (a) {
        return !a.gain;
      }));

      _this.requirements(criterion.requirements());

      _this.loadingCriterion = false;
      m.redraw();
    });
  };

  _proto.headerInfo = function headerInfo() {
    var title;
    var description = '';

    if (this.loadingCriterion) {
      description = app.translator.trans('askvortsov-auto-moderator.admin.criterion_page.loading');
      title = app.translator.trans('askvortsov-auto-moderator.admin.criterion_page.loading');
    } else if (this.criterion) {
      title = this.criterion.name();
    } else {
      title = app.translator.trans('askvortsov-auto-moderator.admin.criterion_page.new_criterion');
    }

    return {
      className: 'CriterionPage',
      icon: 'fas fa-bolt',
      title: title,
      description: description
    };
  };

  _proto.content = function content() {
    if (this.loadingCriterion || this.loadingDrivers) {
      return m("div", {
        className: "Criteria"
      }, m("div", {
        className: "container"
      }, m(flarum_common_components_LoadingIndicator__WEBPACK_IMPORTED_MODULE_8___default.a, null)));
    }

    return m("div", {
      className: "Criteria"
    }, m("div", {
      className: "container"
    }, m("form", {
      onsubmit: this.onsubmit.bind(this)
    }, m("div", {
      className: "Form-group"
    }, m(flarum_common_components_LinkButton__WEBPACK_IMPORTED_MODULE_5___default.a, {
      className: "Button",
      icon: "fas fa-chevron-left",
      href: app.route('extension', {
        id: 'askvortsov-auto-moderator'
      })
    }, app.translator.trans("askvortsov-auto-moderator.admin.criterion_page.back"))), m("div", {
      className: "Form-group"
    }, this.errors()), m("div", {
      className: "Form-group"
    }, m("label", null, app.translator.trans("askvortsov-auto-moderator.admin.criterion_page.name_label")), m("input", {
      className: "FormControl",
      bidi: this.name,
      required: true
    })), m("div", {
      className: "Form-group"
    }, m("label", null, app.translator.trans("askvortsov-auto-moderator.admin.criterion_page.description_label")), m("input", {
      className: "FormControl",
      bidi: this.description
    })), this.metricsAndRequirementsForm(), this.actionsForm(), m("div", {
      className: "Form-group"
    }, m(flarum_common_components_Button__WEBPACK_IMPORTED_MODULE_4___default.a, {
      type: "submit",
      className: "Button Button--primary",
      loading: this.saving,
      disabled: this.saving
    }, app.translator.trans('core.admin.settings.submit_button'))), this.criterion && m(flarum_common_components_Button__WEBPACK_IMPORTED_MODULE_4___default.a, {
      type: "button",
      onclick: this["delete"].bind(this),
      className: "Button Button--danger",
      loading: this.deleting,
      disabled: this.saving
    }, app.translator.trans('askvortsov-auto-moderator.admin.criterion_page.delete_button')))));
  };

  _proto.errors = function errors() {
    if (!this.criterion) return;
    var errors = [];

    if (!this.criterion.isValid()) {
      errors.push(m(flarum_common_components_Alert__WEBPACK_IMPORTED_MODULE_3___default.a, {
        type: "error",
        dismissible: false
      }, app.translator.trans('askvortsov-auto-moderator.admin.criterion_page.invalid')));
    }

    var validation = this.criterion.invalidActionSettings();

    if (validation && Object.keys(validation).length) {
      errors.push(m(flarum_common_components_Alert__WEBPACK_IMPORTED_MODULE_3___default.a, {
        type: "error",
        dismissible: false
      }, app.translator.trans('askvortsov-auto-moderator.admin.criterion_page.validation'), m("div", null, m("ol", null, Object.keys(validation).map(function (key) {
        return m("li", null, m("strong", null, key, ":"), " ", validation[key].join(""));
      })))));
    }

    return m("div", {
      className: "StatusCheck"
    }, errors);
  };

  _proto.metricsAndRequirementsForm = function metricsAndRequirementsForm() {
    var _this2 = this;

    return m("div", {
      className: "Form-group"
    }, m("label", null, app.translator.trans("askvortsov-auto-moderator.admin.criterion_page.metrics_and_requirements_label")), m("div", {
      className: "helpText"
    }, app.translator.trans("askvortsov-auto-moderator.admin.criterion_page.metrics_and_requirements_help")), m("div", {
      className: "SettingsGroups"
    }, m("div", {
      className: "DriverGroup"
    }, m("label", null, app.translator.trans('askvortsov-auto-moderator.admin.criterion_page.metrics_heading')), m("ul", {
      className: "DriverList DriverList--primary"
    }, this.metrics().map(function (m) {
      return metricItem(m, _this2.metrics);
    })), m("span", {
      "class": "DriverGroup-controls"
    }, flarum_common_components_Select__WEBPACK_IMPORTED_MODULE_6___default.a.component({
      options: Object.keys(metricDefs).reduce(function (acc, key) {
        acc[key] = app.translator.trans(metricDefs[key].translationKey);
        return acc;
      }, {}),
      value: this.newMetric(),
      onchange: this.newMetric
    }), flarum_common_components_Button__WEBPACK_IMPORTED_MODULE_4___default.a.component({
      className: 'Button DriverList-button',
      icon: 'fas fa-plus',
      disabled: !this.newMetric(),
      onclick: function onclick() {
        _this2.metrics([].concat(_this2.metrics(), [{
          type: _this2.newMetric(),
          min: flarum_common_utils_Stream__WEBPACK_IMPORTED_MODULE_11___default()(),
          max: flarum_common_utils_Stream__WEBPACK_IMPORTED_MODULE_11___default()()
        }]));
      }
    })))));
  };

  _proto.actionsForm = function actionsForm() {
    var _this3 = this;

    return m("div", {
      className: "Form-group"
    }, m("label", null, app.translator.trans("askvortsov-auto-moderator.admin.criterion_page.actions_label")), m("div", {
      className: "helpText"
    }, app.translator.trans("askvortsov-auto-moderator.admin.criterion_page.actions_help")), m("div", {
      className: "SettingsGroups"
    }, m("div", {
      className: "DriverGroup"
    }, m("label", null, app.translator.trans('askvortsov-auto-moderator.admin.criterion_page.actions_on_gain_heading')), m("ul", {
      className: "DriverList DriverList--primary"
    }, this.actionsOnGain().map(function (a) {
      return actionItem(a, _this3.actionsOnGain);
    })), m("span", {
      "class": "DriverGroup-controls"
    }, flarum_common_components_Select__WEBPACK_IMPORTED_MODULE_6___default.a.component({
      options: Object.keys(actionDefs).reduce(function (acc, key) {
        acc[key] = app.translator.trans(actionDefs[key].translationKey);
        return acc;
      }, {}),
      value: this.newActionOnGain(),
      onchange: this.newActionOnGain
    }), flarum_common_components_Button__WEBPACK_IMPORTED_MODULE_4___default.a.component({
      className: 'Button DriverList-button',
      icon: 'fas fa-plus',
      disabled: !this.newActionOnGain(),
      onclick: function onclick() {
        _this3.actionsOnGain([].concat(_this3.actionsOnGain(), [{
          type: _this3.newActionOnGain(),
          settings: {}
        }]));
      }
    }))), m("div", {
      className: "DriverGroup DriverGroup--secondary"
    }, m("label", null, app.translator.trans('askvortsov-auto-moderator.admin.criterion_page.actions_on_loss_heading')), m("ul", {
      className: "DriverList"
    }, this.actionsOnLoss().map(function (a) {
      return actionItem(a, _this3.actionsOnLoss);
    })), m("span", {
      "class": "DriverGroup-controls"
    }, flarum_common_components_Select__WEBPACK_IMPORTED_MODULE_6___default.a.component({
      options: Object.keys(actionDefs).reduce(function (acc, key) {
        acc[key] = app.translator.trans(actionDefs[key].translationKey);
        return acc;
      }, {}),
      value: this.newActionOnLoss(),
      onchange: this.newActionOnLoss
    }), flarum_common_components_Button__WEBPACK_IMPORTED_MODULE_4___default.a.component({
      className: 'Button DriverList-button',
      icon: 'fas fa-plus',
      disabled: !this.newActionOnLoss(),
      onclick: function onclick() {
        _this3.actionsOnLoss([].concat(_this3.actionsOnLoss(), [{
          type: _this3.newActionOnLoss(),
          settings: {}
        }]));
      }
    })))));
  };

  _proto.data = function data() {
    return {
      name: this.name(),
      description: this.description(),
      actions: [].concat(this.actionsOnGain().map(function (a) {
        return Object(_babel_runtime_helpers_esm_extends__WEBPACK_IMPORTED_MODULE_0__["default"])({}, a, {
          gain: true
        });
      }), this.actionsOnLoss().map(function (a) {
        return Object(_babel_runtime_helpers_esm_extends__WEBPACK_IMPORTED_MODULE_0__["default"])({}, a, {
          gain: false
        });
      })),
      metrics: this.metrics().map(function (m) {
        return {
          type: m.type,
          min: m.min(),
          max: m.max()
        };
      }),
      requirements: this.requirements()
    };
  };

  _proto["delete"] = function _delete(e) {
    e.preventDefault();
    this.deleting = true;
    m.redraw();
    this.criterion["delete"]().then(function () {
      m.route.set(app.route('extension', {
        id: 'askvortsov-auto-moderator'
      }));
    });
  };

  _proto.onsubmit = function onsubmit(e) {
    var _this4 = this;

    e.preventDefault();
    this.saving = true;
    m.redraw();
    var criterion = this.criterion || app.store.createRecord("criteria");
    criterion.save(this.data()).then(function () {
      _this4.saving = false;
      m.redraw();
    });
  };

  return CriterionPage;
}(flarum_admin_components_AdminPage__WEBPACK_IMPORTED_MODULE_2___default.a);



/***/ }),

/***/ "./src/admin/components/GroupActionDriverSettings.js":
/*!***********************************************************!*\
  !*** ./src/admin/components/GroupActionDriverSettings.js ***!
  \***********************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "default", function() { return GroupActionDriverSettings; });
/* harmony import */ var _babel_runtime_helpers_esm_inheritsLoose__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! @babel/runtime/helpers/esm/inheritsLoose */ "./node_modules/@babel/runtime/helpers/esm/inheritsLoose.js");
/* harmony import */ var flarum_Component__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! flarum/Component */ "flarum/Component");
/* harmony import */ var flarum_Component__WEBPACK_IMPORTED_MODULE_1___default = /*#__PURE__*/__webpack_require__.n(flarum_Component__WEBPACK_IMPORTED_MODULE_1__);
/* harmony import */ var _GroupSelector__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ./GroupSelector */ "./src/admin/components/GroupSelector.js");




var GroupActionDriverSettings = /*#__PURE__*/function (_Component) {
  Object(_babel_runtime_helpers_esm_inheritsLoose__WEBPACK_IMPORTED_MODULE_0__["default"])(GroupActionDriverSettings, _Component);

  function GroupActionDriverSettings() {
    return _Component.apply(this, arguments) || this;
  }

  var _proto = GroupActionDriverSettings.prototype;

  _proto.view = function view() {
    var action = this.attrs.action;
    return m(_GroupSelector__WEBPACK_IMPORTED_MODULE_2__["default"], {
      value: action.settings.group_id,
      onchange: function onchange(val) {
        return action.settings = {
          group_id: val
        };
      }
    });
  };

  return GroupActionDriverSettings;
}(flarum_Component__WEBPACK_IMPORTED_MODULE_1___default.a);



/***/ }),

/***/ "./src/admin/components/GroupSelector.js":
/*!***********************************************!*\
  !*** ./src/admin/components/GroupSelector.js ***!
  \***********************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "default", function() { return GroupSelector; });
/* harmony import */ var _babel_runtime_helpers_esm_inheritsLoose__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! @babel/runtime/helpers/esm/inheritsLoose */ "./node_modules/@babel/runtime/helpers/esm/inheritsLoose.js");
/* harmony import */ var flarum_Component__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! flarum/Component */ "flarum/Component");
/* harmony import */ var flarum_Component__WEBPACK_IMPORTED_MODULE_1___default = /*#__PURE__*/__webpack_require__.n(flarum_Component__WEBPACK_IMPORTED_MODULE_1__);
/* harmony import */ var flarum_components_Button__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! flarum/components/Button */ "flarum/components/Button");
/* harmony import */ var flarum_components_Button__WEBPACK_IMPORTED_MODULE_2___default = /*#__PURE__*/__webpack_require__.n(flarum_components_Button__WEBPACK_IMPORTED_MODULE_2__);
/* harmony import */ var flarum_components_Dropdown__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! flarum/components/Dropdown */ "flarum/components/Dropdown");
/* harmony import */ var flarum_components_Dropdown__WEBPACK_IMPORTED_MODULE_3___default = /*#__PURE__*/__webpack_require__.n(flarum_components_Dropdown__WEBPACK_IMPORTED_MODULE_3__);
/* harmony import */ var flarum_helpers_icon__WEBPACK_IMPORTED_MODULE_4__ = __webpack_require__(/*! flarum/helpers/icon */ "flarum/helpers/icon");
/* harmony import */ var flarum_helpers_icon__WEBPACK_IMPORTED_MODULE_4___default = /*#__PURE__*/__webpack_require__.n(flarum_helpers_icon__WEBPACK_IMPORTED_MODULE_4__);
/* harmony import */ var flarum_models_Group__WEBPACK_IMPORTED_MODULE_5__ = __webpack_require__(/*! flarum/models/Group */ "flarum/models/Group");
/* harmony import */ var flarum_models_Group__WEBPACK_IMPORTED_MODULE_5___default = /*#__PURE__*/__webpack_require__.n(flarum_models_Group__WEBPACK_IMPORTED_MODULE_5__);







var GroupSelector = /*#__PURE__*/function (_Component) {
  Object(_babel_runtime_helpers_esm_inheritsLoose__WEBPACK_IMPORTED_MODULE_0__["default"])(GroupSelector, _Component);

  function GroupSelector() {
    return _Component.apply(this, arguments) || this;
  }

  var _proto = GroupSelector.prototype;

  _proto.view = function view() {
    var _this = this;

    var group = app.store.getById("groups", this.attrs.value);
    var label = group ? [flarum_helpers_icon__WEBPACK_IMPORTED_MODULE_4___default()(group.icon()), "\t", group.namePlural()] : app.translator.trans("askvortsov-auto-moderator.admin.group_selector.placeholder");
    return m("div", {
      className: "Form-group"
    }, m("label", null, this.attrs.label), this.attrs.disabled ? m("div", {
      className: "Button Button--danger"
    }, label) : m(flarum_components_Dropdown__WEBPACK_IMPORTED_MODULE_3___default.a, {
      label: label,
      disabled: this.attrs.disabled,
      buttonClassName: "Button Button--danger"
    }, app.store.all("groups").filter(function (g) {
      return ![flarum_models_Group__WEBPACK_IMPORTED_MODULE_5___default.a.MEMBER_ID, flarum_models_Group__WEBPACK_IMPORTED_MODULE_5___default.a.GUEST_ID].includes(g.id());
    }).map(function (g) {
      return flarum_components_Button__WEBPACK_IMPORTED_MODULE_2___default.a.component({
        active: group && group.id() === g.id(),
        disabled: group && group.id() === g.id(),
        icon: g.icon(),
        onclick: function onclick() {
          _this.attrs.onchange(g.id());
        }
      }, g.namePlural());
    })));
  };

  return GroupSelector;
}(flarum_Component__WEBPACK_IMPORTED_MODULE_1___default.a);



/***/ }),

/***/ "./src/admin/components/MinMaxSelector.js":
/*!************************************************!*\
  !*** ./src/admin/components/MinMaxSelector.js ***!
  \************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _babel_runtime_helpers_esm_inheritsLoose__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! @babel/runtime/helpers/esm/inheritsLoose */ "./node_modules/@babel/runtime/helpers/esm/inheritsLoose.js");
/* harmony import */ var flarum_Component__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! flarum/Component */ "flarum/Component");
/* harmony import */ var flarum_Component__WEBPACK_IMPORTED_MODULE_1___default = /*#__PURE__*/__webpack_require__.n(flarum_Component__WEBPACK_IMPORTED_MODULE_1__);
/* harmony import */ var flarum_components_Button__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! flarum/components/Button */ "flarum/components/Button");
/* harmony import */ var flarum_components_Button__WEBPACK_IMPORTED_MODULE_2___default = /*#__PURE__*/__webpack_require__.n(flarum_components_Button__WEBPACK_IMPORTED_MODULE_2__);
/* harmony import */ var flarum_utils_Stream__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! flarum/utils/Stream */ "flarum/utils/Stream");
/* harmony import */ var flarum_utils_Stream__WEBPACK_IMPORTED_MODULE_3___default = /*#__PURE__*/__webpack_require__.n(flarum_utils_Stream__WEBPACK_IMPORTED_MODULE_3__);





var MinMaxSelector = /*#__PURE__*/function (_Component) {
  Object(_babel_runtime_helpers_esm_inheritsLoose__WEBPACK_IMPORTED_MODULE_0__["default"])(MinMaxSelector, _Component);

  function MinMaxSelector() {
    return _Component.apply(this, arguments) || this;
  }

  var _proto = MinMaxSelector.prototype;

  _proto.oninit = function oninit(vnode) {
    _Component.prototype.oninit.call(this, vnode);

    this.state = -1;
    if (this.attrs.min() !== -1) this.state += 1;
    if (this.attrs.max() !== -1) this.state += 2;
    this.min = flarum_utils_Stream__WEBPACK_IMPORTED_MODULE_3___default()(this.attrs.min());
    this.max = flarum_utils_Stream__WEBPACK_IMPORTED_MODULE_3___default()(this.attrs.max());
  };

  _proto.view = function view() {
    return m("div", {
      className: "Form-group MinMaxSelector"
    }, m("label", null, this.attrs.label), m("div", {
      className: "MinMaxSelector--inputs"
    }, this.controls()));
  };

  _proto.controls = function controls() {
    var _this = this;

    var minInput = function minInput() {
      return m("input", {
        className: "FormControl",
        type: "number",
        min: "0",
        max: _this.state === MinMaxSelector.State.BETWEEN ? _this.attrs.max() !== -1 ? _this.attrs.max() : _this.max() : Infinity,
        placeholder: "min",
        bidi: _this.attrs.min
      });
    };

    var maxInput = function maxInput() {
      return m("input", {
        className: "FormControl",
        type: "number",
        min: _this.state === Math.max(0, MinMaxSelector.State.BETWEEN ? _this.attrs.min() !== -1 ? _this.attrs.min() : _this.min() : 0),
        placeholder: "max",
        bidi: _this.attrs.max
      });
    };

    var placeholder = function placeholder() {
      return m("input", {
        className: "FormControl MinMaxSelector--placeholder",
        disabled: true,
        placeholder: "X"
      });
    };

    var button = function button(icon) {
      return m(flarum_components_Button__WEBPACK_IMPORTED_MODULE_2___default.a, {
        className: "Button",
        onclick: _this.cycle.bind(_this),
        icon: icon
      });
    };

    switch (this.state) {
      case MinMaxSelector.State.LTE:
        return [placeholder(), button("fas fa-less-than-equal"), maxInput()];

      case MinMaxSelector.State.GTE:
        return [placeholder(), button("fas fa-greater-than-equal"), minInput()];

      case MinMaxSelector.State.BETWEEN:
        return [minInput(), button("fas fa-less-than-equal"), placeholder(), button("fas fa-less-than-equal"), maxInput()];
    }
  };

  _proto.cycle = function cycle() {
    this.state++;
    this.state %= 3;
    if (this.attrs.min() !== -1) this.min(this.attrs.min());
    if (this.attrs.max() !== -1) this.max(this.attrs.max());

    switch (this.state) {
      case MinMaxSelector.State.GTE:
        this.attrs.min(this.min());
        this.attrs.max(-1);
        break;

      case MinMaxSelector.State.LTE:
        this.attrs.min(-1);
        this.attrs.max(this.max());
        break;

      case MinMaxSelector.State.BETWEEN:
        this.attrs.min(this.min());
        this.attrs.max(this.max());
        break;
    }
  };

  return MinMaxSelector;
}(flarum_Component__WEBPACK_IMPORTED_MODULE_1___default.a);

MinMaxSelector.State = {
  GTE: 0,
  LTE: 1,
  BETWEEN: 2
};
/* harmony default export */ __webpack_exports__["default"] = (MinMaxSelector);

/***/ }),

/***/ "./src/admin/index.js":
/*!****************************!*\
  !*** ./src/admin/index.js ***!
  \****************************/
/*! no exports provided */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _common_augmentEditUserModal__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ../common/augmentEditUserModal */ "./src/common/augmentEditUserModal.js");
/* harmony import */ var _common_registerModels__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ../common/registerModels */ "./src/common/registerModels.js");
/* harmony import */ var _components_AutoModeratorPage__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ./components/AutoModeratorPage */ "./src/admin/components/AutoModeratorPage.js");
/* harmony import */ var _components_CriterionPage__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! ./components/CriterionPage */ "./src/admin/components/CriterionPage.js");
/* harmony import */ var _components_GroupActionDriverSettings__WEBPACK_IMPORTED_MODULE_4__ = __webpack_require__(/*! ./components/GroupActionDriverSettings */ "./src/admin/components/GroupActionDriverSettings.js");





app.initializers.add("askvortsov/flarum-auto-moderator", function () {
  app.routes.criterion = {
    path: '/askvortsov-auto-moderator/criterion/:id',
    component: _components_CriterionPage__WEBPACK_IMPORTED_MODULE_3__["default"]
  };
  app['askvortsov-auto-moderator'] = {
    actionDriverSettingsComponents: {
      add_to_group: _components_GroupActionDriverSettings__WEBPACK_IMPORTED_MODULE_4__["default"],
      remove_from_group: _components_GroupActionDriverSettings__WEBPACK_IMPORTED_MODULE_4__["default"]
    }
  };
  app.extensionData["for"]("askvortsov-auto-moderator").registerPage(_components_AutoModeratorPage__WEBPACK_IMPORTED_MODULE_2__["default"]);

  app.route.criterion = function (criterion) {
    return app.route('criterion', {
      id: (criterion == null ? void 0 : criterion.id()) || 'new'
    });
  };

  Object(_common_augmentEditUserModal__WEBPACK_IMPORTED_MODULE_0__["default"])();
  Object(_common_registerModels__WEBPACK_IMPORTED_MODULE_1__["default"])();
});

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

/***/ "flarum/Component":
/*!**************************************************!*\
  !*** external "flarum.core.compat['Component']" ***!
  \**************************************************/
/*! no static exports found */
/***/ (function(module, exports) {

module.exports = flarum.core.compat['Component'];

/***/ }),

/***/ "flarum/Model":
/*!**********************************************!*\
  !*** external "flarum.core.compat['Model']" ***!
  \**********************************************/
/*! no static exports found */
/***/ (function(module, exports) {

module.exports = flarum.core.compat['Model'];

/***/ }),

/***/ "flarum/admin/components/AdminPage":
/*!*******************************************************************!*\
  !*** external "flarum.core.compat['admin/components/AdminPage']" ***!
  \*******************************************************************/
/*! no static exports found */
/***/ (function(module, exports) {

module.exports = flarum.core.compat['admin/components/AdminPage'];

/***/ }),

/***/ "flarum/admin/components/ExtensionPage":
/*!***********************************************************************!*\
  !*** external "flarum.core.compat['admin/components/ExtensionPage']" ***!
  \***********************************************************************/
/*! no static exports found */
/***/ (function(module, exports) {

module.exports = flarum.core.compat['admin/components/ExtensionPage'];

/***/ }),

/***/ "flarum/common/components/Alert":
/*!****************************************************************!*\
  !*** external "flarum.core.compat['common/components/Alert']" ***!
  \****************************************************************/
/*! no static exports found */
/***/ (function(module, exports) {

module.exports = flarum.core.compat['common/components/Alert'];

/***/ }),

/***/ "flarum/common/components/Button":
/*!*****************************************************************!*\
  !*** external "flarum.core.compat['common/components/Button']" ***!
  \*****************************************************************/
/*! no static exports found */
/***/ (function(module, exports) {

module.exports = flarum.core.compat['common/components/Button'];

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

/***/ "flarum/common/components/Link":
/*!***************************************************************!*\
  !*** external "flarum.core.compat['common/components/Link']" ***!
  \***************************************************************/
/*! no static exports found */
/***/ (function(module, exports) {

module.exports = flarum.core.compat['common/components/Link'];

/***/ }),

/***/ "flarum/common/components/LinkButton":
/*!*********************************************************************!*\
  !*** external "flarum.core.compat['common/components/LinkButton']" ***!
  \*********************************************************************/
/*! no static exports found */
/***/ (function(module, exports) {

module.exports = flarum.core.compat['common/components/LinkButton'];

/***/ }),

/***/ "flarum/common/components/LoadingIndicator":
/*!***************************************************************************!*\
  !*** external "flarum.core.compat['common/components/LoadingIndicator']" ***!
  \***************************************************************************/
/*! no static exports found */
/***/ (function(module, exports) {

module.exports = flarum.core.compat['common/components/LoadingIndicator'];

/***/ }),

/***/ "flarum/common/components/Select":
/*!*****************************************************************!*\
  !*** external "flarum.core.compat['common/components/Select']" ***!
  \*****************************************************************/
/*! no static exports found */
/***/ (function(module, exports) {

module.exports = flarum.core.compat['common/components/Select'];

/***/ }),

/***/ "flarum/common/components/Tooltip":
/*!******************************************************************!*\
  !*** external "flarum.core.compat['common/components/Tooltip']" ***!
  \******************************************************************/
/*! no static exports found */
/***/ (function(module, exports) {

module.exports = flarum.core.compat['common/components/Tooltip'];

/***/ }),

/***/ "flarum/common/extend":
/*!******************************************************!*\
  !*** external "flarum.core.compat['common/extend']" ***!
  \******************************************************/
/*! no static exports found */
/***/ (function(module, exports) {

module.exports = flarum.core.compat['common/extend'];

/***/ }),

/***/ "flarum/common/helpers/icon":
/*!************************************************************!*\
  !*** external "flarum.core.compat['common/helpers/icon']" ***!
  \************************************************************/
/*! no static exports found */
/***/ (function(module, exports) {

module.exports = flarum.core.compat['common/helpers/icon'];

/***/ }),

/***/ "flarum/common/utils/ItemList":
/*!**************************************************************!*\
  !*** external "flarum.core.compat['common/utils/ItemList']" ***!
  \**************************************************************/
/*! no static exports found */
/***/ (function(module, exports) {

module.exports = flarum.core.compat['common/utils/ItemList'];

/***/ }),

/***/ "flarum/common/utils/Stream":
/*!************************************************************!*\
  !*** external "flarum.core.compat['common/utils/Stream']" ***!
  \************************************************************/
/*! no static exports found */
/***/ (function(module, exports) {

module.exports = flarum.core.compat['common/utils/Stream'];

/***/ }),

/***/ "flarum/common/utils/classList":
/*!***************************************************************!*\
  !*** external "flarum.core.compat['common/utils/classList']" ***!
  \***************************************************************/
/*! no static exports found */
/***/ (function(module, exports) {

module.exports = flarum.core.compat['common/utils/classList'];

/***/ }),

/***/ "flarum/common/utils/stringToColor":
/*!*******************************************************************!*\
  !*** external "flarum.core.compat['common/utils/stringToColor']" ***!
  \*******************************************************************/
/*! no static exports found */
/***/ (function(module, exports) {

module.exports = flarum.core.compat['common/utils/stringToColor'];

/***/ }),

/***/ "flarum/components/Button":
/*!**********************************************************!*\
  !*** external "flarum.core.compat['components/Button']" ***!
  \**********************************************************/
/*! no static exports found */
/***/ (function(module, exports) {

module.exports = flarum.core.compat['components/Button'];

/***/ }),

/***/ "flarum/components/Dropdown":
/*!************************************************************!*\
  !*** external "flarum.core.compat['components/Dropdown']" ***!
  \************************************************************/
/*! no static exports found */
/***/ (function(module, exports) {

module.exports = flarum.core.compat['components/Dropdown'];

/***/ }),

/***/ "flarum/helpers/icon":
/*!*****************************************************!*\
  !*** external "flarum.core.compat['helpers/icon']" ***!
  \*****************************************************/
/*! no static exports found */
/***/ (function(module, exports) {

module.exports = flarum.core.compat['helpers/icon'];

/***/ }),

/***/ "flarum/models/Group":
/*!*****************************************************!*\
  !*** external "flarum.core.compat['models/Group']" ***!
  \*****************************************************/
/*! no static exports found */
/***/ (function(module, exports) {

module.exports = flarum.core.compat['models/Group'];

/***/ }),

/***/ "flarum/models/User":
/*!****************************************************!*\
  !*** external "flarum.core.compat['models/User']" ***!
  \****************************************************/
/*! no static exports found */
/***/ (function(module, exports) {

module.exports = flarum.core.compat['models/User'];

/***/ }),

/***/ "flarum/utils/Stream":
/*!*****************************************************!*\
  !*** external "flarum.core.compat['utils/Stream']" ***!
  \*****************************************************/
/*! no static exports found */
/***/ (function(module, exports) {

module.exports = flarum.core.compat['utils/Stream'];

/***/ })

/******/ });
//# sourceMappingURL=admin.js.map