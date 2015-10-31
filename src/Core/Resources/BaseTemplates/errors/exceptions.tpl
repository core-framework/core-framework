<{extends file="base-root.tpl"}>

<{block name="contentWrp"}>
    <div class="contentWrap">
        <img class="err404Image" src="/base/images/nuclear-bomb-404.svg" />
        <h1><{$title}> - Error Code: <{$code}> Message: <{$message}></h1>
        <div class="stackTrace">
	        <{if isset($stackTrace)}>
		        <{$stackTrace}>
	        <{/if}>
        </div>
    </div>
<{/block}>