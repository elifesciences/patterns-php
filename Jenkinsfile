elifeLibrary {
    def commit
    def message
    stage 'Checkout', {
        checkout scm
        commit = elifeGitRevision()
        message = sh script: "git log -1 --pretty=%B | head -n 1", returnStdout: true
        sh script: "php -v"
    }

    elifeVariants(['lowest', 'default'], { dependencies ->
        elifeLocalTests "dependencies=${dependencies} ./project_tests.sh", ["build/${dependencies}-phpunit.xml"]
    })

    elifeMainlineOnly {
        stage 'Downstream', {
            build job: '/dependencies/dependencies-journal-update-patterns-php', wait: false, parameters: [string(name: 'revision', value: commit), string(name: 'message', value: message)]
            build job: '/dependencies/dependencies-error-pages-update-patterns-php', wait: false, parameters: [string(name: 'revision', value: commit)]
        }
    }
}
