
<div class="container"><div class="page-container">

  <div class="card">

  <div class="table-responsive">
    <table class="table table-striped">
      <thead>
        <tr>
          <th> {$lang.subject} </th>
          <th class="text-center">{$lang.date}</th>
          <th class="text-right w-100">{$lang.action}</th>

        </tr>
      </thead>
      <tbody>

      {foreach from=$maillist key=id item=mail}
      <tr class="href" data-toggle="modal" data-target="#modal-ajax"  data-whatever="{$lang.mymail}" href="{$mail.seo}">
        <td class="no-wrap"> {$mail.subject} </td>
        <td  class="text-center no-wrap"> {$mail.date} </td>
        <td class="text-right"><a > <i class="fal fa-edit"></i> </a></td>

      </tr>
      {foreachelse}
      <tr>
        <td colspan="3" class="text-center"> {$lang.norecordsfound} </td>
      </tr>
      {/foreach}
        </tbody>

    </table>

  </div>

  <nav aria-label="Page navigation example" class="pagging">
    <div  class="pagination text-center"> {$paginate} </div>
  </nav>

  </div>

  </div></div>
