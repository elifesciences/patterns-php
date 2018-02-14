elifeLibrary {
    def commit
    stage 'Checkout', {
        checkout scm
        commit = elifeGitRevision()
    }

    elifeVariants(['lowest', 'default'], { dependencies ->
        elifeLocalTests "dependencies=${dependencies} ./project_tests.sh", ["build/${dependencies}-phpunit.xml"]
    })

    elifeMainlineOnly {
        stage 'Downstream', {
            build job: '/dependencies/dependencies-journal-update-patterns-php', wait: false, parameters: [string(name: 'revision', value: commit)]
            build job: '/dependencies/dependencies-error-pages-update-patterns-php', wait: false, parameters: [string(name: 'revision', value: commit)]
        }
    }
}
