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
	touch node_modules

.PHONY: check
check: lint-sass lint-js test

.PHONY: dev
dev: node_modules
	npx patternlab serve

