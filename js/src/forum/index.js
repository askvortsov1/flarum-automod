const { default: registerModels } = require("../common/registerModels");

app.initializers.add('askvortsov/flarum-trust-levels', () => {
  registerModels();
});
