import Component from "flarum/Component";
import Button from "flarum/common/components/Button";

export default class UndefinedDriverItem extends Component {
  view() {
    const item = this.attrs.item;
    const selected = this.attrs.selected;

    return (
      <li>
        <div className="DriverListItem-info">
          <span className="DriverListItem-name DriverListItem-undefined">
            {app.translator.trans(
              "askvortsov-auto-moderator.admin.undefined_driver_item.text",
              { driverName: item.type }
            )}
          </span>
          {Button.component({
            className: "Button Button--link",
            icon: "fas fa-trash-alt",
            onclick: () => selected(selected().filter((val) => val !== item)),
          })}
        </div>
        <hr />
      </li>
    );
  }
}
