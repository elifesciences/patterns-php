RESULT=$(find src tests -name '*.php' | xargs -L1 php -l)

if [ $? -eq 0 ]; then
	echo "No errors found"
fi

