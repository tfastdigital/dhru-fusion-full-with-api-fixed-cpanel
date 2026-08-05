
<div class="col-lg-3">
    <div class="card content-category">
        <ul class="list-group">
            <li class="list-group-item dropdown-header">Category</li>
            {if $category}
                {foreach from=$category key=id item=name}
                    <li  class="list-group-item"> <a  href="{$name.seo}">{$name.groupname}</a></li>
                {/foreach}
            {/if}
        </ul>
    </div>
</div>

