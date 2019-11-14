const fs = require('fs');
const path = require('path');

const variables = require('./postcss.variables');

const cssPath = process.env.MUSTACHE_CSS_DIR;
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
        const jsonFileName = path.join(buildPath, relativePath, `${cssName}.json`);
        fs.writeFileSync(jsonFileName, JSON.stringify(json));
      },
    },
    precss: {},
    cssnano: true,
    autoprefixer: {},
  },
};
