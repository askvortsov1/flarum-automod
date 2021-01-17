import ExtensionPage from 'flarum/components/ExtensionPage';
import LoadingIndicator from 'flarum/components/LoadingIndicator';
import Button from 'flarum/components/Button';
import TrustLevelModal from './TrustLevelModal';

function trustLevelItem(trustLevel) {
  return (
    <li data-id={trustLevel.id()}>
      <div className="TrustLevelListItem-info">
        <span className="TrustLevelListItem-name">{trustLevel.name()}</span>
        {Button.component({
          className: 'Button Button--link',
          icon: 'fas fa-pencil-alt',
          onclick: () => app.modal.show(TrustLevelModal, { model: trustLevel })
        })}
      </div>
    </li>
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
        <div className="TrustLevelsContent">
          <div className="container">
            <LoadingIndicator />
          </div>
        </div>
      );
    }

    return (
      <div className="TrustLevelsContent">
        <div className="TrustLevelsContent-list">
          <div className="container">
            <div className="SettingsGroups">
              <div className="TrustLevelGroup">
                <ol className="TrustLevelList TrustLevelList--primary">
                  {app.store.all('trust_levels')
                    .map(trustLevelItem)}
                </ol>
                {Button.component(
                  {
                    className: 'Button TrustLevelList-button',
                    icon: 'fas fa-plus',
                    onclick: () => app.modal.show(TrustLevelModal),
                  },
                  app.translator.trans('askvortsov-trust-levels.admin.trust_level_page.create_trust_level_button')
                )}
              </div>
            </div>
            <div className="TrustLevelsContent-footer">
              <p>{app.translator.trans('askvortsov-trust-levels.admin.trust_level_page.about_trust_levels_text')}</p>
            </div>
          </div>
        </div>
      </div>
    );
  }
}
