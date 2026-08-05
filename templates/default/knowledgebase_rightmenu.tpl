 
<div class="col-lg-3"> 
    <ul class="list-group">        
    	{if $category}		           
    		{foreach from=$category key=id item=name}                
    			<li class="list-group-item"> <a  href="{$name.seo}">{$name.groupname}</a></li>
    		{/foreach}
    	{/if}
    </ul>           
</div>           