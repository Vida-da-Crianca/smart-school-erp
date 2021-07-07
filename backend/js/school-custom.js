 $(document).on('focus', ':input', function() {
     $(this).attr('autocomplete', 'off');
 });
 $(document).ready(function() {


     $('#sessionModal').modal({
         backdrop: 'static',
         keyboard: false,
         show: false
     })
     $('#activelicmodal').modal({
         backdrop: false,
         keyboard: false,
         show: false
     });
       $('#activelicmodal').on('show.bs.modal', function(event) {
         $('#purchase_code').trigger("reset");
          $('.lic_modal-body .error_message').html("");
        
       });
     $('#sessionModal').on('show.bs.modal', function(event) {
         var $modalDiv = $(event.delegateTarget);
         $('.sessionmodal_body').html("");
         $.ajax({
             type: "POST",
             url: baseurl + "admin/admin/getSession",
             dataType: 'text',
             data: {},
             beforeSend: function() {
                 $modalDiv.addClass('modal_loading');
             },
             success: function(data) {
                 $('.sessionmodal_body').html(data);
             },
             error: function(xhr) { // if error occured
                 $modalDiv.removeClass('modal_loading');
             },
             complete: function() {
                 $modalDiv.removeClass('modal_loading');
             },
         });
     })
     $(document).on('click', '.submit_session', function() {
         var $this = $(this);
         var datastring = $("form#form_modal_session").serialize();
         $.ajax({
             type: "POST",
             url: baseurl + "admin/admin/updateSession",
             dataType: "json",
             data: datastring,
             beforeSend: function() {
                 $this.button('loading');
             },
             success: function(data) {
                 if (data.status == 1) {
                     $('#sessionModal').modal('hide');
                     window.location.href = baseurl + "admin/admin/dashboard";
                     successMsg("Session change successful");
                 }
             },
             error: function(xhr) {
                 $this.button('reset');
             },
             complete: function() {
                 $this.button('reset');
             },
         });
     });
    
     //=============Sticky header==============
     $('#alert').affix({
         offset: {
             top: 10,
             bottom: function() {}
         }
     })
     $('#alert2').affix({
         offset: {
             top: 20,
             bottom: function() {}
         }
     })
     //========================================
     //==============User Quick session============
     $('#user_sessionModal').modal({
         backdrop: 'static',
         keyboard: false,
         show: false
     })
     $('#user_sessionModal').on('show.bs.modal', function(event) {
         var $modalDiv = $(event.delegateTarget);
         $('.user_sessionmodal_body').html("");
         $.ajax({
             type: "POST",
             url: baseurl + "common/getSudentSessions",
             dataType: 'text',
             data: {},
             beforeSend: function() {
                 $modalDiv.addClass('modal_loading');
             },
             success: function(data) {
                 $('.user_sessionmodal_body').html(data);
             },
             error: function(xhr) { // if error occured
                 $modalDiv.removeClass('modal_loading');
             },
             complete: function() {
                 $modalDiv.removeClass('modal_loading');
             },
         });
     });
     $(document).on('click', '.submit_usersession', function() {
         var $this = $(this);
         var datastring = $("form#form_modal_usersession").serialize();
         $.ajax({
             type: "POST",
             url: baseurl + "common/updateSession",
             dataType: "json",
             data: datastring,
             beforeSend: function() {
                 $this.button('loading');
             },
             success: function(data) {
                 if (data.status == 1) {
                     $('#sessionModal').modal('hide');
                     window.location.href = baseurl + "user/user/dashboard";
                     successMsg("Session change successful");
                 }
             },
             error: function(xhr) {
                 $this.button('reset');
             },
             complete: function() {
                 $this.button('reset');
             },
         });
     });
     //====================
     $('#commanSessionModal').modal({
         backdrop: 'static',
         keyboard: false,
         show: false
     });
     $('#commanSessionModal').on('show.bs.modal', function(event) {
         var $modalDiv = $(event.delegateTarget);
         $('.commonsessionmodal_body').html("");
         $.ajax({
             type: "POST",
             url: baseurl + "common/getAllSession",
             dataType: 'text',
             data: {},
             beforeSend: function() {
                 $modalDiv.addClass('modal_loading');
             },
             success: function(data) {
                 $('.commonsessionmodal_body').html(data);
             },
             error: function(xhr) { // if error occured
                 $modalDiv.removeClass('modal_loading');
             },
             complete: function() {
                 $modalDiv.removeClass('modal_loading');
             },
         });
     });
     $(document).on('click', '.submit_common_session', function() {
         var $this = $(this);
         var datastring = $("form#form_modal_commonsession").serialize();
         $.ajax({
             type: "POST",
             url: baseurl + "common/updateSession",
             dataType: "json",
             data: datastring,
             beforeSend: function() {
                 $this.button('loading');
             },
             success: function(data) {
                 if (data.status == 1) {
                     $('#sessionModal').modal('hide');
                     window.location.href = data.redirect_url;
                     successMsg("Session change successful");
                 }
             },
             error: function(xhr) {
                 $this.button('reset');
             },
             complete: function() {
                 $this.button('reset');
             },
         });
     });
     $("#purchase_code").submit(function(e) {
         var form = $(this);
         var url = form.attr('action');
         var $this = $(this);
         var $btn = $this.find("button[type=submit]");
         $.ajax({
             type: "POST",
             url: url,
             data: form.serialize(),
             dataType: 'JSON',
             beforeSend: function() {
                  $('.lic_modal-body .error_message').html("");
                 $btn.button('loading');
             },
             success: function(response, textStatus, xhr) {


                 if (xhr.status != 200) {
                     var $newmsgDiv = $("<div/>") // creates a div element              
                         .addClass("alert alert-danger") // add a class
                         .html(response.response);
                     $('.lic_modal-body .error_message').append($newmsgDiv);
                 }else if(xhr.status == 200){

                 if (response.status == 2) {
                     $.each(response.error, function(key, value) {
                         $('#input-' + key).parents('.form-group').find('#error').html(value);
                     });
                 }else if (response.status == 1) {
                     successMsg(response.message);
                     window.location.href=baseurl+'admin/admin/dashboard';
                     $('#activelicmodal').modal('hide');
                 }
             }
                 
             },
             error: function(xhr, status, error) {
               $btn.button('reset');
               var r = jQuery.parseJSON(xhr.responseText);          
               var $newmsgDiv = $("<div/>") // creates a div element              
                         .addClass("alert alert-danger") // add a class
                         .html(r.response);
                     $('.lic_modal-body .error_message').append($newmsgDiv);
              
             },
             complete: function() {
                 $btn.button('reset');
             },
         });
         e.preventDefault();
     });
 });

 
 $(document).ready(function () {
         $('#andappModal').modal({
         backdrop: 'static',
         keyboard: false,
         show: false
     })

      $("#andapp_code").on('submit', (function (e) {
        e.preventDefault();

        var _this = $(this);
        var $this = _this.find("button[type=submit]:focus");

        $.ajax({
             type: "POST",
             url: _this.attr('action'),
             data: _this.serialize(),
             dataType: 'JSON',
            beforeSend: function () {
                $('.andapp_modal-body .error_message').html("");
                $("[class^='input-error']").html("");
                $this.button('loading');

            },
             success: function(response, textStatus, xhr) {
                 if (xhr.status != 200) {
                     var $newmsgDiv = $("<div/>") // creates a div element
                         .addClass("alert alert-danger") // add a class
                         .html(response.response);
                     $('.lic_modal-body .error_message').append($newmsgDiv);
                 }else if(xhr.status == 200){

                 if (response.status == 2) {
                     $.each(response.error, function(key, value) {
                         $('#input-' + key).parents('.form-group').find('#error').html(value);
                     });
                 }else if (response.status == 1) {
                     successMsg(response.message);
                     window.location.href=baseurl+'schsettings';
                     $('#andappModal').modal('hide');
                 }
             }
             },
            error: function (xhr) { // if error occured
                 $this.button('reset');
               var r = jQuery.parseJSON(xhr.responseText);
               var $newmsgDiv = $("<div/>") // creates a div element
                         .addClass("alert alert-danger") // add a class
                         .html(r.response);
                     $('.andapp_modal-body .error_message').append($newmsgDiv);
            },
            complete: function () {
                $this.button('reset');
            }

        });
    }));
});

