import Model from 'flarum/Model';

export default class TrustLevel extends Model { }

Object.assign(TrustLevel.prototype, {
    name: Model.attribute('name'),
    group: Model.hasOne('group'),

    minDiscussionsEntered: Model.attribute('minDiscussionsEntered'),
    maxDiscussionsEntered: Model.attribute('maxDiscussionsEntered'),

    minDiscussionsParticipated: Model.attribute('minDiscussionsParticipated'),
    maxDiscussionsParticipated: Model.attribute('maxDiscussionsParticipated'),
    minDiscussionsStarted: Model.attribute('minDiscussionsStarted'),
    maxDiscussionsStarted: Model.attribute('maxDiscussionsStarted'),
    minPostsMade: Model.attribute('minPostsMade'),
    maxPostsMade: Model.attribute('maxPostsMade'),
});
