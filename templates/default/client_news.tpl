 {if $news}
	<div class="container"><div class="page-container">
		{foreach from=$news item=post name=foo}
            <blockquote class="blockquote">
              <a href="{if $seofriendly}blog/{$post.id}{else}blog.php?postid={$post.id}{/if}">{$post.title}</a>
              <small>
                {$post.post}
              </small>
              <footer class="blockquote-footer">{$lang.postedin} {$lang.by} {$post.author}  on  <cite title="{$post.date}">{$post.date} </cite>  {$post.category}</footer>
            </blockquote>

		{/foreach}
        </div></div>

{else}
	<div class="text-center">{$lang.noanynews}</div>
{/if}


