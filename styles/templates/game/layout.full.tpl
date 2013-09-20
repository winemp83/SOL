{include file="main.header.tpl" bodyclass="full"}


{include file="main.navigation.tpl"}




{include file="main.topnav.tpl"}



<div id="content">{block name="content"}{/block}</div>

<!-- Planet_menu start -->
{include file="planet_menu.tpl" nocache}
<!-- Planet_menu end -->

{foreach $cronjobs as $cronjob}<img src="cronjob.php?cronjobID={$cronjob}" alt="">{/foreach}

{include file="main.footer.tpl" nocache}
