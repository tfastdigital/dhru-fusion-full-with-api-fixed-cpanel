<div class="container"><div class="page-container">
  <div class="card">
  {if $notification.success}
  <div  class="alert alert-success" >{$notification.success}</div>
  {elseif $notification.error}
  <div  class="alert alert-danger" >{$notification.error}</div>
  {/if}

  <ul class="nav nav-pills flex-nowrap">
    <li class="nav-item " onclick='getContect("#new","{$neworder}?standalone=true","#new",true,"#loader",true);'><a class="nav-link  active" href="#new" data-toggle="tab"  id="tab2">{$lang.new} {$lang.order}</a></li>
    <li class="nav-item " onclick='getContect("#tab","{$shippedorder}?standalone=true","#shipped",true,"#loader",true);' ><a class="nav-link "  href="#shipped"  data-toggle="tab" id="tab4">{$lang.shipped} {$lang.order}</a></li>
  </ul>
  <div class="tab-content">
    <div class="tab-pane     fade show active" id="new" role="tabpanel" aria-labelledby="new">
      <script>
        getContect("#new","{$neworder}?standalone=true","#new",true,"#loader",true);
      </script>
    </div>
    <div class="tab-pane     fade" id="shipped" role="tabpanel" aria-labelledby="shipped">   </div>
  </div>
</div>

  </div></div>
