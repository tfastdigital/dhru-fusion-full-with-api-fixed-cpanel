{literal}
    <style>
        .downloadfiles {
            display: none;
            background: none repeat scroll 0 0 #F4F4F4;
            padding: 5px 10px;
            text-align: right;
            float: right;
        }

        .downloadfiles li {
            list-style: none
        }
    </style>
{/literal}

{if $standalone}{else}

<div id="tabcontent">

    {/if}
    <div>

        <form method="post" name="editprofile" id="editprofile" enctype="multipart/form-data">

            <div class="alert"></div>
            {$token}

            <div>
                <table class="table">

                    {foreach from=$items key=id item=order}
                        <tr>
                            <td>
                                <img class="card-img-top" src="{$order.image_link}">
                            </td>
                            <td  class="w-75">
                                <div class="p-3">
                                   <div>{$order.service}</div>
                                   <h5>{$order.credit-$order.discount} {$userdetails.currency.code}</h5>
                                    <div>
                                        {if $order.link}
                                            {if !$order.downloads}
                                                <a href="{$order.link}" target="_blank">{$lang.track}</a>
                                            {/if}
                                        {/if}
                                    </div>
                                    <div align="left">
                                        {if $order.user_can_c eq 0}{$lang.new}{/if}
                                        {if $order.user_can_c eq 1}{$lang.inprocess}{/if}
                                        {if $order.user_can_c eq 6}{$lang.onhold}{/if}
                                        {if $order.user_can_c eq 4}{$lang.sent}{/if}
                                        {if $order.user_can_c eq 7}{$lang.received}{/if}
                                        {if $order.user_can_c eq 3}{$lang.rejected}{/if}
                                    </div>
                                    <div>
                                        <div>
                                            {if $order.days}
                                                {if $resellerstore}
                                                    <a href="ordershopping.php?return={$order.md5}" data-toggle="tooltip"
                                                       data-original-title=" {$lang.return} {$lang.request}"><i
                                                                class="icon-circle-arrow-left"></i></a>
                                                {/if}
                                            {else}

                                            {/if}

                                            {if $order.downloads}
                                                <a onclick="javascript: $('#a_{$id}').show();" data-toggle="tooltip"
                                                   data-original-title="Click to view downloadable file"><i
                                                            class="icon-download"></i></a>
                                            {/if}
                                        </div>
                                    </div>

                                    <div>
                                        <div class="row justify-content-between">
                                            <div class="order-tracking completed">
                                                <span class="is-complete"></span>
                                                <p>Ordered<br><span>Mon, June 24</span></p>
                                            </div>
                                            <div class="order-tracking completed">
                                                <span class="is-complete"></span>
                                                <p>Shipped<br><span>Tue, June 25</span></p>
                                            </div>
                                            <div class="order-tracking">
                                                <span class="is-complete"></span>
                                                <p>Delivered<br><span>Fri, June 28</span></p>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </td>
                        </tr>
                    {/foreach}
                </table>
            </div>





            {if $resellerstore}
                <div class="mt-5">
                    <button type="button" class="btn btn-primary waves-effect waves-light" id="saveprofile"
                            onclick="javascript: location.href='{$relorder}'"
                            name="saveprofile" value="{$lang.reorder}">{$lang.reorder}</button>
                </div>
            {/if}
        </form>
    </div>
    {if $standalone}{else}
</div>
    </div>
{/if}


