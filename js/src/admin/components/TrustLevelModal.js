import Modal from 'flarum/components/Modal';
import Button from 'flarum/components/Button';
import LoadingIndicator from 'flarum/components/LoadingIndicator';
import ItemList from 'flarum/utils/ItemList';
import Stream from 'flarum/utils/Stream';

import MinMaxSelector from './MinMaxSelector';
import GroupSelector from './GroupSelector';

/**
 * The `EditTrustLevelModal` component shows a modal dialog which allows the user
 * to create or edit a trustlevel.
 */
export default class TrustLevelModal extends Modal {
  oninit(vnode) {
    super.oninit(vnode);

    this.trustLevel = this.attrs.model || app.store.createRecord('trust_levels');

    const currGroup = this.trustLevel.group();
    this.groupId = Stream(currGroup ? currGroup.id() : null);

    this.name = Stream(this.trustLevel.name() || '');

    this.loading = true;

    app
      .request({
        method: 'GET',
        url: app.forum.attribute('apiUrl') + '/trust_level_drivers',
      })
      .then((response) => {
        this.rangeTranslations = response['data']['attributes']['drivers'];

        this.ranges = Object.keys(this.rangeTranslations);

        this.ranges.forEach((rangeName) => {
          const ranges = this.trustLevel.ranges() || [];
          const min = ranges[`min${rangeName}`];
          const max = ranges[`max${rangeName}`];
          this[`min${rangeName}`] = Stream(min ? min : -1);
          this[`max${rangeName}`] = Stream(max ? max : -1);
        });

        this.loading = false;
        m.redraw();
      });
  }

  className() {
    return 'EditTrustLevelModal Modal--small';
  }

  title() {
    return this.name()
      ? this.name()
      : app.translator.trans('askvortsov-trust-levels.admin.trust_level_modal.title');
  }

  content() {
    if (this.loading) {
      return (
        <div className="Modal-body">
          <div className="Form">
            <div className="container">
              <LoadingIndicator />
            </div>
          </div>
        </div>
      );
    }

    return (
      <div className="Modal-body">
        <div className="Form">
          {this.fields().toArray()}
        </div>
      </div>
    );
  }

  fields() {
    const items = new ItemList();

    items.add('name', <div className="Form-group">
      <label>{app.translator.trans('askvortsov-trust-levels.admin.trust_level_modal.name_label')}</label>
      <input className="FormControl" placeholder={app.translator.trans('askvortsov-trust-levels.admin.trust_level_modal.name_placeholder')} bidi={this.name} />
    </div>, 50);

    items.add('group', <div className="Form-group">
      <GroupSelector
        label={app.translator.trans('askvortsov-trust-levels.admin.trust_level_modal.group_label')}
        id={this.groupId}
        disabled={this.trustLevel.exists}
      ></GroupSelector>
    </div>, 50);

    this.ranges.forEach((range) => {
      items.add(range,
        <MinMaxSelector
          label={app.translator.trans(this.rangeTranslations[range])}
          min={this[`min${range}`]}
          max={this[`max${range}`]}
        ></MinMaxSelector>
        , 40);
    })

    items.add('submit', <div className="Form-group">
      {Button.component({
        type: 'submit',
        className: 'Button Button--primary EditTrustLevelModal-save',
        loading: this.loading,
        disabled: this.name().length === 0 || !this.groupId()
      }, app.translator.trans('askvortsov-trust-levels.admin.trust_level_modal.submit_button'))}
      {this.trustLevel.exists ? (
        <button type="button" className="Button EditTrustLevelModal-delete" onclick={this.delete.bind(this)}>
          {app.translator.trans('askvortsov-trust-levels.admin.trust_level_modal.delete_button')}
        </button>
      ) : ''}
    </div>, -10);

    return items;
  }

  submitData() {
    const group = app.store.getById('groups', this.groupId());

    const data = {
      name: this.name(),
      relationships: { group }
    };

    this.ranges.forEach((rangeName) => {
      data[`min${rangeName}`] = this[`min${rangeName}`]();
      data[`max${rangeName}`] = this[`max${rangeName}`]();
    });

    return data;
  }

  onsubmit(e) {
    e.preventDefault();

    this.loading = true;

    // Errors aren't passed to the modal onerror handler here.
    // This is done for better error visibility on smaller screen heights.
    this.trustLevel.save(this.submitData()).then(
      () => this.hide(),
      () => this.loading = false
    );
  }

  delete() {
    if (confirm(app.translator.trans('askvortsov-trust-levels.admin.trust_level_modal.delete_confirmation'))) {

      this.trustLevel.delete().then(() => {
        m.redraw();
      });

      this.hide();
    }
  }
}
