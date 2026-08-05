{literal}
<script type="text/javascript" src="includes/js/ajaxfileupload.js"></script>
<script type="text/javascript">
	function ajaxFileUpload()
	{
		$("#loader")
		.ajaxStart(function(){
			$(this).show();
		})
		.ajaxComplete(function(){
			$(this).hide();
		});

		$.ajaxFileUpload
		(
			{
				url:'includes/getdata/reseller.banner',
				secureuri:false,
				fileElementId:'fileToUpload',
				dataType: 'json',
				data:{name:'logan', id:'id'},
				success: function (data, status)
				{
					if(typeof(data.error) != 'undefined')
					{
					    $('.alert1').removeClass('successbox');
                         $('.alert1').removeClass('errorbox');
						if(data.error != '')
						{

                             $('.alert1').addClass('errorbox');
                             $('.alert1').html(data.error);
						}else
						{

                             $('.alert1').addClass('successbox');
                             $('.alert1').html(data.msg);
						}
					}
				},
				error: function (data, status, e)
				{
					alert(e);
				}
			}
		)
		return false;
	}

    </script>
{/literal}
<div id="modal2" class="modal hide fade" >
  <div class="modal-dialog modal-dialog-centered modal-lg">
  <form method="post" id="frm" enctype="multipart/form-data">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">{$lang.addcustomepage}</h5>
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><span>&times;</span></button>
      </div>
      <div class="modal-body" >

          <input type="hidden" name="addpage" value="1" />
          <div class="form-group ">
            <label> {$lang.page}</label>
            <input type="text" class="form-control "  name="urlname" />
          </div>
          <div class="form-group ">
            <label> {$lang.title}</label>
            <input type="text" class="form-control "  name="title" />
          </div>
          <div class="form-group ">
            <label> {$lang.metakeyword}</label>
            <input type="text" class="form-control " name="meta_keys" />
          </div>
          <div class="form-group ">
            <textarea class="form-control " name="body"></textarea>
          </div>
          <div class="form-group ">
            <div  class="form-check">
              <input type="checkbox" class="form-check-input" name="fullwidth" value="1" id="fullwidth1" />
              <label for="fullwidth1"  class="form-check-label"> {$lang.showfullwidth}</label>
            </div>
            <div  class="form-check">
              <input type="checkbox" class="form-check-input" name="login_req" value="1" id="login_req1" />
              <label for="login_req1"  class="form-check-label"> {$lang.loginrequired}</label>
            </div>
            <div  class="form-check">
              <input type="checkbox" class="form-check-input" name="navigation" value="1" id="navigation1" />
              <label for="navigation1"  class="form-check-label"> {$lang.shownavigation}</label>
            </div>
            <div  class="form-check">
              <input type="checkbox" class="form-check-input" name="publish" value="1" id="publish1" />
              <label for="publish1"  class="form-check-label"> {$lang.publish}</label>
            </div>
          </div>

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="submit" name="save" class="btn btn-primary" value="{$lang.save}" >{$lang.save}</button>
      </div>
    </div>
    </form>
  </div>
</div>
<div id="modal" class="modal hide fade">
  <div class="modal-dialog modal-dialog-centered modal-lg">
  <form method="post"  id="frm2" enctype="multipart/form-data">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">{$lang.addbanner}</h5>
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><span>&times;</span></button>
      </div>
      <div class="modal-body">

          <input type="hidden" name="addbanner" value="1" />
          <div class="form-group ">
            <label> {$lang.banner} {$lang.image}</label>
            <input type="file" class="form-control -file" name="bannerimage" />
          </div>
          <div class="form-group ">
            <label> {$lang.title}</label>
            <input type="text" class="form-control " name="title" />
          </div>
          <div class="form-group ">
            <label> {$lang.header}</label>
            <input  class="form-control "  type="text" name="header" />
          </div>
          <div class="form-group ">
            <label> {$lang.information}</label>
            <input type="text"  class="form-control "  name="information" />
          </div>
          <div class="form-row ">
            <div class="form-group  col-lg-4">
              <label> {$lang.information} {$lang.box} {$lang.width} </label>
              <div class="input-group">
                <input type="text"  class="form-control "  name="boxwidth"   />
                <div class="input-group-append"><span class="input-group-text">px</span></div>
              </div>
            </div>
            <div class="form-group   col-lg-4">
              <label> {$lang.information} {$lang.box} {$lang.from} {$lang.top} </label>
              <div class="input-group">
                <input type="text"  class="form-control "  name="boxtop"   />
                <div class="input-group-append"><span class="input-group-text">px</span></div>
              </div>
            </div>
            <div class="form-group   col-lg-4">
              <label> {$lang.information} {$lang.box} {$lang.from} {$lang.left} </label>
              <div class="input-group">
                <input type="text"  class="form-control "  name="boxleft"   />
                <div class="input-group-append"><span class="input-group-text">px</span></div>
              </div>
            </div>
          </div>

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="submit" name="save" class="btn btn-primary" value="{$lang.save}" >{$lang.save}</button>
      </div>
    </div>
    </form>
  </div>
