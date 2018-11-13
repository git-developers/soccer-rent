(function($) {
    "use strict";

    // Global Variables
    var MAX_HEIGHT = 100;

    $.formCreate = function(el, options) {

        // Global Private Variables
        var MAX_WIDTH = 200;
        var base = this;
        var modal = null;
        var msg_error = 'INFO: Oops!, no se completo el proceso. Contacte a su proveedor ';

        base.$el = $(el);
        base.el = el;
        base.$el.data('formCreate', base);

        base.init = function(){
            var totalButtons = 0;
            modal = $('#' + options.modal_create_id);

            // base.$el.append('<button name="public" style="'+base.options.buttonStyle+'">Private</button>');
        };

        base.openModal = function(event) {
            // debug(e);

            // base.options.buttonPress.call( this );
            var modalForm = modal.find('.modal-form');

            $.ajax({
                url: options.route_create,
                type: 'POST',
                dataType: 'html',
                data: '',
                beforeSend: function(jqXHR, settings) {
                    $('button[type="submit"]').prop('disabled', true);
                    modalForm.html('<div align="center"><i class="fa fa-2x fa-refresh fa-spin"></i></div>');
                },
                success: function(data, textStatus, jqXHR) {
                    $('button[type="submit"]').prop('disabled', false);
                    modalForm.html(data);
                },
                error: function(jqXHR, exception) {
                    modalForm.html('<p>' + msg_error + '(code 3030)</p>');
                }
            });
        };

        base.save = function(event) {
            event.preventDefault();

            var modalMsgDiv = modal.find('div#message');
            var modalMsgText = modal.find('div#message p');
            var modalRefresh = modal.find('i.fa-refresh');

            var fields = $("form[name='" + options.form_create_name + "']").serializeArray();

            $.ajax({
                url: options.route_create,
                type: 'POST',
                dataType: 'json',
                data: fields,
                beforeSend: function(jqXHR, settings) {
                    $('button[type="submit"]').prop('disabled', true);
                    modalMsgDiv.hide();
                    modalMsgText.empty();
                    modalRefresh.show();
                },
                success: function(data, textStatus, jqXHR) {

                    $('button[type="submit"]').prop('disabled', false);
                    modalRefresh.hide();

                    if(data.status){
                        options.table_json
                            .row
                            .add(data.entity)
                            .draw()
                            .node();

                        modal.modal('hide');
                    }else{
                        var items = [];
                        $(data.errors).each(function(key, value) {
                            items.push($('<li/>').text(value));
                        });

                        modalMsgText.html(items);
                        modalMsgDiv.show();
                    }

                },
                error: function(jqXHR, exception) {
                    $('button[type="submit"]').prop('disabled', false);
                    modalMsgText.html('<p>' + msg_error + '(code 3031)</p>');
                    modalMsgDiv.show();
                    modalRefresh.hide();
                }
            });

        };

        // Private Functions
        function debug(e) {
            console.log(e);
        }

        base.init();
    };

    // $.formCreate.defaultOptions = {
    //     buttonStyle: "border: 1px solid #fff; background-color:#000; color:#fff; padding:20px 50px",
    //     buttonPress: function () {}
    // };

    $.fn.formCreate = function(options){

        return this.each(function(){

            var bp = new $.formCreate(this, options);

            $('button.' + options.modal_create_id).click(function(event) {
                bp.openModal(event);
            });

            $(document).on('submit', "form[name='" + options.form_create_name + "']" , function(event) {
                bp.save(event);
            });

        });

    };

})(jQuery);