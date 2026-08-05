
<div class="row">
    {foreach from=$group key=id item=name}
        <div class="col-lg-3 col-md-6 mb-4 bottom-space">
            <div class="card  h-100 text-center card-group">
                <div class="card-body p-0">
                    <div class="p-3">
                        <a class="d-block"  href="cart.php?group={$id}&service={$smarty.get.type}&parentid=1006">
                            <span class="md-icon" style="opacity:0.4"> <i class="fal fa-cogs"></i></span>
                            <div style="font-weight: 600">  {$name}  </div>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    {/foreach}
</div>


