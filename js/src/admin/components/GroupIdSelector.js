import Component from "flarum/Component";
import GroupSelector from "./GroupSelector";

export default class GroupActionDriverSettings extends Component {
  view() {
    const settings = this.attrs.settings;

    return (
      <GroupSelector
        value={settings().group_id}
        onchange={(val) => settings({ group_id: val })}
      ></GroupSelector>
    );
  }
}
