{block name="title" prepend}{$LNG.lm_chat}{/block}
{block name="content"}
<iframe style="width:1024px; height:724px; background-color: black;" src="./chat/index.php?action={$smarty.get.action|default:''|escape:'html'}" style="border: 0px;width:85%;height:800px;" ALLOWTRANSPARENCY="true"></iframe>
{/block}