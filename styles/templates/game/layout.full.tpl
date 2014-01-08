{include file="main.header.tpl" bodyclass="full"}


{include file="main.navigation.tpl"}






<div id="content">{block name="content"}{/block}</div>



{foreach $cronjobs as $cronjob}<iframe src="cronjob.php?cronjobID={$cronjob}" alt="">{/foreach}

{include file="main.footer.tpl" nocache}
