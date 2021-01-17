import Modal from 'flarum/components/Modal';
import Button from 'flarum/components/Button';
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

    this.rangeTranslations = {
      'DiscussionsEntered': 'askvortsov-trust-levels.admin.trust_level_modal.ranges.discussions_entered_label',
      'DiscussionsParticipated': 'askvortsov-trust-levels.admin.trust_level_modal.ranges.discussions_participated_label',
      'DiscussionsStarted': 'askvortsov-trust-levels.admin.trust_level_modal.ranges.discussions_started_label',
      'PostsMade': 'askvortsov-trust-levels.admin.trust_level_modal.ranges.posts_made_label'
    };

    this.ranges = Object.keys(this.rangeTranslations);

    this.ranges.forEach((range) => {
      this[`min${range}`] = Stream(this.trustLevel[`min${range}`]() || -1);
      this[`max${range}`] = Stream(this.trustLevel[`max${range}`]() || -1);
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

      minDiscussionsEntered: this.minDiscussionsEntered(),
      maxDiscussionsEntered: this.maxDiscussionsEntered(),

      minDiscussionsParticipated: this.minDiscussionsParticipated(),
      maxDiscussionsParticipated: this.maxDiscussionsParticipated(),
      minDiscussionsStarted: this.minDiscussionsStarted(),
      maxDiscussionsStarted: this.maxDiscussionsStarted(),
      minPostsMade: this.minPostsMade(),
      maxPostsMade: this.maxPostsMade(),

      relationships: { group }
    };

    this.ranges.forEach(() => {
      data[`min${range}`] = this[`min${range}`]();
      data[`max${range}`] = this[`max${range}`]();
    });
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
    if (confirm(app.translator.trans('askvortsov-trust-levels.admin.trust_level_modal.delete_trustlevel_confirmation'))) {

      this.trustLevel.delete().then(() => {
        m.redraw();
      });

      this.hide();
    }
  }
}
