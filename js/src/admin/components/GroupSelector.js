import Component from 'flarum/Component';
import Button from 'flarum/components/Button';
import Dropdown from 'flarum/components/Dropdown';
import icon from 'flarum/helpers/icon';
import Group from 'flarum/models/Group';

export default class GroupSelector extends Component {
    view() {
        const group = app.store.getById('groups', this.attrs.id());
        const label = group ? [icon(group.icon()), '\t', group.namePlural()] : app.translator.trans('askvortsov-trust-levels.admin.group_selector.placeholder');
        return (
            <div className="Form-group">
                <label>{this.attrs.label}</label>

                {this.attrs.disabled ? <div className="Button Button--danger">{label}</div>
                :
                    <Dropdown label={label} disabled={this.attrs.disabled} buttonClassName="Button Button--danger">
                        {app.store
                            .all('groups')
                            .filter((g) => ![Group.MEMBER_ID, Group.GUEST_ID].includes(g.id()))
                            .map((g) =>
                                Button.component(
                                    {
                                        active: group && group.id() === g.id(),
                                        disabled: group && group.id() === g.id(),
                                        icon: g.icon() || icons[g.id()],
                                        onclick: () => {
                                            this.attrs.id(g.id());
                                        },
                                    },
                                    g.namePlural()
                                )
                            )}
                    </Dropdown>}
            </div>
        );
    }
}