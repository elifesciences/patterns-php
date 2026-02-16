.PHONY: lint-sass
lint-sass: node_modules
	npx stylelint "assets/sass/**/*.scss"

.PHONY: lint-js
lint-js: node_modules
	npx eslint assets source

.PHONY: test
test: node_modules
	npx gulp buildTests
	npx playwright test

node_modules: package.json package-lock.json
	npm install

