import { extend, override } from "flarum/common/extend";
import EditUserModal from "flarum/common/components/EditUserModal";
import GroupBadge from "flarum/common/components/GroupBadge";
import LoadingIndicator from "flarum/common/components/LoadingIndicator";
import ItemList from "flarum/common/utils/ItemList";
import managedGroups from "./utils/managedGroups";

export default function augmentEditUserModal() {
  extend(EditUserModal.prototype, "oninit", function () {
    this.loading = true;
    app.store.find("criteria").then((criteria) => {
      managedGroups(criteria).forEach(
        (group) => delete this.groups[group.id()]
      );

      this.loading = false;
      m.redraw();
    });
  });

  override(EditUserModal.prototype, "fields", function (original) {
    if (this.loading) {
      const items = new ItemList();
      items.add("loading", <LoadingIndicator></LoadingIndicator>);
      return items;
    }

    const items = original();

    items.add(
      "Criteria",
      <div className="Form-group">
        <label>
          {app.translator.trans(
            "askvortsov-auto-moderator.forum.edit_user.managed_groups_heading"
          )}
        </label>
        {managedGroups(app.store.all("criteria")).map((group) => (
          <label className="checkbox">
            <input
              type="checkbox"
              checked={this.attrs.user.groups().includes(group)}
              disabled={true}
            />
            {app.translator.trans(
              "askvortsov-auto-moderator.forum.edit_user.managed_group",
              {
                badge: GroupBadge.component({
                  group,
                  label: "",
                }),
                groupName: Criterion.group().nameSingular(),
              }
            )}
          </label>
        ))}
        <p>
          {app.translator.trans(
            "askvortsov-auto-moderator.forum.edit_user.groups_not_editable"
          )}
        </p>
      </div>,
      10
    );

    return items;
  });
}
