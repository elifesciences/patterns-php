elifeLibrary {
    stage 'Checkout', {
        checkout scm
    }

    elifeVariants(['lowest', 'default'], { dependencies ->
        elifeLocalTests "dependencies=${dependencies} ./project_tests.sh", ["build/${dependencies}-phpunit.xml"]
    })

    elifeMainlineOnly {
        stage 'Downstream', {
            build job: 'dependencies-journal-update-patterns-php', wait: false
            build job: 'dependencies-error-pages-update-patterns-php', wait: false
        }
    }
}
