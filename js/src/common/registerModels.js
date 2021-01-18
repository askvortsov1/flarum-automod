import Model from "flarum/Model";
import User from "flarum/models/User";
import TrustLevel from "./models/TrustLevel";

export default function registerModels() {
  app.store.models.trust_levels = TrustLevel;

  User.prototype.trustLevels = Model.hasMany("trustLevels");
}
