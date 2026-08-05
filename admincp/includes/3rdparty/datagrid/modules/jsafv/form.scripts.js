<!--// 
//################################################################################
//##              -= YOU MAY NOT REMOVE OR CHANGE THIS NOTICE =-                 #
//## --------------------------------------------------------------------------- #
//##  JS Auto Form Validator version 2.0.2 (13.04.2010)                          #
//##  Developed by:  ApPhp <info@apphp.com>                                      #
//##  License:       GNU LGPL v.3                                                #
//##  Site:          http://www.apphp.com/js-formvalidator/                      #
//##  Copyright:     JS Auto Form Validator (c) 2006-2009. All rights reserved.  #
//##                                                                             #
//##  Last modifyed: 08.08.2010                                                  #
//##                                                                             #
//################################################################################
//
// Usage:
// -----
// *** copy & paste these lines between <head> and </head> tags
// Supported languages:
//     en - english, es - Espanol, fr - Francais, ja - Japanese
// <script type='text/javascript' src='lang/jsafv-en.js'></script>";
// <script type='text/javascript' src='chars/diactric_chars_utf8.js'></script>";
// <script type='text/javascript' src='form.scripts.js'></script> 
//
// //*** copy & paste these lines before your </form> tag
// <!--
//  first parameter  - (required) form name
//  second parameter - (optional, default - false) handle all fields or handle each field separately
//  third parameter  - (optional, default - false) handle hidden fields or not 
// -->
// <input type="submit" name="button" value="Submit"
//        onClick="return onSubmitCheck(document.forms['form_name'], false, false);"> 
//
////////////////////////////////////////////////////////////////////////////////


var digits="0123456789";
var digits1="0123456789.";
var digits2="0123456789,";
var digits3="0123456789.,";
var textchars="/'\"[]{}()*&^%$#@!~?<>-_+=|\\ \r\t\n.,:;`";
var lwr="abcdefghijklmnopqrstuvwxyz";
var upr="ABCDEFGHIJKLMNOPQRSTUVWXYZ";
var loginchars="_";

// r - required, s - simple
var rtypes="rs";
// n - numeric,     i - integer,    f - float,
// a - alphabetic,  t - text,       e - email,
// p - password,    l - login,      y - any, (generally used for non-english symbols)       
// z - zipcode,     v - verified,   c - checked (for checkboxes),
// u - url,         s - SSN number, m - telephone
// x - template 
// (for example - name="rxTemplate1" template="(ddd)-ddd-dd-dd", where d - digit, c - character)
var vtypes="nifatepylzvcusmx";
// for numbers:   s - signed, u - unsigned,   p - positive,   n - negative
// for strings:   u - upper,  l - lower,      n - normal,     y - any
// for telephone: m - mobile, f - fixed (stationary), i - international, y - any
var svtypes="supnlymfi";       

function makeArray(n){for(var i=1; i<=n;i++){this[i]=0;}return this;};
var dInM=makeArray(12);dInM[1]=31;dInM[2]=29;dInM[3]=31;dInM[4]=30;dInM[5]=31;dInM[6]=30;dInM[7]=31;dInM[8]=31;dInM[9]=30;dInM[10]=31;dInM[11]=30;dInM[12]=31;
var PassLength=6;
var LoginLength=6;

var bgcolor_error = "#ff8822";
var bgcolor_normal_1 = "#ffffff";
var bgcolor_normal_2 = "#fcfaf6";
var MaxInt=13
var MaxString=30;
var MaxAdress=200;
var MaxCP=15;
var whitespace=" \t\n\r";                     
var decimalPointDelimiter=".";                  
var phoneNumberDelimiters="()- ";  
var validPhoneChars=digits + phoneNumberDelimiters;
var validWorldPhoneChars=digits + phoneNumberDelimiters + "+"; 
var digitsInSocialSecurityNumber=9;
var digitsInPhoneNumber=12;
var digitsInMinPhoneNumber=5;
var digitsInZIPCode1=5;
var digitsInZIPCode2=9;
var ZIPCodeDelimiters="-";
var validZIPCodeChars=digits + ZIPCodeDelimiters;
var creditCardDelimiters=" "
var USStateCodeDelimiter="|";
var DEOK=false;

