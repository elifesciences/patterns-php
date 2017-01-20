elifeLibrary {
    stage 'Checkout', {
        checkout scm
    }

    elifeVariants(['lowest', 'default'], { dependencies ->
        elifeLocalTests "dependencies=${dependencies} ./project_tests.sh", ["build/${dependencies}-phpunit.xml"]
    })

    stage 'Downstream', {
        build job: 'dependencies-journal-update-patterns-php', wait: false
    }
}