/*Fucoes de apoio com recursos de UI e acesso á dados - @leandro*/
 $(document).ready(function () {
        /***
	 * Abre um Dialog e carrega uma URL nele
	 */	
	$.fn._dialog = function(options)
	{
		var settings = $.extend({
			
			title: 'Nova Janela',
			size: BootstrapDialog.SIZE_WIDE,
			url: '',
			data: '',
			btnOk: 'Salvar',
			callback : ''
						
			
		},options);
		
		id = Math.floor(Math.random() * (9999 - 1)) + 1;
										
		var dialog = new BootstrapDialog({
			 	title: settings.title,
			 	
			 	type: BootstrapDialog.TYPE_DEFAULT,
			 	size: settings.size,
                                closeByBackdrop: false,
	            message: $('<div id="dialog-'+id+'"><div class="alert text-center"><i class="fa fa-circle-o-notch fa-spin"></i></div></div>'),
	           
	            onshown: function(dialogRef){
	               
                       $('.modal-dialog').css('z-index',1200);
	            	
	            	 $.post(settings.url, settings.data)
	        		 .done(function(resp){ dialog.getModalBody().html(resp); /*$('.bootstrap-dialog-body').addClass('my_dialog_body_'+id); $('.my_dialog_body_'+id).html(resp);*/ })
	        		 .fail(function(err){
	        				        			 
	        			text = '<div class="row" style="margin-top: 1%;"><div class="col-md-6 col-md-offset-3"><div class="alert alert-danger lead text-center">Erro ao Carregar Conteúdo! Tente Novamente!';	

	        			text += '</div></div></div>';			

	        			dialogRef.setMessage(text);
	        			
	        		});
	            	
	            	
	            },onhidden:function(dialogRef){
                        
                       
                        
                    }
	        });
		
		dialog.open();
		
	};
	
	/***
	 * Faz uma requisicao a uma URL passa paremetros e exibe o conteudo em um 'output'
	 */
	$.fn.search = function(options)
	{
		var settings = $.extend({
			url: '',
			output: '', 
			data: null,
                        loading: true
						
			
		},options);
		
                if(settings.loading){
                    $(settings.output).html("<div class='alert text-center'><i class='fa fa-circle-o-notch fa-spin'></i></div>");
                }
		
		$.post( (settings.url ) ,settings.data)
		.done(function(resp){
			$(settings.output).html(resp);
		})
		.fail(function(err){
			
			text = '<div class="alert text-center text-danger" style="border: 1px solid #F9959B; background-color: #FDEBEC;">';
                        text +='<i class="fa fa-warning"></i> Ocorreu um erro...<br />';   
                        text +='</div>';	

			$(settings.output).html(text);
			
		});
		
		
	};
	
	/*faz um submit em uma URL passa paramentros e recebe uma resposta JSON */
	$.fn._submit = function(options)
	{
		var settings = $.extend({
			
			url: '',
			button: '', 
			data: null,
			callback: null
						
			
		},options);
		
		resp_json = null;
		
                $(settings.button).prop('data-loading-text','aguarde...');
		$(settings.button).button('loading');	
                
                if(settings.loading){
                   $('.overlay-loading-box').show();
                }
		
		$.post( settings.url  ,settings.data)
		.done(function(resp){
			
			try
			{
				resp_json =  jQuery.parseJSON(resp);
				
				$(settings.button).button('reset');
                                
                                
                                if(typeof settings.callback == 'function'){
                                    settings.callback.call(this, resp_json);
                                }
                                
                                if(settings.loading){
                                    $('.overlay-loading-box').hide();
                                }
                                
                               
			}
			catch (e) {
				
                            alert('Resposta Inválida do Servidor... Por Favor, Tente Novamente!');
                               
                            if(settings.loading){
                                $('.overlay-loading-box').hide();
                            }   
                               
			}
                        
                         if( (typeof $(settings.button)) == 'object'){
                               $(settings.button).button('reset');
                                
                          }
			
			
			
			
		})
		.fail(function(err){
			
			
                        alert('Erro na Requisição ao Servidor... Por Favor, Tente Novamente!');
                           
                        if( (typeof $(settings.button)) == 'object'){
                                    $(settings.button).button('reset');
                                
                          }
                          
                           if(settings.loading){
                                    $('.overlay-loading-box').hide();
                                }
			
			
			
		});
		
		
		
		
	};
        
        
        $.fn.formatMoney = function(num)
	{
            return num.toLocaleString("pt-BR",{ minimumFractionDigits: 2 });
	};
	
	$.fn._maskMoney = function(selector)
	{
            $(selector).mask('#.##0,00', {clearIfNotMatch: false,selectOnFocus: true,reverse: true});
	};
	
	$.fn.comboBox = function(options)
	{
		var settings = $.extend({
			
			url: '',
			data: null,
			selected: null,
			combobox : ''	,
                        callback: null
			
		},options);
		
		$(settings.combobox).html('<option>Aguarde...</option>');
		
		$.post(settings.url, settings.data )
		.done(function(resp){
			
			try
			{
				resp_json =  jQuery.parseJSON(resp);
				
				if(resp_json.status)
				{
					if(resp_json.results.length > 0)
					{
						html = '';
						
						for(var i in resp_json.results)
						{
							html += '<option value="'+resp_json.results[i].value+'" ';
							if(resp_json.results[i].value == settings.selected){
								html += 'selected="selected"';
                                                            }
							html += ">";
							html += resp_json.results[i].label;
							html += '</option>';
							
						}
						
						$(settings.combobox).html(html);
                                                
                                                
                                                 if(typeof settings.callback == 'function'){
                                                            settings.callback.call(this, resp_json);
                                                 }
                                                
					}
					else{
                                            
                                            $(settings.combobox).html('<option value="0">*** Nenhum Resultado ***</option>');
                                        }
				}
				else
					$(settings.combobox).html('<option>*** Erro ao Processar ***</option>');
			}
			catch (e) {
				
				$(settings.combobox).html('<option>*** ERRO ***</option>');
				
			}
			
		})
		.fail(function(){
			
			$(settings.combobox).html('<option>*** Erro ***</option>');
		});
		
	};
	
	
	
	
 });

  