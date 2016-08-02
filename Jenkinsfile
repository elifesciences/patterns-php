elifeLibrary {
    stage 'Checkout'
    checkout scm

    elifeVariants(['lowest', 'default'], { dependencies ->
        sh "dependencies=${dependencies} ./project_tests.sh || echo TESTS FAILED"
        elifeTestArtifact "build/${dependencies}-phpunit.xml"
        elifeVerifyJunitXml "build/${dependencies}-phpunit.xml"
    })
}
