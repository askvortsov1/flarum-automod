import Component from "flarum/Component";
import Button from "flarum/components/Button";
import Stream from "flarum/utils/Stream";

class MinMaxSelector extends Component {
  oninit(vnode) {
    super.oninit(vnode);

    this.state = MinMaxSelector.State.DISABLED;
    if (this.attrs.min() !== -1) this.state += 1;
    if (this.attrs.max() !== -1) this.state += 2;

    this.min = Stream(this.attrs.min());
    this.max = Stream(this.attrs.max());
  }

  view() {
    return (
      <div className="Form-group MinMaxSelector">
        <label>{this.attrs.label}</label>
        <div className="MinMaxSelector--inputs">{this.controls()}</div>
      </div>
    );
  }

  controls() {
    const minInput = () => (
      <input
        className="FormControl"
        type="number"
        min="0"
        max={
          this.state === MinMaxSelector.State.BETWEEN
            ? this.attrs.max() !== -1
              ? this.attrs.max()
              : this.max()
            : Infinity
        }
        placeholder="min"
        bidi={this.attrs.min}
      ></input>
    );

    const maxInput = () => (
      <input
        className="FormControl"
        type="number"
        min={
          this.state ===
          Math.max(
            0,
            MinMaxSelector.State.BETWEEN
              ? this.attrs.min() !== -1
                ? this.attrs.min()
                : this.min()
              : 0
          )
        }
        placeholder="max"
        bidi={this.attrs.max}
      ></input>
    );

    const placeholder = () => (
      <input
        className="FormControl MinMaxSelector--placeholder"
        disabled
        placeholder="X"
      ></input>
    );

    const button = (icon) => (
      <Button
        className="Button"
        onclick={this.cycle.bind(this)}
        icon={icon}
      ></Button>
    );

    switch (this.state) {
      case MinMaxSelector.State.DISABLED:
        return button("fas fa-power-off");
      case MinMaxSelector.State.LTE:
        return [placeholder(), button("fas fa-less-than-equal"), maxInput()];
      case MinMaxSelector.State.GTE:
        return [placeholder(), button("fas fa-greater-than-equal"), minInput()];
      case MinMaxSelector.State.BETWEEN:
        return [
          minInput(),
          button("fas fa-less-than-equal"),
          placeholder(),
          button("fas fa-less-than-equal"),
          maxInput(),
        ];
    }
  }

  cycle() {
    this.state++;
    this.state %= 4;

    if (this.attrs.min() !== -1) this.min(this.attrs.min());
    if (this.attrs.max() !== -1) this.max(this.attrs.max());

    switch (this.state) {
      case MinMaxSelector.State.DISABLED:
        this.attrs.min(-1);
        this.attrs.max(-1);
        break;
      case MinMaxSelector.State.GTE:
        this.attrs.min(this.min());
        this.attrs.max(-1);
        break;
      case MinMaxSelector.State.LTE:
        this.attrs.min(-1);
        this.attrs.max(this.max());
        break;
      case MinMaxSelector.State.BETWEEN:
        this.attrs.min(this.min());
        this.attrs.max(this.max());
        break;
    }
  }
}

MinMaxSelector.State = {
  DISABLED: 0,
  GTE: 1,
  LTE: 2,
  BETWEEN: 3,
};

export default MinMaxSelector;
