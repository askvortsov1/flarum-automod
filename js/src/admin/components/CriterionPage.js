import AdminPage from "flarum/admin/components/AdminPage";
import Alert from "flarum/common/components/Alert";
import Button from "flarum/common/components/Button";
import LinkButton from "flarum/common/components/LinkButton";
import Select from "flarum/common/components/Select";
import LoadingIndicator from "flarum/common/components/LoadingIndicator";
import Stream from "flarum/common/utils/Stream";
import ActionItem from "./ActionItem";
import MetricItem from "./MetricItem";
import RequirementItem from "./RequirementItem";

let actionDefs;
let metricDefs;
let requirementDefs;

export default class CriterionPage extends AdminPage {
  oninit(vnode) {
    super.oninit(vnode);

    this.id = m.route.param("id");

    this.name = Stream("");
    this.description = Stream("");
    this.actionsOnGain = Stream([]);
    this.actionsOnLoss = Stream([]);
    this.metrics = Stream([]);
    this.requirements = Stream([]);

    this.newActionOnGain = Stream("");
    this.newActionOnLoss = Stream("");
    this.newMetric = Stream("");
    this.newRequirement = Stream("");

    this.loadingDrivers = true;

    app
      .request({
        method: "GET",
        url: app.forum.attribute("apiUrl") + "/automod_drivers",
      })
      .then((response) => {
        actionDefs = response["data"]["attributes"]["action"];
        metricDefs = response["data"]["attributes"]["metric"];
        requirementDefs = response["data"]["attributes"]["requirement"];

        this.loadingDrivers = false;
        m.redraw();
      });

    if (this.id === "new") return;

    this.loadingCriterion = true;

    app.store.find("criteria", this.id).then((criterion) => {
      this.loadCriterion(criterion);
      this.loadingCriterion = false;
      m.redraw();
    });
  }

  loadCriterion(criterion) {
    this.criterion = criterion;
    this.name(criterion.name());
    this.description(criterion.description());
    this.metrics(
      criterion.metrics().map((m) => {
        return { type: m.type, min: Stream(m.min), max: Stream(m.max) };
      })
    );
    this.actionsOnGain(criterion.actions().filter((a) => a.gain));
    this.actionsOnLoss(criterion.actions().filter((a) => !a.gain));
    this.requirements(
      criterion.requirements().map((r) => {
        return { type: r.type, negated: Stream(r.negated) };
      })
    );
  }

  headerInfo() {
    let title;
    let description = "";

    if (this.loadingCriterion) {
      description = app.translator.trans(
        "askvortsov-auto-moderator.admin.criterion_page.loading"
      );
      title = app.translator.trans(
        "askvortsov-auto-moderator.admin.criterion_page.loading"
      );
    } else if (this.criterion) {
      title = this.criterion.name();
    } else {
      title = app.translator.trans(
        "askvortsov-auto-moderator.admin.criterion_page.new_criterion"
      );
    }

    return {
      className: "CriterionPage",
      icon: "fas fa-bolt",
      title,
      description,
    };
  }

  content() {
    if (this.loadingCriterion || this.loadingDrivers) {
      return (
        <div className="Criteria">
          <div className="container">
            <LoadingIndicator />
          </div>
        </div>
      );
    }

    return (
      <div className="Criteria">
        <div className="container">
          <form onsubmit={this.onsubmit.bind(this)}>
            <div className="Form-group">
              <LinkButton
                className="Button"
                icon="fas fa-chevron-left"
                href={app.route("extension", {
                  id: "askvortsov-auto-moderator",
                })}
              >
                {app.translator.trans(
                  "askvortsov-auto-moderator.admin.criterion_page.back"
                )}
              </LinkButton>
            </div>
            <div className="Form-group">{this.errors()}</div>
            <div className="Form-group">
              <label>
                {app.translator.trans(
                  "askvortsov-auto-moderator.admin.criterion_page.name_label"
                )}
              </label>
              <input className="FormControl" bidi={this.name} required={true} />
            </div>
            <div className="Form-group">
              <label>
                {app.translator.trans(
                  "askvortsov-auto-moderator.admin.criterion_page.description_label"
                )}
              </label>
              <input className="FormControl" bidi={this.description} />
            </div>
            {this.metricsAndRequirementsForm()}
            {this.actionsForm()}
            <div className="Form-group">
              <Button
                type="submit"
                className="Button Button--primary"
                loading={this.saving}
                disabled={this.saving}
              >
                {app.translator.trans("core.admin.settings.submit_button")}
              </Button>
            </div>
            {this.criterion && (
              <Button
                type="button"
                onclick={this.delete.bind(this)}
                className="Button Button--danger"
                loading={this.deleting}
                disabled={this.saving}
              >
                {app.translator.trans(
                  "askvortsov-auto-moderator.admin.criterion_page.delete_button"
                )}
              </Button>
            )}
          </form>
        </div>
      </div>
    );
  }

