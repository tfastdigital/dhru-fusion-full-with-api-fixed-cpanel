<!--
////////////////////////////////////////////////
// Last modified: 11.09.2010 14:14
////////////////////////////////////////////////

    function isCookieAllowed(){
       setCookie('cookie_allowed',1,10);
       if(readCookie('cookie_allowed') != 1) {alert(DGVocabulary._MSG["cookies_required"]); return false; };
       return true;
    }

function setCookie(name, value, days) {
   if (days) {
      var date = new Date();
      date.setTime(date.getTime()+(days*24*60*60*1000));
      var expires = '; expires='+date.toGMTString();
   }
   else var expires = '';
   document.cookie = name+'='+value+expires+'; path=/';
}

function readCookie(name) {
   var nameEQ = name + '=';
   var ca = document.cookie.split(';');
   for(var i=0;i < ca.length;i++) {
      var c = ca[i];
      while (c.charAt(0)==' ') c = c.substring(1,c.length);
      if (c.indexOf(nameEQ) == 0) return c.substring(nameEQ.length,c.length);
   }
   return null;
}

// load new event 
function addDgLoadEvent(func) {
   var oldonload = window.onload;
   if (typeof window.onload != 'function') {
      window.onload = func;
   }else {
      window.onload = function() {
         oldonload();
         func();
      }
   }
}

// hide/unhide Filtering
function hideUnHideFiltering(type, unique_prefix){
   if(!isCookieAllowed()) return false;
   unique_prefix = (unique_prefix == null) ? '' : unique_prefix;
   if(type == 'hide'){
      document.getElementById('searchset_div').style.display = 'none';
      document.getElementById(unique_prefix+'searchset').style.display = 'none';
      document.getElementById(unique_prefix+'a_hide').style.display = 'none';
      document.getElementById(unique_prefix+'a_unhide').style.display = '';
      setCookie(unique_prefix+'hide_search',1,1);
   }else{
      document.getElementById('searchset_div').style.display = '';
      document.getElementById(unique_prefix+'searchset').style.display = '';
      document.getElementById(unique_prefix+'a_hide').style.display = '';
      document.getElementById(unique_prefix+'a_unhide').style.display = 'none';
      setCookie(unique_prefix+'hide_search',0,1);
   }
   return true;
}

// reload form with some action, saving entered data
function formAction(file_act, file_id, unique_prefix, http_url, query_string){
   unique_prefix = (unique_prefix==null) ? "" : unique_prefix;
   http_url = (http_url==null) ? "" : http_url;
   query_string = (query_string==null) ? "" : query_string;
   //alert(http_url+"?"+query_string+"&"+unique_prefix+"file_act="+file_act+"&"+unique_prefix+"file_id="+file_id);	   

   document.getElementById(unique_prefix+'frmEditRow').action=http_url+"?"+query_string+"&"+unique_prefix+"file_act="+file_act+"&"+unique_prefix+"file_id="+file_id;
   document.getElementById(unique_prefix+'frmEditRow').encoding='multipart/form-data';
   document.getElementById(unique_prefix+'frmEditRow').method='POST';
   document.getElementById(unique_prefix+'frmEditRow').submit();
}

// calendar script (popup)
function openCalendar(directory, params, form, req_type, field, type) {
   if (type != 'time') height = '240'; else height = '100';
   window.open(directory+'modules/calendar/calendar.php?' + params, 'calendar', 'width=220, height='+height+',status=yes');
   if (req_type.length > 0){
      dateField = eval('document.' + form + '.' + req_type);
   }else{
      dateField = eval('document.' + form + '.' + field);
   }
   dateType = type;
}

// refill days according ion selected month
function refillDaysInMonth(date_field, year, month)
{
   var dayDDL = (document.getElementById(date_field+'__nc_day') != null) ? document.getElementById(date_field+'__nc_day') : false;
   var days_in_month = 32 - new Date(year, month-1, 32).getDate();
   //alert(days_in_month);
   if(dayDDL && month != ""){
      for(i = 1; i <= 31; i++){
         if(i > days_in_month) dayDDL.options[i].disabled = true;
         else dayDDL.options[i].disabled = false;
      }
      if(dayDDL.options[dayDDL.selectedIndex].disabled){
         dayDDL.selectedIndex = days_in_month;
      }
   }else if(month == ""){
      for(i = 1; i <= 31; i++){
         dayDDL.options[i].disabled = false;
      }
   }
}

