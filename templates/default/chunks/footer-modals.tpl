{if !$loggedin}
    <div class="modal    hide p-0" id="login"  tabindex='-1'>
        <div class="modal-dialog modal-dialog-centered  modal-md m-auto mw-400">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">{$lang.login} {$lang.toyouraccount} </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">  <span class="d-none d-md-block">&times;</span><span class="d-block d-md-none"><i class="fal fa-times"></i></span> </button>
                </div>
                <div class="modal-body modal-body-login">
                    {include file="templates/default/login.tpl"}
                </div>
            </div>
        </div>
    </div>
{/if}


{if $loggedin}
    {assign var=theme value=$userdetails.themesettings|json_decode:1}
    <form id="clientsettings">
        <input type="hidden"   id="orderstyle" value="{$theme.orderstyle}" />
        <input type="hidden"  id="mode" value="{$theme.mode}" />
        <input type="hidden"  id="column" value="{$theme.column}" />
        <input type="hidden" name="themesettings" id="themesettings" value="" />
    </form>
{/if}


<div id="modal-search" class="modal hide"  tabindex='-1'>
    <div class="modal-dialog modal-dialog-centered    modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" style="width: 90%">{$lang.search} {$lang.result}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><span>&times;</span></button>
            </div>
            <div class="modal-body" >
                <table class="table table-striped">
                    <thead>
                    <tr>
                        <th>{$lang.id}</th>
                        <th>{$lang.credit}</th>
                        <th>{$lang.date}</th>
                        <th>{$lang.status}</th>
                        <th> </th>
                    </tr>
                    </thead>
                    <tbody id="searchresult-imei">

                    </tbody>
                    <tbody id="searchresult-file">

                    </tbody>
                    <tbody id="searchresult-server">

                    </tbody>
                </table>
            </div>

        </div>
    </div>
</div>

<div id="modal-ajax" class="modal hide     modal-ajax"  tabindex='-1'>
    <div class="modal-dialog modal-dialog-centered  mx-auto" id="modal-size">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" style="width: 90%">Edit</h5>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><span>&times;</span></button>
            </div>
            <div class="modal-body" > <div class="ajax-responsive loading"></div> </div>

        </div>
    </div>
</div>


{if $resellerstore}
    {if $currentpage|in_array:['main','index']}
        {if $popupcontent && !$ismobile}
            <div class="modal    hide fade" id="advertisement"  tabindex='-1' data-backdrop="static" data-keyboard="false" style="z-index: 999999999">
                <div class="backdrop-over"></div>
                <div class="modal-dialog modal-dialog-centered" style="max-width: 650px">
                    <div class="modal-content " style="overflow: hidden">
                        <span class="cursor-pointer position-absolute" style="right: 20px;top:20px;z-index: 999" data-dismiss="modal" aria-label="Close"> {$lang.close} </span>

                        <div class="modal-body p-0 d-flex justify-content-between align-items-center text-center position-relative" style="min-height: 600px">
                            <div class="p-5 w-100">
                                {$popupcontent}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <script>
                $(document).ready(function () {
                    setTimeout(function () {
                        $('#advertisement').modal('show');
                    },5000)
                })
            </script>
        {/if}
    {/if}
{/if}

{if $cart}
    <script>
        $(document).ready(function () {
            viewminicart('#cartminiview');
        })
    </script>
{/if}


{$structured_data}
