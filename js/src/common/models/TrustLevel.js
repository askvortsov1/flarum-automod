import Model from "flarum/Model";

export default class TrustLevel extends Model {}

Object.assign(TrustLevel.prototype, {
  name: Model.attribute("name"),
  group: Model.hasOne("group"),
  metrics: Model.attribute("metrics"),
});
