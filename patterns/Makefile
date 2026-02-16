.PHONY: lint-sass
lint-sass: node_modules
	npx stylelint "assets/sass/**/*.scss"

node_modules: package.json package-lock.json
	npm install