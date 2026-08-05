<div class="container"><div class="page-container">
    <div class="card">
        {if $notification.success}
            <div  class="alert alert-success" >{$notification.success}</div>
        {elseif $notification.error}
            <div  class="alert alert-danger" >{$notification.error}</div>
        {/if}

        <div class="tab-content">
            <div class="tab-pane     fade show active" id="new" role="tabpanel" aria-labelledby="new">
                <script>
                    getContect("#new","{$neworder}?standalone=true","#new",true,"#loader",true);
                </script>
            </div>
            <div class="tab-pane    fade" id="shipped" role="tabpanel" aria-labelledby="shipped">   </div>
        </div>
    </div>

    </div></div>