// set calendar datetime for ddl's
function setCalendarDate(frm, date_field, datetime_format, date_value, year_start, is_default)
{
   year    = (document.getElementById(date_field+'__nc_year')   != null) ? document.getElementById(date_field+'__nc_year').value : '0000';
   month   = (document.getElementById(date_field+'__nc_month')  != null) ? document.getElementById(date_field+'__nc_month').value : '00';
   day     = (document.getElementById(date_field+'__nc_day')    != null) ? document.getElementById(date_field+'__nc_day').value : '00';
   hour    = (document.getElementById(date_field+'__nc_hour')   != null) ? document.getElementById(date_field+'__nc_hour').value : '00';
   minute  = (document.getElementById(date_field+'__nc_minute') != null) ? document.getElementById(date_field+'__nc_minute').value : '00';
   second  = (document.getElementById(date_field+'__nc_second') != null) ? document.getElementById(date_field+'__nc_second').value : '00';
   date_value = (date_value != null) ? date_value : '';
   year_start = (year_start != null) ? year_start : '0';
   is_default = (is_default != null) ? is_default : true;

   if(date_value != ''){
      // Set date if datetime link was clicked / or by default
      if(datetime_format.match('d-m-Y') && is_default){
         // nothing
      }else{
         document.getElementById(date_field).value = date_value;
      }
      year    = date_value.substring(0,4);
      month   = date_value.substring(5,7);
      day     = date_value.substring(8,10);
      hour     = date_value.substring(11,13);
      minute   = date_value.substring(14,16);
      second   = date_value.substring(17,19);

      if(datetime_format.match('d-m-Y') && !is_default){
         day    = date_value.substring(0,2);
         month  = date_value.substring(3,5);
         year   = date_value.substring(6,10);
         ///alert("d-m-Y");
      }else if(datetime_format.match('m-d-Y') && !is_default){
         day    = date_value.substring(3,5);
         month  = date_value.substring(0,2);
         year   = date_value.substring(6,10);
         ///alert("m-d-Y "+ date_value);
      }

      if((datetime_format == 'Y-m-d') || (datetime_format == 'd-m-Y')){
         document.getElementById(date_field+'__nc_year').selectedIndex = year-year_start+1;
         document.getElementById(date_field+'__nc_month').selectedIndex = month;
         document.getElementById(date_field+'__nc_day').selectedIndex = day;
         ///alert("b");
      }else if((datetime_format == 'Y-m-d H:i:s') || (datetime_format == 'd-m-Y H:i:s') || (datetime_format == 'd-m-Y H:i') || (datetime_format == 'Y-m-d H:i')){
         document.getElementById(date_field+'__nc_year').selectedIndex = parseInt(year - year_start) + parseInt('1');
         document.getElementById(date_field+'__nc_month').selectedIndex = month;
         document.getElementById(date_field+'__nc_day').selectedIndex = day;
         document.getElementById(date_field+'__nc_hour').selectedIndex = parseInt(hour) + parseInt('1');
         document.getElementById(date_field+'__nc_minute').selectedIndex = parseInt(minute) + parseInt('1');
         if(datetime_format != 'd-m-Y H:i' && datetime_format != 'Y-m-d H:i') document.getElementById(date_field+'__nc_second').selectedIndex = parseInt(second) + parseInt('1');
         ///alert("c");
      }else if(datetime_format == 'm-d-Y'){
         ///alert("m-d-Y "+ month+' '+day+' '+year);
         document.getElementById(date_field+'__nc_year').selectedIndex = parseInt(year - year_start) + parseInt('1');
         document.getElementById(date_field+'__nc_month').selectedIndex = month;
         document.getElementById(date_field+'__nc_day').selectedIndex = day;
      }else{
         document.getElementById(date_field+'__nc_year').selectedIndex = parseInt(year - year_start) + parseInt('1');
         document.getElementById(date_field+'__nc_month').selectedIndex = month;
         document.getElementById(date_field+'__nc_day').selectedIndex = day;
         ///alert("e");
      }
   }else{
      // Set date if ddl was changed                    
      if(datetime_format == 'Y-m-d'){
         document.getElementById(date_field).value = year+'-'+month+'-'+day;
      }else if(datetime_format == 'd-m-Y'){
         document.getElementById(date_field).value = day+'-'+month+'-'+year;
      }else if(datetime_format == 'Y-m-d H:i:s'){
         document.getElementById(date_field).value = year+'-'+month+'-'+day+' '+hour+':'+minute+':'+second;
      }else if(datetime_format == 'Y-m-d H:i'){
         document.getElementById(date_field).value = year+'-'+month+'-'+day+' '+hour+':'+minute;
      }else if(datetime_format == 'd-m-Y H:i:s'){
         document.getElementById(date_field).value = day+'-'+month+'-'+year+' '+hour+':'+minute+':'+second;
      }else if(datetime_format == 'd-m-Y H:i'){
         document.getElementById(date_field).value = day+'-'+month+'-'+year+' '+hour+':'+minute;
      }else{
         document.getElementById(date_field).value = year+'-'+month+'-'+day;
      }
   }
   // Clear date field if was entered date empty
   if((document.getElementById(date_field).value.length != 10) && (document.getElementById(date_field).value.length != 19) && (document.getElementById(date_field).value.length != 16)){
      document.getElementById(date_field).value = '';
   }

   // refill days in month
   refillDaysInMonth(date_field, year, month);
}

