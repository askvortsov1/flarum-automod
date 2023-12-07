import Component from "flarum/common/Component";
import Switch from "flarum/common/components/Switch";

export default class SuspendSelector extends Component {
  view() {
    const settings = this.attrs.settings;

    return (
      <div className="Form-group">
        <div className="Form-group">
          <Switch
            state={settings().indefinitely}
            onchange={(val) => settings({ ...settings(), indefinitely: val })}
          >
            {app.translator.trans(
              "askvortsov-automod.admin.suspend_selector.indefinitely"
            )}
          </Switch>
        </div>
        {!settings().indefinitely && (
          <div className="Form-group">
            <input
              className="FormControl"
              type="number"
              min="0"
              value={settings().days}
              onchange={(e) =>
                settings({ ...settings(), days: e.target.value })
              }
              placeholder={app.translator.trans(
                "askvortsov-automod.admin.suspend_selector.days"
              )}
            />
          </div>
        )}
      </div>
    );
  }
}
