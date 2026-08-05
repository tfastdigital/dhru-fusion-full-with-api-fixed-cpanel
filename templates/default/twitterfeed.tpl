

 <div class="twitter row border-bottom pb-3" style="border-color: #ffffff29 !important">


{if $tweets}
    {foreach from=$tweets item=tweet key=num}
        {if $num < $numtweets}
          <div class="col-lg-3 text-white col-sm-6 mb-2">
            <i class="fab fa-twitter" style="font-size:20px;"></i> &nbsp;
            <small>{$tweet.date}</small>
            <div class="twit-content"> {$tweet.tweet}</div>
          </div>
        {/if}
    {/foreach}
{/if}


</div>

