cF.RE1 = /^\d*\.\-?\d*$/;
cF.RE2 = /\.\-\d{3,}$/;
cF.RE3 = /\.\-(?=[^.]*\.)/g;
cF.RE4 = /[^\d.-]/g;
cF.RE5 = /\.(?=[^.-]*\.)/g;
cF.RE6 = /^(\d*\.\-\d{2}).+$/;
cF.RE7 = /(\.\-\d{0,1})$/;
cF.RE8 = /^([^.-]+)$/;

String.prototype.reverse = function()
{
    return this.split('').reverse().join('');
}

function cF(fld, onblur)
{
var v = fld.value;
if (!cF.RE1.test(v) || cF.RE2.test(v))
{
var ltdot = (fld.dotpos == v.indexOf('.') ?
v.lastIndexOf('.') < fld.dotpos :
v.indexOf('.') < fld.dotpos);
if (ltdot)
v = v.reverse();
v = v.replace(cF.RE3,'');
if (ltdot)
v = v.reverse();
v = v.replace(cF.RE4,'').
replace(cF.RE5,'').
replace(cF.RE6,'$1');
fld.value = v;
}
fld.dotpos = v.indexOf('.');
if (onblur)
fld.value = v.replace(cF.RE7, '$10').
replace(cF.RE7, '$10').
replace(cF.RE8, '$1.00');
}

function cFd(fld, onblur)
{
var v = fld.value;
if (!cF.RE1.test(v) || cF.RE2.test(v))
{
var ltdot = (fld.dotpos == v.indexOf('.') ?
v.lastIndexOf('.') < fld.dotpos :
v.indexOf('.') < fld.dotpos);
if (ltdot)
v = v.reverse();
v = v.replace(cF.RE3,'');
if (ltdot)
v = v.reverse();
v = v.replace(cF.RE4,'').
replace(cF.RE5,'').
replace(cF.RE6,'$1');
fld.value = v;
}
fld.dotpos = v.indexOf('.');
if (onblur)
fld.value = v.replace(cF.RE7, '$10').
replace(cF.RE7, '$10').
replace(cF.RE8, '$1');
}

function checkEmail(str){	
    if((str.indexOf(".") > 2) && (str.indexOf("@") > 0)){
       
    }
    else{
        alert('Invalid Email ID');
    }
 }