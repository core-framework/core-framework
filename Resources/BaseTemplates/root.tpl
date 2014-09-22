<!DOCTYPE html>
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
            <link href="/styles/base/main.css" type="text/css" rel="stylesheet" />
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