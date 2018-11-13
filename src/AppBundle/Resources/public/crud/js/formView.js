(function($) {
    "use strict";

    // Global Variables
    var MAX_HEIGHT = 100;

    $.formView = function(el, options) {

        // Global Private Variables
        var MAX_WIDTH = 200;
        var base = this;
        var modal = null;
        var msg_error = 'INFO: Oops!, no se completo el proceso. Contacte a su proveedor ';

        base.$el = $(el);
        base.el = el;
        base.$el.data('formView', base);

        base.init = function(){
            var totalButtons = 0;
            // base.$el.append('<button name="public" style="'+base.options.buttonStyle+'">Private</button>');

            modal = $('#' + options.modal_view_id);
        };

        base.openModal = function(event, context) {
            // debug(e);

            // base.options.buttonPress.call( this );
            var id = $(context).parent().data('id');
            var modalBody = modal.find('.modal-body');

            $.ajax({
                url: options.route_view,
                type: 'POST',
                dataType: 'html',
                data: {id:id},
                beforeSend: function(jqXHR, settings) {
                    modalBody.html('<div align="center"><i class="fa fa-2x fa-refresh fa-spin"></i></div>');
                },
                success: function(data, textStatus, jqXHR) {
                    modalBody.html(data);
                },
                error: function(jqXHR, exception) {
                    modalBody.html('<p>' + msg_error + '(code 6060)</p>');
                }
            });
        };

        // Private Functions
        function debug(e) {
            console.log(e);
        }

        base.init();
    };

    // $.formView.defaultOptions = {
    //     buttonStyle: "border: 1px solid #fff; background-color:#000; color:#fff; padding:20px 50px",
    //     buttonPress: function () {}
    // };

    $.fn.formView = function(options){

        return this.each(function(){

            var bp = new $.formView(this, options);

            $(document).on('click', 'td.' + options.table_td_class, function() {
                bp.openModal(event, this);
            });

        });
    };

})(jQuery);