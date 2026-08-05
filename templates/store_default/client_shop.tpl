<div class="container"><div class="page-container">


    <div class="ml-auto mw-360 mb-4  bottom-space">
        <form method="post">
            <div class="input-group mb-4 bottom-space">
                <input type="text" name="search" class="form-control" value="{$search}" placeholder="Search Order..." >
                <div class="input-group-append">
                    <button type="submit" class="btn btn-secondary" type="button">Search</button>
                </div>
            </div>
        </form>
    </div>

        {if $notification.success}
            <div  class="alert alert-success" >{$notification.success}</div>
        {elseif $notification.error}
            <div  class="alert alert-danger" >{$notification.error}</div>
        {/if}



    <div id="load-orders">

    </div>

    <div id="loader-loadmore">

    </div>

    {literal}
        <script>
            let startfrom = 0;
            loadMore('{/literal}{$retailorderlink}/?search={$search}&id={$id}{literal}','#load-orders','#loader-loadmore',startfrom,{/literal}{$totalrows}{literal});

            $(window).scroll(function() {
                if($(window).scrollTop() == $(document).height() - $(window).height()) {
                    startfrom = startfrom + 10;
                    loadMore('{/literal}{$retailorderlink}/?search={$search}&id={$id}{literal}','#load-orders','#loader-loadmore',startfrom,{/literal}{$totalrows}{literal});
                }
            });

        </script>
    {/literal}

    </div></div>
