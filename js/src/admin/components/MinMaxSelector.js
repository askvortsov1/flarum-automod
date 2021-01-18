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
        <div className="MinMaxSelector--inputs">
          {this.showMin()
            ? [
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
                ></input>,
                <Button
                  className="Button"
                  onclick={this.cycle.bind(this)}
                  icon="fas fa-less-than-equal"
                ></Button>,
              ]
            : ""}
          {this.state === MinMaxSelector.State.DISABLED ? (
            <Button
              className="Button"
              onclick={this.cycle.bind(this)}
              icon="fas fa-power-off"
            ></Button>
          ) : (
            <input
              className="FormControl MinMaxSelector--placeholder"
              disabled
              value="X"
            ></input>
          )}
          {this.showMax()
            ? [
                <Button
                  className="Button"
                  onclick={this.cycle.bind(this)}
                  icon="fas fa-less-than-equal"
                ></Button>,
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
                ></input>,
              ]
            : ""}
        </div>
      </div>
    );
  }

  cycle() {
    this.state++;
    this.state %= 4;

    if (this.attrs.min() !== -1) this.min(this.attrs.min());
    if (this.attrs.max() !== -1) this.max(this.attrs.max());

    switch (this.state) {
      case 0:
        this.attrs.min(-1);
        this.attrs.max(-1);
        break;
      case 1:
        this.attrs.min(this.min());
        this.attrs.max(-1);
        break;
      case 2:
        this.attrs.min(-1);
        this.attrs.max(this.max());
        break;
      case 3:
        this.attrs.min(this.min());
        this.attrs.max(this.max());
        break;
    }
  }

  showMin() {
    return (
      this.state === MinMaxSelector.State.lTE ||
      this.state === MinMaxSelector.State.BETWEEN
    );
  }

  showMax() {
    return (
      this.state === MinMaxSelector.State.GTE ||
      this.state === MinMaxSelector.State.BETWEEN
    );
  }
}

MinMaxSelector.State = {
  DISABLED: 0,
  lTE: 1,
  GTE: 2,
  BETWEEN: 3,
};

export default MinMaxSelector;
