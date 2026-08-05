 {literal}
     <script>
        function addMoreFiles()
        {
            $("#suppf").append('<input type="file" name="files[]" /><br/> ');
        }
    </script>
 {/literal}

<div class="container"><div class="page-container">

    <div class="card">
  <form  method="post" name="login_form" id="login_form" enctype="multipart/form-data" >
    <input type="hidden" name="id" value="{$tid}" />
    {$token}

   <div class="row border-bottom pb-3 mb-4 bottom-space">
        <div class="col-lg-6">
            {$lang.subject} : {$subject} <br />
            {$lang.status} : {$status}
        </div>
        <div class="col-lg-6 text-right">
            {$lang.date} : {$date} <br />
            {$lang.priority} : {$priority}
        </div>
   </div>


      {foreach from=$tickets key=id item=t}
          <div class="">
              <div class="col-lg-7 p-0 mb-2 {if $t.aid} float-right {else} float-left {/if}">
                    <div class="p-3  rounded {if $t.aid} bg-dark text-white{else} bg-light {/if}">
                    <div class="">
                        <p style="font-size:16px">{$t.message}</p>
                        {*{if $t.files}
                            <small><i class="icon-download"></i> {$lang.attachment}</small>
                            {foreach from=$t.files key=i item=s}
                                <a href="download.php?action=support&id={$t.id}&file={$i}">{$i}</a>
                            {/foreach}
                        {/if}*}
                    </div>
                    </div>
                    <div class="p-1 text-muted {if $t.aid} text-right {else} text-left {/if}"><small> {$t.reply} reply on {$t.date}</small></div>
              </div>
              <div class="clear"></div>
          </div>
      {/foreach}
  </form>
    {if $close}
    {else}


        <form method="post" enctype="multipart/form-data">
            <input type="hidden" name="id" value="{$tid}" />
            {$token}
            <div  class="col-lg-7 p-0">
                <textarea name="message" class="form-control mb-2 mt-2" rows="5" placeholder="{$lang.reply}"></textarea>
                <button type="submit" name="reply" class="btn btn-primary waves-effect waves-light" value="{$lang.update} {$lang.ticket}">{$lang.update} {$lang.ticket}</button>
                <button type="submit" name="close" class="btn btn-light" value="{$lang.ifresolvedclose}">{$lang.ifresolvedclose}</button>
            </div>
        </form>


    {/if}

    </div>
    </div></div>
