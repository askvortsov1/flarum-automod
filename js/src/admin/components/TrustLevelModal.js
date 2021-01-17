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

    console.log(this.trustLevel, currGroup)

    this.name = Stream(this.trustLevel.name() || '');
    this.minDiscussionsEntered = Stream(this.trustLevel.minDiscussionsEntered() || -1);
    this.maxDiscussionsEntered = Stream(this.trustLevel.maxDiscussionsEntered() || -1);
    this.minDiscussionsParticipated = Stream(this.trustLevel.minDiscussionsParticipated() || -1);
    this.maxDiscussionsParticipated = Stream(this.trustLevel.maxDiscussionsParticipated() || -1);
    this.minDiscussionsStarted = Stream(this.trustLevel.minDiscussionsStarted() || -1);
    this.maxDiscussionsStarted = Stream(this.trustLevel.maxDiscussionsStarted() || -1);
    this.minPostsMade = Stream(this.trustLevel.minPostsMade() || -1);
    this.maxPostsMade = Stream(this.trustLevel.maxPostsMade() || -1);
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
      ></GroupSelector>
    </div>, 50);

    items.add('discussionsEntered',
      <MinMaxSelector
        label={app.translator.trans('askvortsov-trust-levels.admin.trust_level_modal.discussions_entered_label')}
        min={this.minDiscussionsEntered}
        max={this.maxDiscussionsEntered}
      ></MinMaxSelector>, 40);

    items.add('discussionsParticipated',
      <MinMaxSelector
        label={app.translator.trans('askvortsov-trust-levels.admin.trust_level_modal.discussions_participated_label')}
        min={this.minDiscussionsParticipated}
        max={this.maxDiscussionsParticipated}
      ></MinMaxSelector>
      , 30);

    items.add('discussionsStarted',
      <MinMaxSelector
        label={app.translator.trans('askvortsov-trust-levels.admin.trust_level_modal.discussions_started_label')}
        min={this.minDiscussionsStarted}
        max={this.maxDiscussionsStarted}
      ></MinMaxSelector>
      , 30);

    items.add('postsMade',
      <MinMaxSelector
        label={app.translator.trans('askvortsov-trust-levels.admin.trust_level_modal.posts_made_label')}
        min={this.minPostsMade}
        max={this.maxPostsMade}
      ></MinMaxSelector>
      , 30);

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

    return {
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