// generate password
function getRandomNum(lbound, ubound) {
   return (Math.floor(Math.random() * (ubound - lbound)) + lbound);
}

function getRandomChar(number, lower, upper, other, extra) {
   var numberChars = "0123456789";
   var lowerChars = "abcdefghijklmnopqrstuvwxyz";
   var upperChars = "ABCDEFGHIJKLMNOPQRSTUVWXYZ";
   var otherChars = "`~!@#$%^&*()-_=+[{]}\\|;:'\",<.>/? ";
   var charSet = extra;
   if (number == true) charSet += numberChars;
   if (lower == true) charSet += lowerChars;
   if (upper == true) charSet += upperChars;
   if (other == true) charSet += otherChars;
   return charSet.charAt(getRandomNum(0, charSet.length));
}

function generatePassword(length) {
   extraChars = "";
   firstNumber = true; firstLower = true; firstUpper = true; firstOther = false;
   latterNumber = true; latterLower = true; latterUpper = true; latterOther = false;
   var rc = "";
   if (length > 0) rc = rc + getRandomChar(firstNumber, firstLower, firstUpper, firstOther, extraChars);
   for (var idx = 1; idx < length; ++idx) {
      rc = rc + getRandomChar(latterNumber, latterLower, latterUpper, latterOther, extraChars);
   }
   return rc;
}

// reset dropdown box
function resetDDL(el, refresh){
   var refresh_ = (refresh != null) ? refresh : false;
   if(document.getElementById(el)){
      document.getElementById(el).selectedIndex = 0;
      if(refresh_){
         for(i = 1; i <= 31; i++){
            document.getElementById(el).options[i].disabled = false;
         }
      }
   }
}

// verify selected records
function jsVerifySelected(unique_prefix, row_lower, row_upper, postback_method, random_string, param, button_type, flag_name, flag_value, operation_type, http_get_vars_part){
   var operation_randomize_code = '';
   if(operation_type == 'delete' || operation_type == 'clone'){
      if(!confirm(DGVocabulary._MSG["alert_perform_operation"])) return false;
      operation_randomize_code = '&'+unique_prefix+'_operation_randomize_code='+random_string;
   }
   selected_rows = '&'+unique_prefix+'rid=';
   selected_rows_ids = '';
   found = 0;
   for(i=row_lower; i < row_upper; i++){
      if(document.getElementById(unique_prefix+"checkbox_"+i) && document.getElementById(unique_prefix+"checkbox_"+i).checked == true){
         if(found == 1){ selected_rows_ids += '-'; }
         selected_rows_ids += document.getElementById(unique_prefix+"checkbox_"+i).value;
         found = 1;
      }
   }
   if(found){
      document_location_href = param+selected_rows+selected_rows_ids+operation_randomize_code;
      if(flag_name != ''){
         found = (document_location_href.indexOf(flag_name) != -1);
         if(!found){
            document_location_href += '&'+flag_name+'='+flag_value;
         }
      }
      if(postback_method == "ajax") _doSimpleRequest(unique_prefix, document_location_href.replace(/&amp;/g, '&'), http_get_vars_part, 'post');
      else if(postback_method == "post") _doSimpleRequest(unique_prefix, document_location_href.replace(/&amp;/g, '&'), http_get_vars_part, postback_method);
      else document.location.href = document_location_href.replace(/&amp;/g, '&');
   }else{
      alert(DGVocabulary._MSG["alert_select_row"]);
      return false;
   }
   return true;
}

// send edit mode fields
function jsSendEditFields(unique_prefix, browser_name, js_validation_errors){
   var result_value = true;
   var on_submit_my_check = true;
   if(window[unique_prefix+"onSubmitMyCheck"]){ if(!window[unique_prefix+"onSubmitMyCheck"]()){ on_submit_my_check = false; } };
   // two different parts of code to find & save wysiwyg editor data

   if(browser_name == "Firefox"){
      result_value = window["updateWysiwygFieldsFF"](unique_prefix);
   }else{ // "MSIE" or other
      result_value = window["updateWysiwygFieldsIE"](unique_prefix);
   };
   var frmEditRow = document.getElementById(unique_prefix+"frmEditRow");
   if(result_value == true && on_submit_my_check == true && onSubmitCheck(frmEditRow, js_validation_errors)){
      frmEditRow.submit();
   }else{
      false;
   }
}

