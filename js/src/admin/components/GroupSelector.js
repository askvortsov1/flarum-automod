import Component from 'flarum/Component';
import Button from 'flarum/components/Button';
import Dropdown from 'flarum/components/Dropdown';
import icon from 'flarum/helpers/icon';
import Group from 'flarum/models/Group';

export default class GroupSelector extends Component {
    view() {
        const group = app.store.getById('groups', this.attrs.id()) || app.store.getById('groups', Group.MEMBER_ID);
        return (
            <div className="Form-group">
                <p>{app.translator.transChoice('fof-default-group.admin.settings.info')}</p>

                <Dropdown label={[icon(group.icon()), '\t', group.namePlural()]} buttonClassName="Button Button--danger">
                    {app.store
                        .all('groups')
                        .filter((g) => ![Group.MEMBER_ID, Group.GUEST_ID].includes(g.id()))
                        .map((g) =>
                            Button.component(
                                {
                                    active: group.id() === g.id(),
                                    disabled: group && group.id() === g.id(),
                                    icon: g.icon() || icons[g.id()],
                                    onclick: () => {
                                        this.attrs.id(g.id());
                                    },
                                },
                                g.namePlural()
                            )
                        )}
                </Dropdown>
            </div>
        );
    }
}