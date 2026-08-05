{if $products}
    <div class="serchcontent">
     {foreach from=$products key=gid item=prodet}
     <li class="dropdown-header">{$gid}</li>
        {foreach from=$prodet key=id item=det}
              <li class="dropdown-item">
                <a href="{$det.seourl}" class="nav-link">
                   <i class="fal fa-search text-muted"></i> &nbsp;  {$det.service_name}
                </a>
              </li>
        {/foreach}
    {/foreach}
    </div>
{/if}
