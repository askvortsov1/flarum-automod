import Component from "flarum/Component";

export default class DriverSettings extends Component {
  view() {
    const driverType = this.attrs.driverType;
    const type = this.attrs.type;
    const settings = this.attrs.settings;
    const availableSettings = this.attrs.availableSettings;

    const forms = app.autoModeratorForms[driverType];

    let form;
    if (type in forms) {
      form = forms[type].component({ settings, availableSettings });
    } else {
      form = Object.keys(availableSettings).map((s) => (
        <div className="Form-group">
          <input
            className="FormControl"
            value={settings()[s]}
            onchange={(e) => {
              const newSettings = { ...settings() };
              newSettings[s] = e.target.value;
              settings(newSettings);
            }}
            placeholder={app.translator.trans(availableSettings[s])}
          />
        </div>
      ));
    }

    return <div className="DriverListItem-form">{form}</div>;
  }
}
