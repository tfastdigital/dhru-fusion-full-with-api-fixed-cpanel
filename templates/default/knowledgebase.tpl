
<div class="container"><div class="page-container">

	<div class="card">

		{if !$smarty.get.standalone}
			<div>
				<form action="knowledgebase" method="post" class="position-relative mb-4 bottom-space">
					<input type="text" class="form-control" name="search" onkeyup="getKnowledgebaseSearch('{$searchurl}',this.value,'true');"  placeholder="Search the knowledgebase..."  >
					<div id="searchKnowledgebase" class="position-absolute bg-white" style="z-index: 99"></div>
				</form>
			</div>
		{/if}

		<div>

			<div    class="alert">	</div>

			{if $allpages}


				<div class="row">

					{*<div class="col-lg-3 mt-3">
                        <ul class="list-group">
                            {if $category}
                                <div class="ml-2 mb-2 text-muted" style="font-weight: 600">  {$lang.category} </div>
                                {foreach from=$category key=id item=name}
                                    <li class="list-group-item bg-transparent"> <a href="{$name.seo}">{$name.groupname}</a></li>
                                {/foreach}
                            {/if}
                        </ul>
                    </div>*}

					<div class="col-lg-12">
						{foreach from=$allpages item=t}

							<div class="alter">
								<div class=" py-3">
									<div class="p-0">

										<div class="d-flex w-100">
											<div class="pr-3 sm-icon">
												<i class="fal fa-folder"></i>
											</div>
											<div class="w-100">
												<h5 style="font-weight: 600">
													{$t.groupname} ({$t.artical})
												</h5>
												<p class="card-text">
													<span>{$t.info|truncate:200:"..."}</span>
												</p>
												<ul class="list-group">
													{foreach from=$t.articald item=d}
														<li class="list-group-item">
															<a class="card-link d-block" href="{$d.seo}">
																<i class="fal fa-angle-right"></i> &nbsp; {$d.title}
															</a>
														</li>
													{/foreach}

													<li class="list-group-item">
														<a class="card-link d-block"   href="{$t.seo}">
															<span> {$lang.viewmore}... </span>
														</a>
													</li>

												</ul>
											</div>
										</div>

									</div>


								</div>
							</div>
						{/foreach}
					</div>
				</div>

			{/if}
			{if $artical}



				<h3 class="mb-4 bottom-space">{$pagetitle}</h3>

				{assign var='i' value='0'}
				<ul class="list-group">
					{foreach from=$artical item=t}

						{if $fullartical}
							<p>
								{$t.content}
							</p>
							<div class="d-flex">
								<div class="m-2">
									<i class="fa fa-eye"></i>	{$views} : {$t.viewer}
								</div>
								<div class="m-2">
									{if $facebooklike}
										<iframe src="http://www.facebook.com/plugins/like.php?href={$siteurl}/blog?postid={$post.id}&amp;layout=button_count&amp;show_faces=true&amp;width=450&amp;action=like&amp;colorscheme=light" scrolling="no" frameborder="0" allowTransparency="true" style="border:none; overflow:hidden; width:80px; height:20px"></iframe>
									{/if}
								</div>
								<div class="m-2">
									{if $googlelike}
									{literal}
										<a href="https://plusone.google.com/_/+1/confirm?hl=en-US&url={/literal}{$site_address}{literal}" >
										<img src="images/google+.png" alt="Google+" title="Google+"/>
										</a>
									{/literal}
									{/if}
								</div>
							</div>
						{else}

							<li class="list-group-item">

								<a class="d-block" href="{$t.seo}">
									<span>{$t.title} </span>
								</a>
							</li>

						{/if}

					{/foreach}
				</ul>

			{/if}
			{if $noartical}
				<div class="text-center p-5">
					{$noartical}
				</div>
			{/if}
		</div>

	</div>

	</div></div>
