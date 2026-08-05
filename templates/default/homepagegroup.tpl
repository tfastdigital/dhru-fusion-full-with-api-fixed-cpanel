{include file="templates/default/productlist.tpl"}


{foreach from=$homeitems key=groupsnm item=productitems name=foo}

    <div class="index-items homepagegroups mb-4 bottom-space"><div class="container"><div class="page-container">

                {if $productitems.child}
                    <ul class="nav nav-pills  flex-nowrap">
                        <div  class="nav-item nav-item-parent mr-auto">
                            <a class="nav-link active">
                                {$groupsnm}
                            </a>
                        </div>

                        {foreach from=$productitems.child key=groupsnm item=productitems name=foo2}
                            <li class="nav-item ">
                                <a class="nav-link   {if $smarty.foreach.foo2.index eq 0}active{/if}"   data-toggle="tab" href="#id{$smarty.foreach.foo.index}{$smarty.foreach.foo2.index}"> {$groupsnm}</a>
                            </li>
                        {/foreach}
                    </ul>

                    <div class="tab-content">
                        {foreach from=$productitems.child key=groupsnm item=productitems name=foo2}
                            <div class="tab-pane   {if $smarty.foreach.foo2.index eq 0}active show{/if} fade" id="id{$smarty.foreach.foo.index}{$smarty.foreach.foo2.index}" role="tabpanel">
                                <div class="row">
                                    {foreach from=$productitems.items key=GroupName item=Services}
                                        {call name=productlist data=$Services service='product'}
                                    {/foreach}
                                </div>
                            </div>
                        {/foreach}
                    </div>

                {else}

                    <h3 class="title">
                        <span>{$groupsnm}</span>
                    </h3>

                    <div class="row">
                        {foreach from=$productitems.items key=GroupName item=Services}
                            {call name=productlist data=$Services service='product'}
                        {/foreach}
                    </div>

                {/if}





            </div></div></div>

{/foreach}
