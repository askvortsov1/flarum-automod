import registerModels from '../common/registerModels';
import TrustLevelsPage from './components/TrustLevelsPage';

app.initializers.add('askvortsov/flarum-trust-levels', () => {
  app.extensionData.for('askvortsov-trust-levels').registerPage(TrustLevelsPage);

  registerModels();
});
