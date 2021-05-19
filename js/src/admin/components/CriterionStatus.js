import Component from "flarum/Component";
import Alert from "flarum/common/components/Alert";

export default class CriterionStatus extends Component {
  view() {
    const criterion = this.attrs.criterion;

    if (!criterion) return;
    const messages = [];

    if (criterion.isValid()) {
      messages.push(
        <Alert type="success" dismissible={false}>
          {app.translator.trans(
            "askvortsov-auto-moderator.admin.criterion_status.valid"
          )}
        </Alert>
      );
    } else {
      messages.push(
        <Alert type="error" dismissible={false}>
          {app.translator.trans(
            "askvortsov-auto-moderator.admin.criterion_status.invalid"
          )}
        </Alert>
      );
    }

    const validation = criterion.invalidActionSettings();
    if (validation && Object.keys(validation).length) {
      messages.push(
        <Alert type="error" dismissible={false}>
          {app.translator.trans(
            "askvortsov-auto-moderator.admin.criterion_status.validation"
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

    if (
      criterion.metrics().length === 0 &&
      criterion.requirements().length === 0
    ) {
      messages.push(
        <Alert type="danger" dismissible={false}>
          {app.translator.trans(
            "askvortsov-auto-moderator.admin.criterion_status.no_metrics_or_reqs"
          )}
        </Alert>
      );
    }

    if (criterion.actions().length === 0) {
      messages.push(
        <Alert type="danger" dismissible={false}>
          {app.translator.trans(
            "askvortsov-auto-moderator.admin.criterion_status.no_actions"
          )}
        </Alert>
      );
    }

    return (
      <div className="StatusCheck Form-group">
        <label>
          {app.translator.trans(
            "askvortsov-auto-moderator.admin.criterion_status.heading"
          )}
        </label>
        {messages}
      </div>
    );
  }
}
