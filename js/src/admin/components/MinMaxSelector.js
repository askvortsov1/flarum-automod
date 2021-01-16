import Component from 'flarum/Component';

export default class MinMaxSelector extends Component
{
    view() {
        return (
            <div className="Form-group">
                <p>MIN:</p>
                <input className="FormControl" type="number" placeholder="min" bidi={this.attrs.min}></input>
                <p>MAX:</p>
                <input className="FormControl" type="number" placeholder="max" bidi={this.attrs.max}></input>
            </div>
        );
    }
}