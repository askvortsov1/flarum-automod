import Component from "flarum/Component";
import Button from "flarum/common/components/Button";
import Tooltip from "flarum/common/components/Tooltip";
import icon from "flarum/common/helpers/icon";
import classList from "flarum/common/utils/classList";

export default class ActionItem extends Component {
  view() {
    const action = this.attrs.action;
    const actionDef = this.attrs.actionDef;
    const selected = this.attrs.selected;

    const forms =
      app["askvortsov-auto-moderator"].actionDriverSettingsComponents;

    let settings;
    if (action.type in forms) {
      settings = forms[action.type].component({ action, actionDef });
    } else {
      settings = Object.keys(actionDef.availableSettings).map((s) => (
        <div className="Form-group">
          <input
            className="FormControl"
            value={action.settings[s]}
            onchange={(e) => (action.settings[s] = e.target.value)}
            placeholder={app.translator.trans(actionDef.availableSettings[s])}
          />
        </div>
      ));
    }

    return (
      <li>
        <div
          className={classList({
            "DriverListItem-info": true,
            "DriverListItem--missingExt": actionDef.missingExt,
          })}
        >
          {actionDef.missingExt && (
            <Tooltip
              text={app.translator.trans(
                "askvortsov-auto-moderator.admin.criterion_page.driver_missing_ext"
              )}
            >
              {icon("fas fa-exclamation-triangle")}
            </Tooltip>
          )}
          <span className="DriverListItem-name">
            {app.translator.trans(actionDef.translationKey)}
          </span>
          {Button.component({
            className: "Button Button--link",
            icon: "fas fa-trash-alt",
            onclick: () => selected(selected().filter((val) => val !== action)),
          })}
          <div className="DriverListItem-form">{settings}</div>
        </div>
        <hr />
      </li>
    );
  }
}
