<section id="overview" class="container">
    <h2 class="sectionHeader"><{$documentation.sectionHeader}></h2>
    <ul class="tutorialList">
        <{foreach from=$docVarsCom.navs.Documentation key=k item=i }>
            <{if $k != 'link'}>
                <li>
                    <a href="<{$i}>"><{$k}></a>
                </li>
            <{/if}>
        <{/foreach}>
    </ul>
    <br/>

    <p class="well well-small">
        <{$documentation.note}>
    </p>
</section>