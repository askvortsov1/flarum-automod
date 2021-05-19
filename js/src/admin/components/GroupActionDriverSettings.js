import Component from "flarum/Component";
import GroupSelector from "./GroupSelector";

export default class GroupActionDriverSettings extends Component {
  view() {
    const action = this.attrs.action;

    return (
      <GroupSelector
        value={action.settings.group_id}
        onchange={(val) => (action.settings = { group_id: val })}
      ></GroupSelector>
    );
  }
}
