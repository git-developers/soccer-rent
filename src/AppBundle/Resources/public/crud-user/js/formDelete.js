(function($) {
    "use strict";

    // Global Variables
    var MAX_HEIGHT = 100;

    $.formDelete = function(el, options) {

        // Global Private Variables
        var MAX_WIDTH = 200;
        var base = this;
        var modal = null;
        var modalMsgDiv = null;
        var msg_error = 'INFO: Oops!, no se completo el proceso. Contacte a su proveedor ';

        base.$el = $(el);
        base.el = el;
        base.$el.data('formDelete', base);

        base.init = function(){
            var totalButtons = 0;
            modal = $('#' + options.modal_delete_id);
            modalMsgDiv = modal.find('div#message');

            // base.$el.append('<button name="public" style="'+base.options.buttonStyle+'">Private</button>');
        };

        base.openModal = function(event, context) {
            // debug(e);

            modalMsgDiv.hide();
            var id = $(context).parent().parent().data('id');
            $('.' + options.form_input_id).val(id);
            var modalLabel = modal.find('small.label');
            modalLabel.html('Item ' + id);
        };

        base.delete = function(event) {
            event.preventDefault();

            var modalMsgText = modal.find('div#message p');
            var modalRefresh = modal.find('i.fa-refresh');

            var fields = $("form[name='" + options.form_delete_name + "']").serializeArray();

            $.ajax({
                url: options.route_delete,
                type: 'DELETE',
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
                        var row = options.table_json.row('[data-id="' + data.id + '"]');
                        row.remove().draw();
                        modal.modal('hide');
                    }else{
                        modalMsgText.html(data.errors);
                        modalMsgDiv.show();
                    }

                },
                error: function(jqXHR, exception) {
                    $('button[type="submit"]').prop('disabled', false);
                    modalContent.html('<div class="modal-body"><p>' + msg_error + '(code 5050)</p></div>');
                    modalRefresh.hide();
                    modalMsgDiv.show();
                }
            });

        };

        // Private Functions
        function debug(e) {
            console.log(e);
        }

        base.init();
    };

    // $.formDelete.defaultOptions = {
    //     buttonStyle: "border: 1px solid #fff; background-color:#000; color:#fff; padding:20px 50px",
    //     buttonPress: function () {}
    // };

    $.fn.formDelete = function(options){

        return this.each(function(){

            var bp = new $.formDelete(this, options);

            $(document).on('click', 'button.' + options.modal_delete_id, function() {
                bp.openModal(event, this);
            });

            $(document).on('submit', "form[name='" + options.form_delete_name + "']" , function(event) {
                bp.delete(event);
            });

        });

    };

})(jQuery);