function updateWysiwygFieldsIE(unique_prefix, perform_check){
   var result_value_ie = true;
   var perform_check_ = (perform_check != null) ? perform_check : true;
   var frmEditRow = document.getElementById(unique_prefix+"frmEditRow");

   for (var idx=0; idx < frmEditRow.length; idx++) {
      field_name = frmEditRow.elements.item(idx).name;
      field_type = frmEditRow.elements.item(idx).type;

      // check file or image fields
      if(field_type == 'file' && perform_check_){
         if(document.getElementById(field_name).value != ''){
            alert(DGVocabulary._MSG["need_upload_file"]);
            result_value_ie = false;
         }
      }
      field_full_name = 'wysiwyg' + field_name;
      if(document.getElementById(field_full_name)){
         document.getElementById(field_name).value = document.getElementById(field_full_name).contentWindow.document.body.innerHTML;
         if((document.getElementById(field_name).value == '<br>') || (document.getElementById(field_name).value == '<P>&nbsp;</P>') || (document.getElementById(field_name).value == '&lt;P&gt;&nbsp;&lt;/P&gt;')){
            document.getElementById(field_name).value = '';
         }
      }
   }
   return result_value_ie;
}

function updateWysiwygFieldsFF(unique_prefix, perform_check){
   var result_value_ff = true;
   var perform_check_ = (perform_check != null) ? perform_check : true;
   elements = document.getElementsByTagName('*');
   for (var idx = 0; idx < elements.length; idx++) {
      node = elements.item(idx);
      field_name = node.getAttribute('name');
      field_type = node.getAttribute('type');
      // check file or image fields
      if(field_type == 'file' && perform_check_){
         if(document.getElementById(field_name).value != ''){
            alert(DGVocabulary._MSG["need_upload_file"]);
            result_value_ff = false;
         }
      }
      field_full_name = 'wysiwyg' + field_name;
      if(document.getElementById(field_full_name)){
         document.getElementById(field_name).value = document.getElementById(field_full_name).contentWindow.document.body.innerHTML;
         if((document.getElementById(field_name).value == '<br>') || (document.getElementById(field_name).value == '<p>&nbsp;</p>') || (document.getElementById(field_name).value == '<p> </p>') || (document.getElementById(field_name).value == '&lt;p&gt;&nbsp;&lt;/p&gt;')){
            document.getElementById(field_name).value = '';
         }
      }
   }
   return result_value_ff;
}

function changeColor(el, color){
   if(document.getElementById(el)){
      document.getElementById(el).style.backgroundColor = color;
   }
}

function setCheckboxes(unique_prefix, row_lower, row_upper, row_color_5, row_color_0, row_color_1, check){
   if(check){
      for(i=row_lower; i < row_upper; i++){
         if(document.getElementById(unique_prefix+'checkbox_'+i)){
            document.getElementById(unique_prefix+'checkbox_'+i).checked = true;
            if(document.getElementById(unique_prefix+'row_'+i)){
               document.getElementById(unique_prefix+'row_'+i).style.background = row_color_5;
            }
         }
      }
   }else{
      for(i=row_lower; i < row_upper; i++){
         if(document.getElementById(unique_prefix+'checkbox_'+i)){
            document.getElementById(unique_prefix+'checkbox_'+i).checked = false;
            if((i % 2) == 0) row_color_back = row_color_0;
            else row_color_back = row_color_1;
            if(document.getElementById(unique_prefix+'row_'+i)){
               document.getElementById(unique_prefix+'row_'+i).style.background = row_color_back;
            }
         }
      }
   }
}

function __dgSetFocus(el){
   if(el && (el.style.display != "none") && !el.disabled){
      el.focus();
   }
}

function __dgStopPropagation(e){
   if(window.event){
      e.cancelBubble = true; // IE
   }else{
      e.stopPropagation(); // others
   }
}

function _doSimpleRequest(unique_prefix, url, http_get_vars_part, postback_method){
   if(postback_method == "post"){
      var res = "";
      url = url.replace("?", "");
      var vars = url.split("&");
      var pair = "";
      var myElement = null;
      for (var i=0;i<vars.length;i++) {
         pair = vars[i].split("=");
         var input = document.createElement('input');
         input.setAttribute('type', 'hidden');
         input.setAttribute('name', pair[0]);
         input.setAttribute('id', pair[0]);
         input.setAttribute('value', unescape(pair[1]));
         document.getElementById(unique_prefix+'frmMain').appendChild(input);
      }
      if(http_get_vars_part != "") document.getElementById(unique_prefix+'frmMain').action = http_get_vars_part;
      document.getElementById(unique_prefix+'frmMain').submit();
   }else{
      document.location.href = url;
   }
}

//-->