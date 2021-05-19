import Component from "flarum/common/Component";
import GroupBadge from "flarum/common/components/GroupBadge";
import managedGroups from "../utils/managedGroups";

export default class ManagedGroups extends Component {
  view() {
    const groups = managedGroups(this.attrs.criteria);
    const user = this.attrs.user;

    return (
      <div className="ManagedGroups Form-group">
        <hr />
        <h4>
          {app.translator.trans(
            "askvortsov-auto-moderator.lib.managed_groups.header"
          )}
        </h4>
        <ul>
          {groups.map((group) => (
            <label className="checkbox">
              {user && (
                <input
                  type="checkbox"
                  checked={user.groups().includes(group)}
                  disabled={true}
                />
              )}
              {app.translator.trans(
                "askvortsov-auto-moderator.lib.managed_groups.group_item",
                {
                  badge: GroupBadge.component({
                    group,
                    label: "",
                  }),
                  groupName: group.nameSingular(),
                }
              )}
            </label>
          ))}
        </ul>
        <p>
          {app.translator.trans(
            "askvortsov-auto-moderator.lib.managed_groups.groups_not_editable"
          )}
        </p>
      </div>
    );
  }
}
