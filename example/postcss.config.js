const fs = require('fs');
const path = require('path');
const mkdirp = require('mkdirp');

const variables = require('./postcss.variables');

const cssPath = path.join(__dirname, process.env.MUSTACHE_CSS_DIR);
const buildPath = path.join(cssPath, '.css-modules');

module.exports = {
  parser: false,
  map: false,
  plugins: {
    'postcss-advanced-variables': {
      variables,
    },
    'postcss-modules': {
      generateScopedName: '[name]-[local]--[hash:base64:5]',
      getJSON(cssFileName, json) {
        const fullPath = path.dirname(cssFileName);
        const relativePath = fullPath.replace(cssPath, '');
        const cssName = path.basename(cssFileName, '.scss');
        const buildFilePath = path.join(buildPath, relativePath);
        const jsonFileName = path.join(buildFilePath, `${cssName}.json`);

        if (!fs.existsSync(buildFilePath)) {
          mkdirp.sync(buildFilePath);
        }

        fs.writeFileSync(jsonFileName, JSON.stringify(json));
      },
    },
    precss: {},
    cssnano: true,
    autoprefixer: {},
  },
};