function isEmpty(s){return((s==null)||(s.length==0))}
function isShorter(str_text, str_length){s_length=(str_length==null) ? "1" : str_length;if(str_text.length < s_length) return true;else return false;}
function isValid(parm,val){if(parm=="")return true;for(i=0;i<parm.length;i++){if(val.indexOf(parm.charAt(i),0)==-1)return false;}return true;}
function isSubmitReqType(parm){return isLower(parm) && isValid(parm,rtypes);}
function isSubmitVarType(parm){return isLower(parm) && isValid(parm,vtypes);}
function isSubmitSubVarType(parm){return isLower(parm) && isValid(parm,svtypes);}
function isNumeric(parm,type){ptype=(type==null)?"0":type; pdigits=-1;switch(ptype){case 0:pdigits=digits;break;case1:pdigits=digits1;break;case 2:pdigits=digits2;break;case 3:pdigits=digits3;break;default:pdigits=digits;break;}return isValid(parm,pdigits);}
function isLower(parm){return isValid(parm,lwr + textchars + digits);}
function isUpper(parm){return isValid(parm,upr + textchars + digits);}
function isAlpha(parm){return isValid(parm,lwr + upr);}
function isAlphaNumeric(parm){return isValid(parm,lwr + upr + digits);}
function isText(parm){return isValid(parm,lwr + upr + digits3 + textchars + diac_lwr + diac_upr);}
function isAny(parm){return true;}
function isWhitespace(s){i=0;if(isEmpty(s)) return true; for(i=0;i< s.length;i++){c=s.charAt(i);if(whitespace.indexOf(c)==-1) return false;} return true;}
function isLetter(c){return (((c>="a")&&(c<="z"))||((c>="A")&&(c<="Z")))}
function isDigit(c){return ((c>="0")&&(c<="9"))}
function isLetterOrDigit(c){return (isLetter(c)||isDigit(c))}

// integer checking
function isInteger(s){ i; if(isEmpty(s)) if(isInteger.arguments.length==1) return DEOK; else return (isInteger.arguments[1]==true); for(i=0;i< s.length;i++){ c=s.charAt(i); if(!isDigit(c)) return false; } return true;}
function isSignedInteger(s){ if(isEmpty(s)){ if(isSignedInteger.arguments.length==1) return DEOK; else return (isSignedInteger.arguments[1]==true); }else{ startPos=0; secondArg=DEOK; if(isSignedInteger.arguments.length>1) secondArg=isSignedInteger.arguments[1]; if((s.charAt(0)=="-") || (s.charAt(0)=="+")) startPos=1; return (isInteger(s.substring(startPos,s.length),secondArg));}}
function isPositiveInteger(s){secondArg=DEOK;if(isPositiveInteger.arguments.length > 1) secondArg=isPositiveInteger.arguments[1];return (isSignedInteger(s,secondArg) && ((isEmpty(s) && secondArg) || (parseInt(s) > 0)));}
function isNegativeInteger(s){secondArg=DEOK;if(isNegativeInteger.arguments.length > 1) secondArg=isNegativeInteger.arguments[1]; return (isSignedInteger(s,secondArg) && ((isEmpty(s) && secondArg) || (parseInt(s) < 0)));}
function isIntegerInRange(s,a,b){if(isEmpty(s))if(isIntegerInRange.arguments.length==1) return DEOK;else return (isIntegerInRange.arguments[1]==true);if(!isInteger(s, false)) return false;num=parseInt(s);return ((num >=a) && (num <=b));}
// float checking
function isFloat(s){i=0; seenDecimalPoint=false; if(isEmpty(s)){ if (isFloat.arguments.length==1) return DEOK; else return (isFloat.arguments[1]==true); } if(s==decimalPointDelimiter) return false; for(i=0; i < s.length; i++){ c=s.charAt(i); if((c==decimalPointDelimiter) && !seenDecimalPoint) seenDecimalPoint=true; else if(!isDigit(c)) return false; } return true;}
function isSignedFloat(s){if(isEmpty(s)) if(isSignedFloat.arguments.length==1) return DEOK; else return (isSignedFloat.arguments[1]==true); else{ startPos=0;secondArg=!DEOK; if(isSignedFloat.arguments.length > 1) secondArg=isSignedFloat.arguments[1]; if((s.charAt(0)=="-") || (s.charAt(0)=="+")) startPos=1; return (isFloat(s.substring(startPos, s.length), secondArg))}}
function isPositiveFloat(s){secondArg=DEOK;if(isPositiveFloat.arguments.length > 1) secondArg=isPositiveFloat.arguments[1];return (isSignedFloat(s,secondArg) && ((isEmpty(s) && secondArg) || (parseInt(s) > 0)));}
function isNegativeFloat(s){secondArg=DEOK;if(isNegativeFloat.arguments.length > 1) secondArg=isNegativeFloat.arguments[1];return (isSignedFloat(s,secondArg) && ((isEmpty(s) && secondArg) || (parseInt(s) < 0)));}

