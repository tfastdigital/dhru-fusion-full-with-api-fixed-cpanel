
<div class="container"><div class="page-container">
<div class="card">
  <ul class="nav nav-pills flex-nowrap">
    <li class="nav-item " onclick="getContect('#all','{$reselleremailtemplatelink}?standalone=true','#all',true,'#loader',true);" > <a class="nav-link  active" data-toggle="tab" href="#all"> {$lang.email} {$lang.template}</a> </li>
    <li class="nav-item " onclick="getContect('#pending','{$resellersmtplink}?standalone=true','#pending',true,'#loader',true);"> <a  class="nav-link "   data-toggle="tab" href="#pending"> {$lang.email} {$lang.setting} </a> </li>
  </ul>
  <div class="tab-content">
    <div class="tab-pane     fade show active" id="all" role="tabpanel" aria-labelledby="all">
      <script>
        getContect('#all','{$reselleremailtemplatelink}?standalone=true','#all',true,'#loader',true);
      </script>
    </div>
    <div class="tab-pane    fade" id="pending" role="tabpanel" aria-labelledby="pending">   </div>
  </div>
</div>
  </div></div>
