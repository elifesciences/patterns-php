.PHONY: lint-sass
lint-sass: node_modules
	npx stylelint "assets/sass/**/*.scss"

.PHONY: lint-js
lint-js: node_modules
	npx eslint assets source

node_modules: package.json package-lock.json
	npm install

