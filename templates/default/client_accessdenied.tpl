<div class="container content-fluid">

	{if $notification.success}
      <div   class="alert1 alert alert-success" >{$notification.success}</div>
    {elseif $notification.error}
      <div   class="alert1 alert alert-danger" >{$notification.error}</div>
  	{/if}

</div>
