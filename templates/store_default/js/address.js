
var cities,address;
function submitAddress(data) {
    if(data.status === 'success') {
        window.location.reload();
    }
}
function setAddress(data,id) {
    $('#addresses [name="id"]').val(id);
    if(data) {
        address = JSON.parse(data);
        $.each(address, function (key, value) {
            $('#addresses [name="' + key + '"]').val(value);
        });
        $('#btn-addaddress').text('Edit');
    }
    else{
        $("#addresses")[0].reset();
        $('#btn-addaddress').text('Add');
    }
    getState('setaddress');
    $('#modal-addresses').modal('show');
}
function deleteAddress(url){
    if(confirm('Are you sure to delete this address?')){
        getJson(url,function (data) {
            window.location.reload();
        });
    }
}
function getState(action) {
    let country_code = $('#country_code').val();
    let options = '<option value="">Select State</option>';
    if(country_code) {
        getJson(urlprefix+'widget/getStates/' + country_code, function (data) {

            $('.phone_code').text(data.data.phone_code).val(data.data.phone_code);
            $('input[name="country"]').val(data.data.name);
            if (data.data.states.length === 0) {
                $('#state_code,#city_code').empty().hide();
                if(action !== 'setaddress'){
                    $('input[name="state"],input[name="city"]').val('');
                }
                $('input[name="state"],input[name="city"]').attr({type: 'text'});
                $('input[name="latitude"],input[name="longitude"]').val('');
                return;
            }
            $.each(data.data.states, function (key, value) {
                options += '<option value="' + value.state_code + '">' + value.name + '</option>';
            });
            $('#state_code').empty().append(options).show();
            if(address){
                $('#state_code').val(address.state_code);
            }
            $('input[name="state"],input[name="city"]').attr({type: 'hidden'});
            $('.reset-country').val('');
            getCity(action);
        });
    }
    else{
        getCity(action);
    }
}
function getCity(action) {
    let options = '<option value="">Select City</option>';
    let country_code = $('#country_code').val();
    let state_code = $('#state_code').val();
    if(state_code) {
        getJson(urlprefix+'widget/getCities/' + state_code + '?country=' + country_code, function (data) {
            //$('#state_code').val(data.data.state_code);
            $('input[name="state"]').val($('#state_code option:selected').text());
            if(data.data.cities){
                cities = data.data.cities;
            }
            else{
                cities = 0;
            }
            if (cities === 0) {
                $('#city_code').empty().hide();
                $('input[name="city"]').val('').attr({type: 'text'});
                $('input[name="latitude"],input[name="longitude"]').val('');
                return;
            }
            $.each(cities, function (key, value) {
                options += '<option value="' + value.id + '" >' + value.name + '</option>';
            });
            $('#city_code').empty().append(options).show();
            if(address){
                $('#city_code').val(address.city_code);
            }
            $('input[name="city"]').attr({type: 'hidden'});
            if(action !== 'setaddress'){
                $('.reset-state').val('');
            }
        });
    }
}
function selectCity() {
    let city_code = $('#city_code').val();
    $.each(cities,function (key,value) {
        if(value.id == city_code){
            $('input[name="city"]').val(value.name);
            $('input[name="latitude"]').val(value.latitude);
            $('input[name="longitude"]').val(value.longitude);
        }
    })
}

function setShippingAddress(data,id){
    if(data !== 'default') {
        address = JSON.parse(data);
    }
    else{
        address = defaultaddress;
    }
    $.each(address, function (key, value) {
        $('#shipping-address [name="sh_' + key + '"]').val(value);
    });
    $('.addresses').removeClass('default');
    $('#addresses'+id).addClass('default');

    shippingdropdown('#shippingdropdown',address,$('#selectedgateway').val());
}
