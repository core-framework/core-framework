<?php

return $page = [
    'mainHeader' => 'About',
    'introBlock' => '<strong>Core Framework</strong> is a Open Source PHP framework for developing Web 2.0 applications. This framework was written in PHP 5.4+.
        <br/><br/>
        Core Framework was build as a simple, yet secure and fast framework with no or minimal overhead. This framework was build using the latest coding standards and best practices. It was also build with flexibility in mind. Core Framework was specifically build with Web application in mind, but can be used for any type of web development project. Core Framework also provides easy means for CRUD implementation in your Web Application.',
    'subTitle1' => 'Performance',
    'subTitle1_pLink' => 'performance',
    'subPara1' => '<p>Core Framework believes in performance. In the growing world of Web applications and E-commerce websites, performance matters. Core Frameworks being a very light framework provides high performance. Below are the results of an http benchmark performance test -</p>
    <h4>With APC</h4>
    <p class="para">
        <img src="/images/screenshot-apc.jpg" alt="Test with APC screenshot"/>
    </p>
    <h4>Without APC</h4>
    <p class="para">
        <img src="/images/screenshot-no-apc.jpg" alt="Test without APC screenshot"/>
    </p>
    <p class="para">
        That said these reading must be taken with a pinch of salt, as there are a lot of variables in these tests, and these variables could result in difference in results for different frameworks under different environments and settings. Also Core Framework does not make any claim that it is a better framework than others or discourage the use of other framework in anyway.
    </p>
    <h4>Benchmark Tool</h4>
    <p class="para">
        The test tool used, as evident in the images, is Apache Benchmark (ab).
    </p>
    <pre class="prettyprint">ab -t 30 -c 10 http://coreframework.in/test/hello/sam</pre>
    <p class="para">
        As seen the URL used has a dynamic component to it .i.e. "sam". Essentially the page prints "Hello sam" (in this case), but in actuality print "Hello {variable}", where the variable component is picked from the URL in the routing class. As most framework benchmarks (out there) was performed at their bare minimum, so was Core Framework&rsquo;s, with a minimal "Hello sam" page output. The output was generated through the frameworks normal request to response to template cycle.
    </p>
    <h4>Benchmark Environment</h4>
    <p class="para">
        The arguments passed to Apache Benchmark are "-t 30 -c 10 URL", which mean request where made the given URL for 30 seconds ( -t 30 ) and for each request there were 10 concurrent requests made ( -c 10 ).

        The testing environment was as follows -
        <ul>
            <li>Operating System: Ubuntu 14.04</li>
            <li>Web Server: Apache/2.4.7</li>
            <li>PHP: 5.5.9-1ubuntu4.5</li>
            <li>CPU: 1 virtual core</li>
            <li>RAM: 1GB</li>
            <li>HDD: 30GB SSD</li>
        </ul>

        The APC setting were as follows:
        <ul>
            <li>apc.coredump_unmap	Off</li>
            <li>apc.enable_cli	Off</li>
            <li>apc.enabled	On</li>
            <li>apc.entries_hint	4096</li>
            <li>apc.gc_ttl	3600	3600</li>
            <li>apc.mmap_file_mask	no value</li>
            <li>apc.preload_path	no value</li>
            <li>apc.rfc1867     Off</li>
            <li>apc.rfc1867_freq	0</li>
            <li>apc.rfc1867_ttl	3600</li>
            <li>apc.serializer	php	</li>
            <li>apc.shm_segments	1</li>
            <li>apc.shm_size	32M</li>
            <li>apc.slam_defense	On</li>
            <li>apc.smart	0</li>
            <li>apc.ttl	0</li>
            <li>apc.use_request_time	On</li>
        </ul>
    </p>

    ',
    'subTitle2' => 'Credits',
    'subTitle2_pLink' => 'credits',
    'subPara2' => '<p class="para">
            Core Framework incorporates other well known packages and Web frameworks and applications. Bellow is a list of these packages / applications that inspired and made Core Framework possible -
        </p>
        <ul class="list">
            <li>
                <a href="http://jquery.com/">Jquery</a>: Core Framework integrates jquery as the main Javascript framework.
            </li>
            <li>
                <a href="http://getbootstrap.com/">Bootstrap</a>: Core Framework integrates Bootstrap for its large and useful set of components and styling solutions.
            </li>
            <li>
                <a href="http://bower.io/">Bower</a>: Core Framework uses bower for front-end package management.
            </li>
            <li>
                <a href="https://getcomposer.org/">Composer</a>: Core Framework uses Composer for PHP package management and for its auto loading (class) capabilities.
            </li>
            <li>
                <a href="http://apigen.org/">Apigen</a>: Core Framework used apigen for generating the API docs.
            </li>
            <li>
                <a href="http://filp.github.io/whoops/">Whoops</a>: Core Framework uses Whoops for prettyfied error messaging.
            </li>
            <li>
                <a href="http://www.smarty.net/">Smarty</a>: Core Framework relies on the Smarty Template Engine for its flexible templating capabilities.
            </li>
        </ul>',
    'subTitle3' => 'License',
    'subTitle3_pLink' => 'license'
];