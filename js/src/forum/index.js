import augmentEditUserModal from "../common/augmentEditUserModal";
import registerModels from "../common/registerModels";

app.initializers.add("askvortsov/flarum-automod", () => {
  registerModels();
  augmentEditUserModal();
});
