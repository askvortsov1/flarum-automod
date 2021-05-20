import augmentEditUserModal from "../common/augmentEditUserModal";
import registerModels from "../common/registerModels";
import AutoModeratorPage from "./components/AutoModeratorPage";
import CriterionPage from "./components/CriterionPage";
import GroupIdSelector from "./components/GroupIdSelector";
import SuspendSelector from "./components/SuspendSelector";

app.initializers.add("askvortsov/flarum-auto-moderator", () => {
  app.routes.criterion = {
    path: "/askvortsov-auto-moderator/criterion/:id",
    component: CriterionPage,
  };

  app.autoModeratorForms = {
    action: {
      add_to_group: GroupIdSelector,
      remove_from_group: GroupIdSelector,
      suspend: SuspendSelector,
    },
    requirement: {
      in_group: GroupIdSelector,
    },
  };

  app.extensionData
    .for("askvortsov-auto-moderator")
    .registerPage(AutoModeratorPage);

  app.route.criterion = (criterion) => {
    return app.route("criterion", { id: criterion?.id() || "new" });
  };

  augmentEditUserModal();
  registerModels();
});
