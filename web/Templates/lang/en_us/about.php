<?php

return $page = [
    'mainHeader' => 'About',
    'introBlock' => '<strong>Core Framework</strong> is a Open Source MVC framework for developing Web 2.0 applications in PHP. This framework was build from ground up in PHP 5.4+ and incorporates the latest features and conventions. This framework was started by <a href="http://shalomsam.com">Shalom Sam</a> in late 2013 and was build to be completely object-oriented, while utilizing most of the new features of PHP 5.4. Core Framework was build to be simple and easy to use, and comes with a demo application already setup, making it easy for you the developer to start building your application right away.
        <br/><br/>
        Core Framework is build as components that can be used individually in any other application. The main components that make up Core Framework are Router, BaseController, AppView and DI (Dependency Injection) components. The Router component determines which controller to load based on the current URI and the provided routing instruction. The BaseController component performs the required set of instruction before invoking the method on your child controller based on the current URI. The AppView component is a wrapper around the templating Engine, which currently is Smarty (Support for other templating Engines will come soon). And finally the DI component or Dependency Injection component is responsible for laoding all components or classes seamlessly at run time. DI can also be used to load your own components into your application as and when required.',
    'subTitle1' => 'Performance',
    'subTitle1_pLink' => 'performance',
    'subPara1' => '<p>Core Framework being relatively a new framework has shown decent performance. In preliminary benchmark tests Core Framework has delivered a decent ~350 request per second.</p>
    <p class="para">
        That said these reading must be taken with a pinch of salt, as there are a lot of variables in these tests, and these variables could result in difference in results for different frameworks under different environments and settings.
    </p>
    <h4>Benchmark Tool</h4>
    <p class="para">
        The test tool used is Apache Benchmark (ab).
    </p>
    <pre class="prettyprint">ab -t 30 -c 10 http://localhost/test/helloworld</pre>
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
            Core Framework uses other well known packages and/or applications. Below is a list of these packages / applications that inspired and made Core Framework possible -
        </p>
        <ul class="list">
            <li>
                <a href="http://jquery.com/">Jquery</a>: Core Framework integrates jquery as the main Javascript framework.
            </li>
            <li>
                <a href="http://getbootstrap.com/">Bootstrap</a>: Core Framework integrates Bootstrap for its large and useful set of front-end components and styling solutions.
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