import TrustLevelsPage from './components/TrustLevelsPage';

import TrustLevel from '../common/models/TrustLevel';

app.initializers.add('askvortsov/flarum-trust-levels', () => {
  app.store.models.trust_levels = TrustLevel;
  app.extensionData.for('askvortsov-trust-levels').registerPage(TrustLevelsPage);
});
