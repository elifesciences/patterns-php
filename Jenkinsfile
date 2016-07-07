elifeLibrary {
    stage 'Checkout'
    checkout scm

    def dependenciesVariants = ['lowest', 'default']

    for (int i = 0; i < dependenciesVariants.size(); i++) {
        def dependencies = dependenciesVariants.get(i)

        stage "Tests, ${dependencies} dependencies"
        sh "dependencies=${dependencies} ./project_tests.sh || echo TESTS FAILED"
        elifeTestArtifact "build/${dependencies}-phpunit.xml"
        elifeVerifyJunitXml "build/${dependencies}-phpunit.xml"
    }
}
