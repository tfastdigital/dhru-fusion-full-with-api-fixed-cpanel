{foreach from=$productorderslist key=id item=order}
    <div class="mb-4  bottom-space">
        <div class="card card-retail-order p-0">

            <div class="bg-light p-3" style="border-radius: 5px 5px 0 0 ">

                <div class="row align-items-center">

                    <div class="col-md-3 col-7 mb-4 bottom-space mb-lg-0"> <div class="card-title-text"> {$lang.order} {$lang.placed} : </div>   {$order.date},  <small>{$order.time}</small>  </div>

                    <div  class="col-md-3 col-5   mb-4 bottom-space mb-lg-0">
                        <div>
                            <div class="card-title-text">  {$lang.orderid} </div>  <h5> <a href="{$order.invocielink}"> #{$order.orderid} </a></h5>
                        </div>
                    </div>

                    <div  class="col-md-3 col-7  mb-4 bottom-space mb-lg-0"> <div class="card-title-text"> {$lang.total} </div> {$order.total} {$userdetails.currency.code} </div>

                    <div  class="col-md-3 col-5  mb-4 bottom-space mb-lg-0">
                        <div class="text-lg-right" onclick="javascript:window.location.href='{$order.invocielink}'">
                            {if $order.paymentstatus eq $lang.waitingpayment}
                                <button class="btn btn-sm btn-success">{$lang.paynow}</button>
                            {else}
                                <div class="card-title-text cursor-pointer" > {$lang.payment}   </div>
                                <label class="cursor-pointer badge badge-{if $order.paymentstatus eq $lang.paid}success{else}info{/if}">{$order.paymentstatus}</label>
                            {/if}
                        </div>
                    </div>

                </div>

            </div>

            <div class="p-3">

                {foreach from=$order.items key=id item=item}
                    <div class="retail-item">
                        <div class="row">
                            <div class="col-auto col-img mb-4 bottom-space">
                                <div class="mw-100">
                                    <img src="{$item.image}" class="mxw-100">
                                </div>
                            </div>
                            <div class="col col-detail position-static">

                                <div class="">

                                    <h5>
                                        <a href="{$item.productlink}">
                                            {$item.item}
                                        </a>
                                    </h5>

                                    <div class="row">
                                        <div class="col mb-4 bottom-space position-static">

                                            <div>
                                                <div>
                                                    {$lang.qnt} : {$item.qnt}
                                                </div>
                                                {if $item.weight}
                                                    <div>
                                                        {$lang.weight} : {$item.weight}
                                                    </div>
                                                {/if}
                                                {if $item.sku}
                                                    <div>
                                                        sku : {$item.sku}
                                                    </div>
                                                {/if}
                                                {if $item.custom}
                                                    <div>
                                                        {$item.custom}
                                                    </div>
                                                {/if}

                                                {if $order.paymentstatus eq $lang.waitingpayment}
                                                   <div><label class="badge badge-danger">{$order.paymentstatus}</label></div>
                                                {/if}

                                                {if $item.fullfilmentstatus eq 0 &&  $order.paymentstatus neq $lang.waitingpayment}
                                                    <div><label class="badge badge-danger">{$lang.rejected}</label></div>
                                                {/if}

                                            </div>

                                            {if $item.fullfilmentstatus neq 0}
                                                {if $order.paymentstatus eq $lang.paid}

                                                        <div class="track-order">
                                                            <div class="row mw-360">

                                                                <div class="order-tracking {if $item.fullfilmentstatus gte 1} completed {/if}">
                                                                    <span class="is-complete"></span>
                                                                    <p>{$lang.confirmed} </p>
                                                                </div>
                                                                <div class="order-tracking  {if $item.fullfilmentstatus gte 2} completed {/if}">
                                                                    <span class="is-complete"></span>
                                                                    <p>{$lang.packed} </p>
                                                                </div>
                                                                <div class="order-tracking  {if $item.fullfilmentstatus gte 3} completed {/if}">
                                                                    <span class="is-complete"></span>
                                                                    <p>{$lang.dispatched} </p>
                                                                </div>
                                                                <div class="order-tracking  {if $item.fullfilmentstatus gte 4} completed {/if}">
                                                                    <span class="is-complete"></span>
                                                                    <p>{$lang.delivered} </p>
                                                                </div>

                                                            </div>
                                                        </div>
                                                {/if}
                                            {/if}

                                        </div>
                                        <div class="col-lg-auto mb-4 bottom-space col-12">

                                            {if $order.paymentstatus eq $lang.paid}
                                                <div>
                                                    {if $item.shipping}
                                                        <div class="mb-2">
                                                            {$lang.shipping} : {$item.shipping}
                                                        </div>
                                                    {/if}

                                                    {if $item.trackinglink}
                                                        <div>
                                                            <a  href="{$item.trackinglink}" class="btn btn-secondary btn-sm text-white px-3 py-1" target="_blank">{$lang.trackorder} </a>
                                                        </div>
                                                    {/if}
                                                </div>
                                            {/if}
                                        </div>

                                    </div>



                                </div>
                            </div>
                        </div>
                    </div>
                {/foreach}

            </div>

        </div>
    </div>
    {foreachelse}
    <div class="card">
        <div class="text-center p-5">{$lang.norecordsfound}</div>
    </div>
{/foreach}