function isAlphabetic(s){i=0;if(isEmpty(s))if(isAlphabetic.arguments.length==1) return DEOK;else return (isAlphabetic.arguments[1]==true);for(i=0;i<s.length;i++){c=s.charAt(i);if(!isLetter(c)) return false;}return true;}
function isAlphanumeric(s){i=0;if(isEmpty(s))if(isAlphanumeric.arguments.length==1) return DEOK;else return (isAlphanumeric.arguments[1]==true);for(i=0;i<s.length;i++){c=s.charAt(i);if(!(isLetter(c) || isDigit(c))) return false;}return true;}
function isZipCode(s){return (!isShorter(s,digitsInZIPCode1) && isValid(s,validZIPCodeChars));}

function Trim(fld){result="";c=0; for(i=0;i<fld.length;i++){if (fld.charAt(i) !=" " || c > 0){result +=fld.charAt(i);if (fld.charAt(i) !=" ") c=result.length;}}return result.substr(0,c);} 
function isEmail(s){ if(isEmpty(s)) if(isEmail.arguments.length==1) return DEOK; else return(isEmail.arguments[1]==true); regexp = /^([A-Za-z0-9_\-\.])+\@([A-Za-z0-9_\-\.])+\.([A-Za-z]{2,4})$/; if(regexp.test(s)){ return true; }else{ return false; } }

function isPassword(s){return !isShorter(s,PassLength) && isValid(s,lwr+upr + digits + textchars);};
function isLogin(s){return (!isShorter(s,LoginLength) && isValid(s.charAt(0),lwr + upr) && isValid(s,lwr + upr + digits + loginchars));};
function validField(fld){fld=stripBlanks(fld);if(fld=='') return false;return true;}

function isPhoneNumber(s){ return (isValid(s,validPhoneChars) && (s.length >= digitsInMinPhoneNumber && s.length <= digitsInPhoneNumber));} 
function isMobPhoneNumber(s){ return (isValid(s,validPhoneChars) && (s.length >= digitsInMinPhoneNumber && s.length <= digitsInPhoneNumber));} 
function isFixPhoneNumber(s){ return (isInteger(s) && (s.length >= digitsInMinPhoneNumber && s.length <= digitsInPhoneNumber));}
function isInternationalPhoneNumber(s){ return (isPositiveInteger(s)); }

function isYear(s){if(isEmpty(s))if(isYear.arguments.length==1)return DEOK; else return (isYear.arguments[1]==true); if (!isNonnegativeInteger(s)) return false; return (s.length==4);}
function isMonth(s){if(isEmpty(s))if(isMonth.arguments.length==1)return DEOK;else return (isMonth.arguments[1]==true);return isIntegerInRange(s,1,12);}
function isDay(s){if(isEmpty(s))if(isDay.arguments.length==1)return DEOK;else return (isDay.arguments[1]==true);return isIntegerInRange(s, 1, 31);}
function daysInFebruary(year){return(((year % 4==0) && ((!(year % 100==0)) || (year % 400==0) ) ) ? 29 : 28 );}
function isDate(year,month,day){if(!(isYear(year,false) && isMonth(month, false) && isDay(day, false))) return false; intYear=parseInt(year); intMonth=parseInt(month); intDay=parseInt(day); if (intDay > dInM[intMonth]) return false; if ((intMonth==2) && (intDay > daysInFebruary(intYear))) return false; return true; }

