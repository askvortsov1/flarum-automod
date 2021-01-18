const { default: registerModels } = require("../common/registerModels");
const { default: augmentEditUserModal } = require("./augmentEditUserModal");

app.initializers.add("askvortsov/flarum-trust-levels", () => {
  registerModels();
  augmentEditUserModal();
});