  errors() {
    if (!this.criterion) return;
    const errors = [];

    if (!this.criterion.isValid()) {
      errors.push(
        <Alert type="error" dismissible={false}>
          {app.translator.trans(
            "askvortsov-auto-moderator.admin.criterion_page.invalid"
          )}
        </Alert>
      );
    }

    const validation = this.criterion.invalidActionSettings();
    if (validation && Object.keys(validation).length) {
      errors.push(
        <Alert type="error" dismissible={false}>
          {app.translator.trans(
            "askvortsov-auto-moderator.admin.criterion_page.validation"
          )}
          <div>
            <ol>
              {Object.keys(validation).map((key) => (
                <li>
                  <strong>{key}:</strong> {validation[key].join("")}
                </li>
              ))}
            </ol>
          </div>
        </Alert>
      );
    }

    return <div className="StatusCheck">{errors}</div>;
  }

  metricsAndRequirementsForm() {
    return (
      <div className="Form-group">
        <label>
          {app.translator.trans(
            "askvortsov-auto-moderator.admin.criterion_page.metrics_and_requirements_label"
          )}
        </label>
        <div className="helpText">
          {app.translator.trans(
            "askvortsov-auto-moderator.admin.criterion_page.metrics_and_requirements_help"
          )}
        </div>
        <div className="SettingsGroups">
          <div className="DriverGroup">
            <label>
              {app.translator.trans(
                "askvortsov-auto-moderator.admin.criterion_page.metrics_heading"
              )}
            </label>
            <ul className="DriverList DriverList--primary">
              {this.metrics().map((metric) => (
                <MetricItem
                  metric={metric}
                  metricDef={metricDefs[metric.type]}
                  selected={this.metrics}
                />
              ))}
            </ul>
            <span class="DriverGroup-controls">
              {Select.component({
                options: Object.keys(metricDefs).reduce((acc, key) => {
                  acc[key] = app.translator.trans(
                    metricDefs[key].translationKey
                  );
                  return acc;
                }, {}),
                value: this.newMetric(),
                onchange: this.newMetric,
              })}
              {Button.component({
                className: "Button DriverList-button",
                icon: "fas fa-plus",
                disabled: !this.newMetric(),
                onclick: () => {
                  this.metrics([
                    ...this.metrics(),
                    { type: this.newMetric(), min: Stream(), max: Stream() },
                  ]);
                },
              })}
            </span>
          </div>

          <div className="DriverGroup DriverGroup--secondary">
            <label>
              {app.translator.trans(
                "askvortsov-auto-moderator.admin.criterion_page.requirements_heading"
              )}
            </label>
            <ul className="DriverList DriverList--primary">
              {this.requirements().map((r) => (
                <RequirementItem
                  requirement={r}
                  requirementDef={requirementDefs[r.type]}
                  selected={this.requirements}
                />
              ))}
            </ul>
            <span class="DriverGroup-controls">
              {Select.component({
                options: Object.keys(requirementDefs).reduce((acc, key) => {
                  acc[key] = app.translator.trans(
                    requirementDefs[key].translationKey
                  );
                  return acc;
                }, {}),
                value: this.newRequirement(),
                onchange: this.newRequirement,
              })}
              {Button.component({
                className: "Button DriverList-button",
                icon: "fas fa-plus",
                disabled: !this.newRequirement(),
                onclick: () => {
                  this.requirements([
                    ...this.requirements(),
                    { type: this.newRequirement(), negated: Stream(false) },
                  ]);
                },
              })}
            </span>
          </div>
        </div>
      </div>
    );
  }

