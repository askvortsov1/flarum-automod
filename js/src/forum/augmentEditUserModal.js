import { extend, override } from 'flarum/extend';
import EditUserModal from 'flarum/components/EditUserModal';
import GroupBadge from 'flarum/components/GroupBadge';
import LoadingIndicator from 'flarum/components/LoadingIndicator';
import ItemList from 'flarum/utils/ItemList';

export default function augmentEditUserModal() {
    extend(EditUserModal.prototype, 'oninit', function () {
        this.loading = true;
        app.store.find('trust_levels').then((levels) => {
            levels.forEach(level => delete this.groups[level.group().id()]);

            this.loading = false;
            m.redraw();
        });
    });

    override(EditUserModal.prototype, 'fields', function (original) {
        if (this.loading) {
            const items = new ItemList();
            items.add('loading', <LoadingIndicator></LoadingIndicator>);
            return items;
        }

        const items = original();

        items.add('trustLevels',
            <div className="Form-group">
                <label>{app.translator.trans('askvortsov-trust-levels.forum.edit_user.trust_levels_heading')}</label>
                {app.store.all('trust_levels').map(
                    (trustLevel) =>
                        <label className="checkbox">
                            <input
                                type="checkbox"
                                checked={this.attrs.user.trustLevels().includes(trustLevel)}
                                disabled={true}
                            />
                            {app.translator.trans('askvortsov-trust-levels.forum.edit_user.trust_level_item', {
                                badge: GroupBadge.component({ group: trustLevel.group(), label: '' }),
                                level: trustLevel.name(),
                                groupName: trustLevel.group().nameSingular()
                            })}
                        </label>
                )}
                <p>{app.translator.trans('askvortsov-trust-levels.forum.edit_user.trust_levels_not_editable')}</p>
            </div>, 10);

        return items;
    });
}