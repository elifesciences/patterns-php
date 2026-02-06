const fs = require('fs');
const glob = require('glob');

const patternPath = 'assets/sass/patterns/**/[^_]*.scss';
const manifestPath = 'assets/sass/_pattern-manifest.scss';

const files = glob.sync(patternPath);

// Convert file paths into Sass @import statements
const imports = files.map(file => {
    // Clean path for Sass: remove 'assets/sass/' and extension
    const cleanPath = file.replace('assets/sass/', '').replace('.scss', '');
    return `@import "${cleanPath}";`;
}).join('\n');

fs.writeFileSync(manifestPath, imports);
console.log(`✅ Generated ${manifestPath} with ${files.length} imports.`);