</div>
<div class="container"><div class="page-container">

<div class="card">

  <ul class="nav nav-pills flex-nowrap">
    <li class="nav-item "><a class="nav-link  active" data-toggle="tab" href="#tab1">{$lang.index} {$lang.content}</a></li>
    <li class="nav-item "><a class="nav-link " data-toggle="tab" href="#tab2">{$lang.index} {$lang.banner}s</a></li>
    <li class="nav-item "><a class="nav-link " data-toggle="tab" href="#tab3">{$lang.custom} {$lang.pages}</a></li>
  </ul>
  <div class="tab-content mt-3">


	{if $notification.success}
  <div  class="alert1 alert alert-success">{$notification.success}</div>
  {elseif $notification.error}
  <div   class="alert1  alert alert-danger" >{$notification.error}</div>
  {elseif $notification.info}
  <div   class="alert1 alert alert-info">{$notification.info}</div>
  {else}
  <div   class="alert"></div>
  {/if}

    <div class="tab-pane active show fade" id="tab1">
      <form  method="post" name="store" id="store">
        <div    class="alert"></div>
        {$token}
        <div class="form-group "> {$index} </div>
        <button type="submit" class="btn btn-primary"  id="save" name="save" value="{$lang.save}" >{$lang.save}</button>
      </form>
    </div>
    <div class="tab-pane fade" id="tab2">
      <div class="text-right pt-2 pb-2">
        <input data-toggle="modal" data-target="#modal"  type="button" class="btn btn-secondary" name="addbanner" value="Add Banner" />
      </div>
      <div class="table-responsive">
        <table class="table  table-striped">
          <thead>
            <tr>
              <th>{$lang.image}</th>
              <th class="text-center">{$lang.action}</th>

            </tr>
          </thead>
          <tbody>

          {foreach from=$mybanner key=id item=banner}

          <tr id="row-{$banner.id}">
            <td><img src="{$banner.img}" border="0" style="max-width: 300px" /></td>
            <td class="text-center">
              <form id="frmsbn{$banner.id}">
                <a   id="btn{$banner.id}" onclick="removebanner('{$banner.deletelink}','{$banner.id}')"  title="Remove" class="text-danger mr-3">
                  <i class="fal fa-trash"></i>
                </a>
                <a data-toggle="modal" class="text-info" data-target="#modal-ajax" data-whatever="Edit Banner" href="{$banner.editlink}" title="Edit">
                  <i class="fal fa-edit"></i>
                </a>
              </form>
            </td>

          </tr>
          {foreachelse}
            <tr>
              <td colspan=" " class="text-center">{$lang.norecordsfound}</td>
            </tr>
          {/foreach}
          </tbody>

        </table>
      </div>
    </div>
    <div class="tab-pane fade" id="tab3">
      <div class="text-right pt-2 pb-2">
        <input  type="button" class="btn btn-secondary"  id="save" data-toggle="modal" data-target="#modal2" name="save" value="{$lang.add} {$lang.page}" />
      </div>
      <div class="table-responsive">
        <table class="table   table-striped">
          <thead>
            <tr>
              <th>{$lang.name}</th>
              <th>{$lang.status}</th>
              <th>{$lang.page} {$lang.link}</th>
              <th class="text-center">{$lang.action}</th>
            </tr>
          </thead>
          <tbody>

          {foreach from=$mypages key=id item=page}
          <tr id="rowpage-{$page.id}">
            <td>{$page.urlname}</td>
            <td>{$page.status} &nbsp;</td>
            <td>{$page.link}</td>
            <td class="text-center">
              <a  id="btnpage{$page.id}" onclick="removepage('{$page.deletelink}','{$page.id}')" class="text-danger mr-3"  title="Remove">
                <i class="fal fa-trash"></i>
              </a>
              <a data-toggle="modal" data-target="#modal-ajax"   data-whatever="Edit {$page.urlname}" href="{$page.editlink}" class="text-info" title="Edit">
                <i class="fal fa-edit"></i>
              </a>
            </td>
          </tr>
          {foreachelse}
          <tr>
            <td colspan="4" class="text-center">{$lang.norecordsfound}</td>
          </tr>
          {/foreach}
            </tbody>

        </table>
      </div>
    </div>
  </div>

</div>

  </div></div>

{literal}
  <script>
    function removebanner(url,id) {
      if(confirm('Are you sure want to remove Banner ?'))
      {
        SubmitForm('#btn'+id,url,'#frmsbn'+id,'.alert',true,'#loader','','',function (data) {
          if(data === 'success'){
            $('#row-'+id).hide();
          }
        });
      }
    }

    function removepage(url,id) {
      if(confirm('Are you sure want to remove Page ?'))
      {
        SubmitForm('#btnpage'+id,url,'#frmpage'+id,'.alert',true,'#loader','','',function (data) {
          if(data === 'success'){
            $('#rowpage-'+id).hide();
          }
        });
      }
    }

  </script>
  {/literal}
