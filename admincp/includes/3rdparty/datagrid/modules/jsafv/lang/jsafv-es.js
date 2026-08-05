FormValidator = function () { 

}; 

// tooltips 
FormValidator._MSG = {}; 
FormValidator._MSG["MSG_1"] = "<_TITLE_OF_FIELD_> es un campo requerido!\n"; 
FormValidator._MSG["MSG_2"] = "<_TITLE_OF_FIELD_> es un campo requerido!\nPor favor, ingrese correctamente <_TITLE_OF_FIELD_>."; 
FormValidator._MSG["MSG_3"] = "<_TITLE_OF_FIELD_> - Ud. debe de marcar el checkbox!\n"; 
FormValidator._MSG["MSG_4"] = "El campo <_TITLE_OF_FIELD_> debe de ser: _TYPE_OF_FIELD_!\nPor favor, reingrese." 
FormValidator._MSG["MSG_5"] = "El campo <_TITLE_OF_FIELD_> debe de coincidir con: _TYPE_OF_FIELD_!\nPor favor, reingrese."; 
        
FormValidator._MSG["SNT_1"] = ":"; 
FormValidator._MSG["SNT_2"] = "con signo "; 
FormValidator._MSG["SNT_3"] = "sin signo "; 
FormValidator._MSG["SNT_4"] = "En may\u00fasculas"; 
FormValidator._MSG["SNT_5"] = "positivo "; 
FormValidator._MSG["SNT_6"] = "negativo "; 
FormValidator._MSG["SNT_7"] = "normal "; 
FormValidator._MSG["SNT_8"] = "en min\u00fasculas "; 
FormValidator._MSG["SNT_9"] = "a "; 
FormValidator._MSG["SNT_10"] = "_SUB_TYPE_OF_FIELD_ valor num\u00e9rico"; 
FormValidator._MSG["SNT_11"] = "_SUB_TYPE_OF_FIELD_ valor entero"; 
FormValidator._MSG["SNT_12"] = "_SUB_TYPE_OF_FIELD_ n\u00famero decimal"; 
FormValidator._MSG["SNT_13"] = "_SUB_TYPE_OF_FIELD_ alfab\u00e9tico"; 
FormValidator._MSG["SNT_14"] = "_SUB_TYPE_OF_FIELD_ texto"; 
FormValidator._MSG["SNT_15"] = "debe de contener por lo menos _PASS_LENGTH_ caracteres, \n \u00fanicamente se aceptan combinaciones de letras y d\u00edgitos"; 
FormValidator._MSG["SNT_16"] = "debe de contener por lo menos _LOGIN_LENGTH_ caracteres,\n Y debe de comenzar con una letra, \u00fanicamente se aceptan combinaciones de letras y d\u00edgitos"; 
FormValidator._MSG["SNT_17"] = "un c\u00f3digo zip(post) (5 dнgitos como mнnimo)"; 
FormValidator._MSG['SNT_18'] = "estar en formato de correo electr\u00f3nico"; 
FormValidator._MSG['SNT_19'] = "debe de contener por lo menos _PASS_LENGTH_ caracteres"; 
FormValidator._MSG['SNT_20'] = "es un campo requerido"; 
FormValidator._MSG['SNT_21'] = "un URL vйlido"; 
FormValidator._MSG['SNT_22'] = "un nъmero de nъmero de Seguro Social vбlido (9 dнgitos o en la forma XXX-XX-XXXX)";
FormValidator._MSG['SNT_23'] = "debe coincidir con patrуn _TEMPLATE_";
FormValidator._MSG['SNT_24'] = "ser un número de teléfono válido";