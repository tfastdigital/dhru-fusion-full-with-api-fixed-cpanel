
<h1 class=" h1">
		{$pagetitle}
	</h1>
<form   method="post" name="api" id="api" action="{$action_link}" >
	{if $notification}
	<div   class="alert1 {$class} alert">
		{$msg}
	</div>
	{else}
	<div   class="alert">
	</div>
	{/if}
	<div class="text-center">
		{$lang.generatedpassinfo} <br />
		<br />
		{$token}

		{if $password}
		{$lang.temporary} {$lang.password} {$password}
		{/if}
		{if $btn} {$btn} {/if}
	</div>
</form>
