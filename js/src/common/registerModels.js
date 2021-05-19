import Model from "flarum/Model";
import User from "flarum/models/User";
import Criterion from "./models/Criterion";

export default function registerModels() {
  app.store.models.criteria = Criterion;

  User.prototype.criteria = Model.hasMany("criteria");
}