  actionsForm() {
    return (
      <div className="Form-group">
        <label>
          {app.translator.trans(
            "askvortsov-auto-moderator.admin.criterion_page.actions_label"
          )}
        </label>
        <div className="helpText">
          {app.translator.trans(
            "askvortsov-auto-moderator.admin.criterion_page.actions_help"
          )}
        </div>
        <div className="SettingsGroups">
          <div className="DriverGroup">
            <label>
              {app.translator.trans(
                "askvortsov-auto-moderator.admin.criterion_page.actions_on_gain_heading"
              )}
            </label>
            <ul className="DriverList DriverList--primary">
              {this.actionsOnGain().map((a) => (
                <ActionItem
                  action={a}
                  actionDef={actionDefs[a.type]}
                  selected={this.actionsOnGain}
                />
              ))}
            </ul>
            <span class="DriverGroup-controls">
              {Select.component({
                options: Object.keys(actionDefs).reduce((acc, key) => {
                  acc[key] = app.translator.trans(
                    actionDefs[key].translationKey
                  );
                  return acc;
                }, {}),
                value: this.newActionOnGain(),
                onchange: this.newActionOnGain,
              })}
              {Button.component({
                className: "Button DriverList-button",
                icon: "fas fa-plus",
                disabled: !this.newActionOnGain(),
                onclick: () => {
                  this.actionsOnGain([
                    ...this.actionsOnGain(),
                    { type: this.newActionOnGain(), settings: {} },
                  ]);
                },
              })}
            </span>
          </div>

          <div className="DriverGroup DriverGroup--secondary">
            <label>
              {app.translator.trans(
                "askvortsov-auto-moderator.admin.criterion_page.actions_on_loss_heading"
              )}
            </label>
            <ul className="DriverList">
              {this.actionsOnLoss().map((a) => (
                <ActionItem
                  action={a}
                  actionDef={actionDefs[a.type]}
                  selected={this.actionsOnLoss}
                />
              ))}
            </ul>
            <span class="DriverGroup-controls">
              {Select.component({
                options: Object.keys(actionDefs).reduce((acc, key) => {
                  acc[key] = app.translator.trans(
                    actionDefs[key].translationKey
                  );
                  return acc;
                }, {}),
                value: this.newActionOnLoss(),
                onchange: this.newActionOnLoss,
              })}
              {Button.component({
                className: "Button DriverList-button",
                icon: "fas fa-plus",
                disabled: !this.newActionOnLoss(),
                onclick: () => {
                  this.actionsOnLoss([
                    ...this.actionsOnLoss(),
                    { type: this.newActionOnLoss(), settings: {} },
                  ]);
                },
              })}
            </span>
          </div>
        </div>
      </div>
    );
  }

  data() {
    return {
      name: this.name(),
      description: this.description(),
      actions: [
        ...this.actionsOnGain().map((a) => {
          return { ...a, gain: true };
        }),
        ...this.actionsOnLoss().map((a) => {
          return { ...a, gain: false };
        }),
      ],
      metrics: this.metrics().map((m) => {
        return { type: m.type, min: m.min(), max: m.max() };
      }),
      requirements: this.requirements().map((r) => {
        return { type: r.type, negated: r.negated };
      }),
    };
  }

  delete(e) {
    e.preventDefault();

    this.deleting = true;
    m.redraw();

    this.criterion.delete().then(() => {
      m.route.set(app.route("extension", { id: "askvortsov-auto-moderator" }));
    });
  }

  onsubmit(e) {
    e.preventDefault();

    this.saving = true;
    m.redraw();

    const criterion = this.criterion || app.store.createRecord("criteria");

    criterion.save(this.data()).then((newCriterion) => {
      if (this.id === "new") {
        m.route.set(app.route.criterion(newCriterion));
      } else {
        this.loadCriterion(criterion);
        this.saving = false;
        m.redraw();
      }
    });
  }
}
