<section id="overview" class="container">
    <h1 class="sectionHeader"><{$contribute.mainHeading}></h1>

    <p class="intro">
        <{$contribute.introPara}>
    </p>

    <h3 class="subTitle">
        <{if isset($contribute.subTitle1) }>
            <{$contribute.subTitle1}>
            <a class="permalink" href="#<{$contribute.subTitle1_pLink}>">&para;</a>
        <{/if}>
    </h3>
    <div class="block">
        <{$contribute.subPara1}>
    </div>
</section>