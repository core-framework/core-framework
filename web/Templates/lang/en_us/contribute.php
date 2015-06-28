<?php

return $page = [
    'mainHeading' => 'Contribute',
    'introPara' => '
        <p class="para">
            There are multiple ways to contribute to the Core Framework project, irrespective of whether you are a developer or not.
            <br/><br/>
            Contribution can be made to Core Framework by Forking of, of the <a href="https://github.com/core-framework/core-framework">Core Framework repository</a>. Once you have forked the repository you can pull the desired branch make your changes and/or feature adds and then send back a pull-request. If your changes qualify the requirements and standards, then it&apos;ll be added to the codebase.
        </p>
    ',

    'subTitle1' => 'How do I contribute?',
    'subTitle1_pLink' => 'how_to_contribute',
    'subPara1' => '
        <p class="para">
            Three basic ways you can contribute are :
        </p>
        <div class="container-fluid btnContainer">
            <div class="row">
                <div class="col-xs-12 col-sm-4">
                    <a href="https://github.com/core-framework/CoreFramework/issues" class="btn btn-block btn-danger">Report Bugs & Issues</a>
                </div>
                <div class="col-xs-12 col-sm-4">
                    <a href="https://github.com/core-framework/CoreFramework/fork" class="btn btn-block btn-success">Feature Adds</a>
                </div>
                <div class="col-xs-12 col-sm-4">
                    <a href="https://github.com/core-framework/CoreFramework/fork" class="btn btn-block btn-primary">Improve Documentation</a>
                </div>
            </div>
        </div>
        <br/><br/>
        <p class="para">
            <strong>Report Bugs and Issues</strong>: GitHub has an amazing feature called Issues, which is an issue tracker. Here you can report bugs and issues. Issues can also be used to request feature adds.
            <br/><br/>
            <strong>Feature Adds</strong>: You fork of, of Core Framework and then dive into a desired branch or make one of your own and then add your features or fixes to the code. Once you made your changes and would like to see them in Core Framework as well, you could send a pull request with an explanation of the changes made. All changes and feature adds must be submitted with proven test (in the <code>Test</code> directory). For more information on how to write tests in PHP, refer to the <a href="https://phpunit.de/">PHPUnit website</a>.
            <br/><br/>
            <strong>Improve Documentation</strong>: To improve these Documentations, you must first fork of, of the Core Framework repository, and then checkout the <code>gh-pages</code> branch. Once you have done this you will find the Documentation texts in the <code>{PROJECT_FOLDER}/web/Templates/</code> directory. Here you&apos;ll find the textual data separated out in <code>{PROJECT_FOLDER}/web/Templates/lang/en_us/</code> directory. And the layouts are present as template files in the <code>{PROJECT_FOLDER}/web/Templates/layouts/</code> directory.
            <br/><br/>
            <strong>Other ways to contribute</strong>: If you would like to be a part of a core team in enhancing Core Framework send a mail at shalom.s {at} coreframework.in
        </p>
    '
];