import augmentEditUserModal from "../common/augmentEditUserModal";
import registerModels from "../common/registerModels";
import AutoModeratorPage from "./components/AutoModeratorPage";
import CriterionPage from "./components/CriterionPage";
import GroupActionDriverSettings from "./components/GroupActionDriverSettings";

app.initializers.add("askvortsov/flarum-auto-moderator", () => {
  app.routes.criterion = {
    path: "/askvortsov-auto-moderator/criterion/:id",
    component: CriterionPage,
  };

  app.autoModeratorForms = {
    action: {
      add_to_group: GroupActionDriverSettings,
      remove_from_group: GroupActionDriverSettings,
    },
    metric: {},
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
