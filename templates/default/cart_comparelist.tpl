 <div class="{if $comparelist}p-3 rounded shadow-sm{/if}">
    {foreach from=$comparelist item=citem}
        <li class="dropdown-item d-flex justify-content-between w-100">
            <span>{$citem.1}</span>
            <a class="cursor-pointer px-3 float-right" onclick="addToCompare('{$citem.0}',true);" title="Remove"> &times; </a>
        </li>
    {/foreach}
    {if $comparelist}
        <div class="dropdown-divider"></div>
        <li class="dropdown-item">
            <a  class="btn btn-sm" href="viewcompare.php">{$lang.view} {$lang.compare} {$lang.item}</a>
        <li>
    {/if}
</div>
