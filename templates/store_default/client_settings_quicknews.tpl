{if $standalone}

    {if $smarty.get.carousel eq '1'}

        <div id="carouselExampleControls" class="carousel slide h-100 p-md-2 p-lg-4" style="padding-top: 0 !important;" data-ride="carousel">

            <ul class="carousel-indicators" style="bottom: 0">
                {foreach from=$news key=id item=inv name=foo}
                    <li data-target="#carouselExampleControls" data-slide-to="{$smarty.foreach.foo.index}" class="{if $news@first}active{/if}"></li>
                {/foreach}
            </ul>

            <div class="carousel-inner">

                {foreach from=$news key=id item=inv}

                    <div class="carousel-item {if $inv@first}active{/if}">
                        <div>
                            <div>
                                <i class="fal fa-bullhorn"></i>  {$inv.date}
                            </div>
                            <div class="mt-3">
                                <h5> {$inv.news} </h5>
                            </div>
                        </div>
                    </div>

                    {foreachelse}

                    <div class="text-center p-3 text-muted">
                        {$lang.noanyannouncement}
                    </div>

                {/foreach}

            </div>


            <a class="carousel-control-prev   w-auto" style="left: 0;color:#717070;align-items: flex-end;" href="#carouselExampleControls" role="button" data-slide="prev">
                <i class="fal fa-chevron-left"></i>
            </a>
            <a class="carousel-control-next   w-auto" style="right: 0;color:#717070;align-items: flex-end;" href="#carouselExampleControls" role="button" data-slide="next">
                <i class="fal fa-chevron-right"></i>
            </a>

        </div>

        {elseif $smarty.get.carousellist eq '1'}

            {foreach from=$news key=id item=inv}

                <div class="news-list">
                    <div class="news-text"> {$inv.news} </div>
                    <div class="news-date"> {$inv.date}</div>
                </div>

                {foreachelse}

                <div class="text-center p-3 text-muted">
                    {$lang.noanyannouncement}
                </div>

            {/foreach}

        {else}




        <table class="table border-0 table-striped table-hover">

            <thead>
            <tr>
                <th>{$lang.date}</th>
                <th> {$lang.news}</th>
                <th class="text-center">  </th>
            </tr>
            </thead>

            {foreach from=$news key=id item=inv}
                <tr class="news{$id} announce" id="news_row_{$id}">
                    <td class="no-wrap"> {$inv.date} </td>
                    <td>
                        <div class="d-flex justify-content-between">
                            <div>
                                {$inv.news}
                            </div>
                        </div>
                    </td>
                    <td class="text-center">
                        {*<form  id="frm_news{$id}">
                            <input type="hidden" value="{$id}" name="qid">
                            <a  class="cursor-pointer"  id="hidenews{$id}"  title="Click to hide this news"
                                onclick="SubmitFormJSON('#hidenews{$id}','{$hideannouce}','#frm_news{$id}','','true','#loader');" > <i class="fal fa-trash"></i> </a>
                        </form>*}
                    </td>
                </tr>
                {foreachelse}
                <div class="text-center p-3 text-muted">
                    {$lang.noanyannouncement}
                </div>
            {/foreach}

            {if $globalmsg}
                <tr>
                    <td>{$globalmsg} </td>
                </tr>
            {/if}

        </table>

    {/if}



{/if}
