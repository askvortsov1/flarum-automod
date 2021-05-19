import Component from "flarum/Component";

export default class AutoModeratorInstructions extends Component {
  view() {
    return (
      <div className="AutoModeratorInstructions">
        <h4>
          {app.translator.trans(
            "askvortsov-auto-moderator.admin.automoderator_instructions.header"
          )}
        </h4>
        <ul>
          {app.translator.trans(
            "askvortsov-auto-moderator.admin.automoderator_instructions.text"
          )}
        </ul>
      </div>
    );
  }
}
