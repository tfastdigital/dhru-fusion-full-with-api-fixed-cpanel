{if $knowledgebase}
    <div class="list-group shadow-sm">
        {foreach from=$knowledgebase key=id item=det}
              <li class="list-group-item">
                  <a href="{$det.seo}">  <strong class="d-block"> {$det.title} </strong>
                    <div>{$det.content|strip_tags|truncate:200:"..."}</div>
                  </a>
              </li>
        {/foreach}
        <div class="clear"></div>
    </div>
{/if}
