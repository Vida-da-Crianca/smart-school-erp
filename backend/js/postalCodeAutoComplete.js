$(document).ready(function(){

    $('#trigger-cep').on('click', function(){
        var $element =  $(this);
        var cep = $('input[name="guardian_postal_code"]').val().replace(/\D/g, '');
        var validatePostalCode = /^[0-9]{8}$/;
        if( !validatePostalCode.test(cep)) return alert('Digite um cep válido')

       var address = $('input[name="guardian_address"]'),
           city = $('input[name="guardian_city"]'),
           district = $('input[name="guardian_district"]'),
           state = $('input[name="guardian_state"]');

        $.ajax({
            url: `https://viacep.com.br/ws/${cep}/json/`,
            dataType: 'json',
            beforeSend: function(){
                $element.button('loading');
                address.val('...')
                city.val('...')
                district.val('...')
                state.val('...')
            },
            complete: function(){
                $element.button('reset');
            },
            success: function (data){
                address.val(data.logradouro)
                city.val(data.localidade)
                district.val(data.bairro)
                state.val(data.uf)
                $('input[name="guardian_address_number"]').focus()
            }
        })
        
    })
})