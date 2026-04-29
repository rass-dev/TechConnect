$(document).ready(function(){
    (function($) {
        "use strict";

        // Custom method example (di mo na kailangan kung walang "answer" field)
        jQuery.validator.addMethod('answercheck', function (value, element) {
            return this.optional(element) || /^\bcat\b$/.test(value)
        }, "Please type the correct answer.");

        // validate contactForm form
        $('#contactForm').validate({
            rules: {
                name: {
                    required: true,
                    minlength: 2
                },
                subject: {
                    required: true,
                    minlength: 4
                },
                phone: {
                    required: true,
                    minlength: 9
                },
                email: {
                    required: true,
                    email: true
                },
                message: {
                    required: true,
                    minlength: 20
                }
            },
            messages: {
                name: {
                    required: "Please enter your name.",
                    minlength: "Your name must have at least 2 characters."
                },
                subject: {
                    required: "Please enter a subject.",
                    minlength: "Your subject must have at least 4 characters."
                },
                phone: {
                    required: "Please enter your phone number.",
                    minlength: "Your phone number must be at least 9 digits."
                },
                email: {
                    required: "Please enter your email address.",
                    email: "Please enter a valid email address."
                },
                message: {
                    required: "Please enter your message.",
                    minlength: "Your message must have at least 20 characters."
                }
            },
            errorElement: "div",
            errorClass: "text-danger mt-1", // bootstrap style
            submitHandler: function(form) {
                $.ajaxSetup({
                    headers: {
                      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                $(form).ajaxSubmit({
                    type:"POST",
                    data: $(form).serialize(),
                    url: $(form).attr('action'),
                    success: function() {
                        $('#contactForm :input').attr('disabled', 'disabled');
                        $('#contactForm').fadeTo("slow", 1, function() {
                            $(this).find(':input').attr('disabled', 'disabled');
                            $(this).find('label').css('cursor','default');
                            $('#success').fadeIn();
                            $('.modal').modal('hide');
                            $('#success').modal('show');
                        })
                    },
                    error: function() {
                        $('#contactForm').fadeTo("slow", 1, function() {
                            $('#error').fadeIn();
                            $('.modal').modal('hide');
                            $('#error').modal('show');
                        })
                    }
                })
            }
        });

          // 🔽 Close button handler (Bootstrap handles hide, dito optional extra action)
        $('#loginModal').on('hidden.bs.modal', function () {
            // Example: reset form kapag na-close ang modal
            $('#contactForm')[0].reset();
        });

        
    })(jQuery)
});
