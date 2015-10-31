<!DOCTYPE html>
<!-- /**
* This file is part of the Core Framework package.
*
* (c) Shalom Sam <shalom.s@coreframework.in>
*
* For the full copyright and license information, please view the LICENSE
* file that was distributed with this source code.
*/ -->
<html>
<{block name="headBlock"}>
    <head>
        <{block name="title"}>
            <title><{$title}></title>
        <{/block}>
        <!-- Metas -->
        <{block name="metas"}>
            <meta charset="utf-8">
            <meta http-equiv="X-UA-Compatible" content="IE=edge">
            <meta name="viewport" content="width=device-width, initial-scale=1">
            <meta name="description" content="Core PHP Framework">
            <meta name="author" content="Shalom Sam">
        <{/block}>
        <!-- END: Metas -->
        <!-- Styles -->
        <{block name="styles"}>
            <link href="/styles/main.css" type="text/css" rel="stylesheet" />
        <{/block}>
        <!-- END: Styles -->
        <{block name="IECondn"}><{/block}>
    </head>
<{/block}>
<{block name="bodyBlock"}>
    <body>
        <{block name="contentWrp"}>
        <{/block}>
    </body>
<{/block}>
</html>