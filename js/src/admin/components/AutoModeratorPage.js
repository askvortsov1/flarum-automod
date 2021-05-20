import ExtensionPage from "flarum/admin/components/ExtensionPage";
import Link from "flarum/common/components/Link";
import LoadingIndicator from "flarum/common/components/LoadingIndicator";
import Tooltip from "flarum/common/components/Tooltip";
import icon from "flarum/common/helpers/icon";
import classList from "flarum/common/utils/classList";
import stringToColor from "flarum/common/utils/stringToColor";
import ManagedGroups from "../../common/components/ManagedGroups";
import AutoModeratorInstructions from "./AutoModeratorInstructions";

function criterionItem(criterion) {
  const name = criterion
    ? criterion.name()
    : app.translator.trans(
        "askvortsov-auto-moderator.admin.automoderator_page.create_criterion_button"
      );
  const iconName = criterion
    ? criterion.icon() || "fas fa-bolt"
    : "fas fa-plus";
  const style = criterion
    ? { "background-color": `#${stringToColor(criterion.name())}` }
    : "";

  return (
    <Link className="ExtensionListItem" href={app.route.criterion(criterion)}>
      <span className="ExtensionListItem-icon ExtensionIcon" style={style}>
        {icon(iconName)}
      </span>
      <span
        className={classList({
          "ExtensionListItem-title": true,
          "ExtensionListItem--invalid": criterion && !criterion.isValid(),
        })}
      >
        {criterion && !criterion.isValid() && (
          <Tooltip
            text={app.translator.trans(
              "askvortsov-auto-moderator.admin.automoderator_page.criterion_invalid"
            )}
          >
            {icon("fas fa-exclamation-triangle")}
          </Tooltip>
        )}
        {name}
      </span>
    </Link>
  );
}

export default class AutoModeratorPage extends ExtensionPage {
  oninit(vnode) {
    super.oninit(vnode);

    this.loading = true;

    app.store.find("criteria").then(() => {
      this.loading = false;
      m.redraw();
    });
  }
  content() {
    if (this.loading) {
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
          <div className="ExtensionsWidget-list Criteria-list">
            <p className="Criteria-list-heading">
              {app.translator.trans(
                "askvortsov-auto-moderator.admin.automoderator_page.list_heading"
              )}
            </p>
            <div className="ExtensionList">
              {[
                ...app.store.all("criteria").map(criterionItem),
                criterionItem(),
              ]}
            </div>
          </div>
          <ManagedGroups criteria={app.store.all("criteria")} />
          <hr />
          <AutoModeratorInstructions />
        </div>
      </div>
    );
  }
}
