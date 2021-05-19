import { extend, override } from "flarum/common/extend";
import EditUserModal from "flarum/common/components/EditUserModal";
import LoadingIndicator from "flarum/common/components/LoadingIndicator";
import ItemList from "flarum/common/utils/ItemList";
import managedGroups from "./utils/managedGroups";
import ManagedGroups from "./components/ManagedGroups";

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
      <ManagedGroups
        criteria={app.store.all("criteria")}
        user={this.attrs.user}
      />,
      10
    );

    return items;
  });
}
