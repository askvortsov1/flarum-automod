import ExtensionPage from 'flarum/components/ExtensionPage';
import LoadingIndicator from 'flarum/components/LoadingIndicator';
import Button from 'flarum/components/Button';
import icon from 'flarum/helpers/icon';
import TrustLevelModal from './TrustLevelModal';

function trustLevelItem(trustLevel) {
  const name = trustLevel ? trustLevel.name() : app.translator.trans('askvortsov-trust-levels.admin.trust_level_page.create_trust_level_button');
  const iconName = trustLevel ? trustLevel.group().icon() : 'fas fa-plus';
  const style = trustLevel ? { 'background-color': trustLevel.group().color(), color: 'white' } : '';
  return (
    <div
      className="ExtensionListItem"
      onclick={() => app.modal.show(TrustLevelModal, { model: trustLevel })}
    >
      <span className="ExtensionListItem-icon ExtensionIcon" style={style}>
        {icon(iconName)}
      </span>
      <span className="ExtensionListItem-title">{name}</span>
    </div>
  );
}


export default class TrustLevelsPage extends ExtensionPage {
  oninit(vnode) {
    super.oninit(vnode);

    this.loading = true;

    app.store.find('trust_levels')
      .then(() => {
        this.loading = false;
        m.redraw();
      });
  }
  content() {
    if (this.loading || this.saving) {
      return (
        <div className="TrustLevels">
          <div className="container">
            <LoadingIndicator />
          </div>
        </div>
      );
    }

    return (
      <div className="TrustLevels">
        <div className="container">
          <div className="ExtensionsWidget-list TrustLevels-list">
            <p className="TrustLevels-list-heading">{app.translator.trans('askvortsov-trust-levels.admin.trust_level_page.list_heading')}</p>
            <div className="ExtensionList">
              {[...app.store.all('trust_levels')
                .map(trustLevelItem), trustLevelItem()]}
            </div>
          </div>
          <div className="TrustLevels-footer">
            <p>{app.translator.trans('askvortsov-trust-levels.admin.trust_level_page.about_trust_levels_text')}</p>
          </div>
        </div>
      </div>
    );
  }
}