function isChecked(frm,ind){ return frm.elements[ind].checked; };
function isURL(url){ regexp = /^(([\w]+:)?\/\/)?(([\d\w]|%[a-fA-f\d]{2,2})+(:([\d\w]|%[a-fA-f\d]{2,2})+)?@)?([\d\w][-\d\w]{0,253}[\d\w]\.)+[\w]{2,4}(:[\d]+)?(\/([-+_~.\d\w]|%[a-fA-f\d]{2,2})*)*(\?(&?([-+_~.\d\w]|%[a-fA-f\d]{2,2})=?)*)?(#([-+_~.\d\w]|%[a-fA-f\d]{2,2})*)?$/; if(regexp.test(url)){ return true; } return false; }

function isSSN(s) {
    var match_num = s.match(/^(\d{3})-?\d{2}-?\d{4}$/);
    var dashes = s.split('-').length - 1;
    if(match_num == null || dashes == 1){
        return false; 
    }
    return true;
}

function isTemplate(t, s){
    if(t){
        if(t.length != s.length) return false;
        for(var i=0; i < t.length; i++){
            if((t.charAt(i) == "d" || t.charAt(i) == "D") && isDigit(s.charAt(i))){
                // ok
            }else if((t.charAt(i) == "c" || t.charAt(i) == "C") && isAlpha(s.charAt(i))){
                // ok
            }else if(t.charAt(i) == s.charAt(i)){
                // ok    
            }else{
                return false;         
            }
        }
        return true;         
    }
    return true;
}

function getProValidateFieldValue(frm,p_ind){cur_field_name=frm.elements[p_ind].name.substring(2,frm.elements[p_ind].name.length);cur_field_prefics = frm.elements[p_ind].name.substring(0,2);found_field_ind=-1;for(gvind=0;((gvind<frm.elements.length) && (found_field_ind==-1));gvind++){if((cur_field_name==frm.elements[gvind].name.substring(2, frm.elements[gvind].name.length)) && (cur_field_prefics != frm.elements[gvind].name.substring(0,2))){found_field_ind=gvind; break;}}if(found_field_ind !=-1) return frm.elements[found_field_ind].value;else return -1;}
function getValidateField(frm,p_ind,ret_type){cur_field_name=frm.elements[p_ind].name.substring(2,frm.elements[p_ind].name.length);found_field_ind=-1;for(gvind=0;((gvind<frm.elements.length) && (found_field_ind==-1));gvind++){if(cur_field_name==frm.elements[gvind].name.substring(2, frm.elements[gvind].name.length))found_field_ind=gvind;}if(found_field_ind !=-1){if(ret_type=="type") return frm.elements[found_field_ind].name.charAt(1);else return frm.elements[found_field_ind].title;}else{return 0;}}
function isValidateField(frm,p_ind){validation_result=false;cur_field_name=frm.elements[p_ind].name.substring(2,frm.elements[p_ind].name.length);cur_field_type=frm.elements[p_ind].name.charAt(1);found_field_ind=-1;for(vind=0;((vind<frm.elements.length)&&(found_field_ind==-1));vind++){if((cur_field_type !=frm.elements[vind].name.charAt(1)) && (cur_field_name==frm.elements[vind].name.substring(2, frm.elements[vind].name.length)))found_field_ind=vind;}if(found_field_ind !=-1){if(frm.elements[found_field_ind].name.charAt(1)=="e"){validation_result=isEmail(frm.elements[p_ind].value);}else if(frm.elements[found_field_ind].name.charAt(1)=="p"){validation_result=isPassword(frm.elements[p_ind].value);}else{validation_result=false;}}else{validation_result=false;}return validation_result;}
function equalValidateField(frm,p_ind){validation_result=false;cur_field_name=frm.elements[p_ind].name.substring(2,frm.elements[p_ind].name.length);cur_field_type=frm.elements[p_ind].name.charAt(0);found_field_ind=-1;for(evind=0;((evind<frm.elements.length) && (found_field_ind==-1)); evind++){ if((cur_field_type !=frm.elements[evind].name.charAt(1)) && (cur_field_name==frm.elements[evind].name.substring(2, frm.elements[evind].name.length))) found_field_ind=evind; }if(found_field_ind !=-1){validation_result=(frm.elements[p_ind].value==frm.elements[found_field_ind].value);}else{validation_result=false;}return validation_result;}

function setNormalBackground(frm, ind){
    if((frm.elements[ind].type) && frm.elements[ind].type.substring(0,6) != "select"){
        frm.elements[ind].style.background = bgcolor_normal_1;
    }else{
        frm.elements[ind].style.background = bgcolor_normal_2;                            
    }    
}
function setErrorBackground(frm, ind){
    frm.elements[ind].style.background = bgcolor_error;                                
}
function getFieldTitle(frm,ind){title_field=frm.elements[ind].title;if(title_field=="")title_field=frm.elements[ind].name.substring(3,frm.elements[ind].name.length);return title_field;}
function onSubmit(frm){return true;}

function onReqAlert(frm,ind,all_fields){
    check_all_fields = (all_fields==null) ? false : true;
    is_first_found = (is_found==null) ? false : is_found;
    title_of_field=getFieldTitle(frm,ind);
    setErrorBackground(frm, ind);
    if((!is_first_found) && frm.elements[ind] && (frm.elements[ind].style.display != "none") && !frm.elements[ind].disabled){
        frm.elements[ind].focus();
    }
    if(check_all_fields){
        /// return "The <" + title_of_field + "> is a required field!\n";
        return FormValidator._MSG['MSG_1'].replace(/_TITLE_OF_FIELD_/g, title_of_field);
    }else{
        // "The <" + title_of_field + "> is a required field!\nPlease, enter a valid " + title_of_field + "."
        alert(FormValidator._MSG['MSG_2'].replace(/_TITLE_OF_FIELD_/g, title_of_field));
        if((frm.elements[ind].type) && (frm.elements[ind].type.substring(0,6) !="select")){ frm.elements[ind].select(); }
        return false;        
    }
}

function onInvalidAlert(frm,ind,ftype,fstype,all_fields){
    check_all_fields = (all_fields==null) ? false : true;
    is_first_found = (is_found==null) ? false : is_found;
    type_of_field=FormValidator._MSG["SNT_1"];
    title_of_field=getFieldTitle(frm,ind);
    var field_template = "";
    if(window.all){
        field_template = (frm.elements[ind].attributes.item('template')) ? frm.elements[ind].attributes.item('template').value : "";
    }else{
        field_template = frm.elements[ind].getAttribute('template');
    }

    switch (fstype){ //supnly
        case 's': sub_type_of_field=FormValidator._MSG["SNT_2"]; break;
        case 'u': sub_type_of_field=FormValidator._MSG["SNT_3"]; sub_type_of_field2=FormValidator._MSG["SNT_4"]; break;
        case 'p': sub_type_of_field=FormValidator._MSG["SNT_5"]; break;
        case 'n': sub_type_of_field=FormValidator._MSG["SNT_6"]; sub_type_of_field2=FormValidator._MSG["SNT_7"]; break;
        case 'l': sub_type_of_field=FormValidator._MSG["SNT_8"]; sub_type_of_field2=FormValidator._MSG["SNT_8"]; break;
        default: sub_type_of_field=FormValidator._MSG["SNT_9"]; sub_type_of_field2=FormValidator._MSG["SNT_9"]; break; 
    }

    switch (ftype){
        case 'n': type_of_field=FormValidator._MSG['SNT_10'].replace("_SUB_TYPE_OF_FIELD_", sub_type_of_field); break;
        case 'i': type_of_field=FormValidator._MSG['SNT_11'].replace("_SUB_TYPE_OF_FIELD_", sub_type_of_field); break;
        case 'f': type_of_field=FormValidator._MSG['SNT_12'].replace("_SUB_TYPE_OF_FIELD_", sub_type_of_field); break;
        case 'a': type_of_field=FormValidator._MSG['SNT_13'].replace("_SUB_TYPE_OF_FIELD_", sub_type_of_field); break;
        case 't': type_of_field=FormValidator._MSG['SNT_14'].replace("_SUB_TYPE_OF_FIELD_", sub_type_of_field2); break;
        case 'p': type_of_field=FormValidator._MSG['SNT_15'].replace("_PASS_LENGTH_", PassLength); break;
        case 'l': type_of_field=FormValidator._MSG['SNT_16'].replace("_LOGIN_LENGTH_", LoginLength); break;
        case 'z': type_of_field=FormValidator._MSG['SNT_17']; break;
        case 'e': type_of_field=FormValidator._MSG['SNT_18']; break;
        case 'v': if(getValidateField(frm, ind, "type")=="e")
                    type_of_field=FormValidator._MSG['SNT_18']; 
                  else if(getValidateField(frm, ind, "type")=="p")
                    type_of_field=FormValidator._MSG['SNT_19'].replace("_PASS_LENGTH_", PassLength); 
                  else
                    type_of_field=FormValidator._MSG['SNT_20'];
                  break;
        case 'c': type_of_field=""; break;
        case 'u': type_of_field=FormValidator._MSG['SNT_21']; break;
        case 's': type_of_field=FormValidator._MSG['SNT_22']; break;
        case 'x': type_of_field=FormValidator._MSG['SNT_23'].replace("_TEMPLATE_", field_template); break;
        case 'm': type_of_field=FormValidator._MSG['SNT_24']; break;
        default: break; 
    }
    setErrorBackground(frm, ind);
    if(!is_first_found && frm.elements[ind] && !frm.elements[ind].disabled) frm.elements[ind].focus();
    if(check_all_fields){
        // "You have to sign <" + title_of_field + "> box as checked!\n";
        if(ftype == "c") return FormValidator._MSG['MSG_3'].replace("_TITLE_OF_FIELD_", title_of_field) + "\n";
        // "The <" + title_of_field + "> field must " + type_of_field + "!\n";        
        else return FormValidator._MSG['MSG_4'].replace("_TITLE_OF_FIELD_", title_of_field).replace("_TYPE_OF_FIELD_", type_of_field);        
    }else{
        // "You have to sign <" + title_of_field + "> box as checked!\n"
        if(ftype == "c") alert(FormValidator._MSG['MSG_3'].replace("_TITLE_OF_FIELD_", title_of_field));
        // "The <" + title_of_field + "> field must " + type_of_field + "!\n";        
        else alert(FormValidator._MSG['MSG_4'].replace("_TITLE_OF_FIELD_", title_of_field).replace("_TYPE_OF_FIELD_", type_of_field));
        if((frm.elements[ind].type) && (frm.elements[ind].type.substring(0,6) !="select")) frm.elements[ind].select();
        return false;            
    }
}

function onNotEqualAlert(frm,ind,all_fields,is_found){
    check_all_fields = (all_fields==null) ? false : true;
    is_first_found = (is_found==null) ? false : is_found;
    type_of_field=getValidateField(frm, ind, "name");
    title_of_field=getFieldTitle(frm,ind);
    if(type_of_field==0) type_of_field="required field";
    setErrorBackground(frm, ind);
    if(!is_first_found && frm.elements[ind] && !frm.elements[ind].disabled) frm.elements[ind].focus();
    if(check_all_fields){
        // "The <" + title_of_field + "> field must be match with " + type_of_field + "!\n";        
        return FormValidator._MSG['MSG_5'].replace("_TITLE_OF_FIELD_", title_of_field).replace("_TYPE_OF_FIELD_", type_of_field);
    }else{
        // "The <" + title_of_field + "> field must be match with " + type_of_field + "!\n";        
        alert(FormValidator._MSG['MSG_5'].replace("_TITLE_OF_FIELD_", title_of_field).replace("_TYPE_OF_FIELD_", type_of_field));        
        if((frm.elements[ind].type) && (frm.elements[ind].type.substring(0,6) != "select")) frm.elements[ind].select();
        return false;
    }
}


// parametr - check hidden fields+check display.none fileds 
function onSubmitCheck(frm, handle_all_fields, handle_hidden_fields){
    check_all_fields = (handle_all_fields == null) ? false : handle_all_fields;
    check_hidden_fields = (handle_hidden_fields == null) ? false : handle_hidden_fields;
    is_required="";
    a_type="";
    b_type="";
    msg = "";
    is_found = false;
    var field_template;
    
    for(ind=0;ind<frm.elements.length;ind++){
        if(frm.elements[ind].type == undefined){ continue; }
        if((frm.elements[ind].type.substring(0,6) != "submit") && (frm.elements[ind].type.substring(0,6) != "button"))
            setNormalBackground(frm,ind);
    }        
    for(ind=0;ind<frm.elements.length;ind++){
        if((frm.elements[ind].type) &&
           (frm.elements[ind].type.substring(0,6) != "submit") && (frm.elements[ind].type.substring(0,6) != "button"))
            setNormalBackground(frm,ind);
    }        
    for(ind=0;ind<frm.elements.length;ind++){        
        if((frm.elements[ind].type == undefined) ||
           (frm.elements[ind].type.substring(0,6) == "submit") ||
           (frm.elements[ind].type.substring(0,6) == "button"))
        {
            continue;
        }
        if(!check_hidden_fields){            
           if((frm.elements[ind].type) && (frm.elements[ind].type.substring(0,6) == "hidden")) continue;
        }
        is_required=frm.elements[ind].name.charAt(0);
        a_type=frm.elements[ind].name.charAt(1);
        b_type=frm.elements[ind].name.charAt(2);       
       
        if(!isSubmitSubVarType(b_type)) b_type = "";        
        true_value=true;
        if(isSubmitReqType(is_required)
           && isSubmitVarType(a_type)
           && (((frm.elements[ind].style.display !="none") && (frm.elements[ind].type != 'textarea')) || (frm.elements[ind].type == 'textarea'))
          )
        {
            field_value=frm.elements[ind].value; //trim
            if(is_required=='r'){
                if(isEmpty(field_value)){
                    if(check_all_fields){
                        msg += onReqAlert(frm,ind,check_all_fields,is_found);
                        is_found = true;                                                
                        continue;
                    }else{
                        return onReqAlert(frm,ind);
                    }
                }else{
                    setNormalBackground(frm,ind);
                }
            };
            if(((is_required=='r') || ((is_required=='s') && (!isEmpty(field_value)))) ||
                ((a_type=='v') && (!isEmpty(getProValidateFieldValue(frm,ind)))) 
              ){
                switch (a_type){
                    case 'n': if(!isNumeric(field_value, 3))    { true_value=false; } break;
                    case 'i':
                        switch (b_type){                   
                            case 's': if(!isSignedInteger(field_value))   { true_value=false; } break;
                            case 'u': if(!isInteger(field_value))         { true_value=false; } break;
                            case 'p': if(!isPositiveInteger(field_value)) { true_value=false; } break;
                            case 'n': if(!isNegativeInteger(field_value)) { true_value=false; } break;
                            default:  if(!isSignedInteger(field_value))   { true_value=false; } break;
                        }
                        break;
                    case 'f':
                        switch (b_type){                   
                            case 's': if(!isSignedFloat(field_value))     { true_value=false; } break;
                            case 'u': if(!isFloat(field_value))           { true_value=false; } break;
                            case 'p': if(!isPositiveFloat(field_value))   { true_value=false; } break;
                            case 'n': if(!isNegativeFloat(field_value))   { true_value=false; } break;
                            default: if(!isSignedFloat(field_value))      { true_value=false; } break;
                        }
                        break;                        
                    case 'a': 
                        switch (b_type){                   
                            case 'u': if(!isAlphabetic(field_value) || !isUpper(field_value)) { true_value=false; } break;
                            case 'l': if(!isAlphabetic(field_value) || !isLower(field_value)) { true_value=false; } break;
                            case 'n': if(!isAlphabetic(field_value)) { true_value=false; } break;
                            case 'y': if(!isAlphabetic(field_value)) { true_value=false; } break;
                            default: if(!isAlphabetic(field_value))  { true_value=false; } break;
                        }
                        break;                        
                    case 't': 
                        switch (b_type){                   
                            case 'u': if(!isText(field_value) || !isUpper(field_value)) { true_value=false; } break;
                            case 'l': if(!isText(field_value) || !isLower(field_value)) { true_value=false; } break;
                            case 'n': if(!isText(field_value)) { true_value=false; } break;
                            case 'y': if(!isText(field_value)) { true_value=false; } break;
                            default: if(!isText(field_value))  { true_value=false; } break;
                        }
                        break;                        
                    case 'e':
                        switch (b_type){                   
                            case 'u': if(!isEmail(field_value) || !isUpper(field_value)) { true_value=false; } break;
                            case 'l': if(!isEmail(field_value) || !isLower(field_value)) { true_value=false; } break;
                            case 'n': if(!isEmail(field_value)) { true_value=false; } break;
                            case 'y': if(!isEmail(field_value)) { true_value=false; } break;
                            default: if(!isEmail(field_value))  { true_value=false; } break;
                        }
                        break;                        
                    case 'p': if(!isPassword(field_value))      { true_value=false; } break;
                    case 'y': if(!isAny(field_value))           { true_value=false; } break;
                    case 'l': if(!isLogin(field_value))         { true_value=false; } break;
                    case 'z': if(!isZipCode(field_value))       { true_value=false; } break;
                    case 'v': if(!isValidateField(frm, ind))    { true_value=false; }
                              else if(!equalValidateField(frm, ind)){
                                    if(check_all_fields){
                                        msg += onNotEqualAlert(frm, ind, check_all_fields, is_found);
                                    }else{
                                        return onNotEqualAlert(frm, ind);
                                    }
                                    is_found = true;
                                }                              
                              break;
                    case 'c': if(!isChecked(frm,ind))           { true_value=false; } break;
                    case 'u': if(!isURL(field_value))           { true_value=false; } break;
                    case 's': if(!isSSN(field_value))           { true_value=false; } break;                            
                    case 'm':
                        switch (b_type){                   
                            case 'm': if(!isMobPhoneNumber(field_value)) { true_value=false; } break;
                            case 'f': if(!isFixPhoneNumber(field_value)) { true_value=false; } break;
                            case 'i': if(!isInternationalPhoneNumber(field_value)) { true_value=false; } break;
                            case 'y': if(!isPhoneNumber(field_value))  { true_value=false; } break;
                            default:  if(!isPhoneNumber(field_value))  { true_value=false; } break;
                        }
                        break;                        
                    case 'x':
                        if(window.all){
                            field_template = (frm.elements[ind].attributes.item('template')) ? frm.elements[ind].attributes.item('template').value : "";
                        }else{
                            field_template = frm.elements[ind].getAttribute('template');
                        }
                        if(!isTemplate(field_template, field_value))  { true_value=false; } break;                            
                    default: break; 
                }
                if(!true_value){
                    if(check_all_fields){
                        msg += onInvalidAlert(frm, ind, a_type, b_type, check_all_fields, is_found, field_template);    
                    }else{
                        return onInvalidAlert(frm, ind, a_type, b_type);    
                    }
                    is_found = true;
                }
            }                            
        }
    }
    if(check_all_fields){
        if(msg != ""){
            alert(msg);
            return false;
        }            
    }    
    return true;    
}
//-->