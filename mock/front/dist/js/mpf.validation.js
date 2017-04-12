$(document).ready(function() {

    // Input guides
    var infoTooltipBtns = $('.info-tooltip-btn');

    $('#firstName1Info').tooltip({
        title: 'firstName1Info',
        placement: 'top',
        trigger: 'manual',
        html: true
    });

    $('#firstName2Info').tooltip({
        title: 'firstName2Info',
        placement: 'top',
        trigger: 'manual',
        html: true
    });

    $('#firstName3Info').tooltip({
        title: 'firstName3Info',
        placement: 'top',
        trigger: 'manual',
        html: true
    });

    $('#lastNameInfo').tooltip({
        title: 'lastNameInfo',
        placement: 'top',
        trigger: 'manual',
        html: true
    });

    $('#midNameInfo').tooltip({
        title: 'midNameInfo',
        placement: 'top',
        trigger: 'manual',
        html: true
    });

    $('#pwInfo').tooltip({
        title: '<ul>\
                    <li><span>Birth date (the Christian Era, the name of a Japanese era)</span></li>\
                    <li><span>Telephone number</span></li>\
                    <li><span>Numbers in your address</span></li>\
                    <li><span>6 identical numbers such as 1111111</span></li>\
                    <li><span>Serial numbers such as 123456, 654321*6 identical numbers, numbers in reverse order are also unacceptable</span></li>\
                </ul>',
        placement: 'top',
        trigger: 'manual',
        html: true
    });
    
    $.each(infoTooltipBtns, function(index,tooltipBtn) {
        $(tooltipBtn).on('click', function(e) {
            if (!$(this).is(e.target) && $(this).has(e.target).length === 0 && $('.tooltip').has(e.target).length === 0) {
                $(this).tooltip('hide');
            } else {
                $(tooltipBtn).tooltip('show');
            }
        });
        
        //hide it when clicking anywhere else except trigger
        $(document).on('click touch', function(event) {
            if (!$(event.target).parents().addBack().is($(tooltipBtn))) {
                $(tooltipBtn).tooltip('hide');
            }
        });
    });    

    // add the rule here
    $.validator.addMethod("valueNotEquals", function(value, element, arg){
        return arg != value;
    }, "Value must not equal arg.");

    $("#fjRegisterForm").validate({
        rules: {
            FullName: {
                required: true,
                maxlength: 50,
                limit: true     
            },
            Email: {
                required: true,
                maxlength: 50           
            },
            Gender: {
                required: function(el) {
                  console.log('hihi');  
                },
                valueNotEquals: "default"
            },
            Password: {
                minlength: 6,
                maxlength: 50
            },
            ConfirmPassword: {
                required: true,
                equalTo: "#password"
            },
            BirthdayDay: {
                required: true
            },
            BirthdayMonth: {
                required: true
            },
            BirthdayYear: {
                required: true
            },
            Location: {
                required: true
            },
            IsAcceptPolicy: {
                required: true
            }
        },
        messages: {
            password: {
                minlength: 'hahaha'
            }
        },
        errorPlacement: function(error, element) {
            var ele = $(element),
                err = $(error),
                msg = err.text();
            if (msg != null && msg !== "") {
                console.log(msg)
                ele.tooltip('destroy');
                ele.tooltip({
                    'title': msg,
                    'placement': 'bottom',
                    'trigger': 'manual'
                });
                ele.tooltip('show');
            }
        },
        success: function(label,element) {
            var ele = $(element);
            ele.tooltip('hide');
        },
        submitHandler: function(form) {
            alert('valid form');
            return false;
        }
    });


    // JMB form validation
    jQuery.validator.addMethod("limit", function(value, element, params) {
        return false;
    }, jQuery.validator.format("Limit {0} characters"));

    $("#jmbRegisterForm").validate({
        rules: {
            password: {
                required: true,
                minlength: 5,
                limit: 6                
            },
            password2: {
                required: true,
                minlength: 5
            }
        },
        messages: {
            password: {
                minlength: 'hahaha'
            }
        },
        errorPlacement: function(error, element) {
            var ele = $(element),
                err = $(error),
                msg = err.text();
            if (msg != null && msg !== "") {
                console.log(msg)
                ele.tooltip('destroy');
                ele.tooltip({
                    'title': msg,
                    'placement': 'bottom',
                    'trigger': 'manual'
                });
                ele.tooltip('show');
            }
        },
        success: function(label,element) {
            var ele = $(element);
            ele.tooltip('hide');
        },
        submitHandler: function(form) {
            alert('valid form');
            return false;
        }
    });
});
