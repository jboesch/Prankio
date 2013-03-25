var Prankio = {
    View: {}
};
(function(p){

    /*
     * Add and remove message boxes
     */
    p.View.AddMessageBox = Backbone.View.extend({

        events: {
            'click': 'render'
        },

        template: _.template('<div class="pause-box">add a <input type="text" class="pause small" placeholder="0" /> second pause, then...</div><textarea class="message" placeholder="More message fun..."></textarea>'),

        defaults: {
            appendToEl: null
        },

        initialize: function(){
            this.options = $.extend(true, {}, this.defaults, this.options);
            _.bindAll(this);
        },

        afterRender: function(){
            $.scrollTo(this.options.appendToEl.find('textarea:last'), 500);
        },

        render: function(e){
            e.preventDefault();
            this.options.appendToEl.append(this.template());
            this.afterRender();
        }

    });

    /*
     * Email me the recording!
     */
    p.View.EmailMeRecording = Backbone.View.extend({

        emailEl: null,

        events: {
            'click input[type="checkbox"]': 'toggleChecked'
        },

        initialize: function(){
            this.emailEl = this.$el.find('.email-container');
        },

        toggleChecked: function(e){
            var method = $(e.currentTarget).is(':checked') ? 'slideDown' : 'slideUp';
            this.emailEl[method]();
        }

    });

    /*
     * Submit the form! Exclamation!
     */

    p.View.Form = Backbone.View.extend({

        origSubmitValue: null,

        events: {
            'click .submit button': 'submitForm'
        },

        submitForm: function(e){
            e.preventDefault();
            this.request();
        },

        getMessageAndPauses: function(){

            return this.$el.find('.message, .pause').map(function(){
                var $el = $(this);
                var val = $.trim($el.val());
                if($(this).hasClass('pause')){
                    val = parseInt(val || 0, 10);
                }
                return val;
            }).get();

        },

        getFormData: function(){

            var phone = this.$el.find('input#phone').val();
            var message = this.getMessageAndPauses();
            var email = $.trim(this.$el.find('input.email').val());

            return {
                phone: phone,
                email: email,
                actions: message
            };

        },

        request: function(){

            var data = this.getFormData();
            var self = this;

            if($('#email-me').is(':checked') && !$.trim(data.email)){
                alert('Enter an email silly.');
                return;
            }

            this.disableSubmit();

            $.ajax({
                data: data,
                url: 'ajax.php',
                type: 'POST',
                dataType: 'json',
                success: function(res){
                    self.enableSubmit();
                    alert(res.message);
                }
            });

        },

        disableSubmit: function(){
            this.origSubmitValue = this.$el.find('.submit button').text();
            this.$el.find('.submit button').attr('disabled', 'disabled').text('Submitting...');
        },

        enableSubmit: function(){
            this.$el.find('.submit button').removeAttr('disabled').text(this.origSubmitValue);
        }

    });

})(Prankio);