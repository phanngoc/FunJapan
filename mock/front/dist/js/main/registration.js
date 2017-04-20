$(function() {
  // User info taken from FJ registration form
  var userInfo = {
    birthDate: '19'
  }
  var emailBlackList = ["@armyspy.com", "@cuvox.de", "@dayrep.com", "@einrot.com", "@fleckens.hu", "@gustr.com", "@jourrapide.com", "@rhyta.com", "@superrito.com", "@teleworm.us", "@dispostable.com", "@fakeinbox.com", "@mailinator.com", "@trbvm.com", "@yopmail.com", "@mailnesia.com"];
  var messages = {
    fj: {
      fullName: {
        required: "This field is required.",
        maxlength: "Max length {0} charactors."
      },
      email: {
        required: "This field is required.",
        maxlength: "Max length {0} charactors.",
        valueNotContains: "Invalid email address."
      },
      gender: {
        required: "This field is required.",
        valueNotEquals: "default"
      },
      password: {
        minlength: "Min length {0} charactors.",
        maxlength: "Max length {0} charactors."
      },
      confirmPassword: {
        required: "This field is required.",
        equalTo: "Password does not match the confirm password."
      },
      birthdayDay: {
        required: "This field is required."
      },
      birthdayMonth: {
        required: "This field is required."
      },
      birthdayYear: {
        required: "This field is required."
      },
      location: {
        required: "This field is required."
      },
      isAcceptPolicy: {
        required: "This field is required."
      }
    },
    jmb: {
      firstName: {
        required: "This field is required.",
        maxlength: "Max length {0} charactors.",
        lettersOnly: "Only alphabets charactors are allowed.",
        info: "First name info here."
      },
      firstName2: {
        required: "This field is required.",
        maxlength: "Max length {0} charactors.",
        info: "First name 2 info here."
      },
      firstName3: {
        maxlength: "Max length {0} charactors.",
        info: "First name 3 info here."
      },
      lastName: {
        required: "This field is required.",
        maxlength: "Max length {0} charactors.",
        info: "Last name info here."
      },
      midName: {
        maxlength: "Max length {0} charactors.",
        info: "Middle name info here."
      },
      password: {
        required: "This field is required.",
        exactLength: "Password must have exactly {0} charactors.",
        isNotSequentialNumber: "Password is invalid.",
        isNot6RepeatedNumChar: "Password is invalid.",
        valueNotContains: "Password should not contain your birth date.",
        isNotInPhoneNumber: "Password should not be in phone number.",
        isNotInAddress: "Password should not be in your addresses.",
        info: "<ul>\
                        <li><span>Birth date (the Christian Era, the name of a Japanese era)</span></li>\
                        <li><span>Telephone number</span></li>\
                        <li><span>Numbers in your address</span></li>\
                        <li><span>6 identical numbers such as 1111111</span></li>\
                        <li><span>Serial numbers such as 123456, 654321*6 identical numbers, numbers in reverse order are also unacceptable</span></li>\
                    </ul>"
      },
      confirmPassword: {
        required: "This field is required.",
        equalTo: "Password does not match the confirm password."
      },
      city: {
        required: "This field is required."
      },
      country: {
        required: "This field is required."
      },
      address1: {
        required: "This field is required.",
        maxlength: "Max length {0} charactors."
      },
      address2: {
        required: "This field is required.",
        maxlength: "Max length {0} charactors."
      },
      address3: {
        maxlength: "Max length {0} charactors."
      },
      address4: {
        maxlength: "Max length {0} charactors."
      },
      zipcode: {
        required: "This field is required.",
        maxlength: "Max length {0} charactors.",
        numberAndDashOnly: "Zipcode should contain only number and dash."
      },
      phoneNumber: {
        required: "This field is required.",
        maxlength: "Max length {0} charactors."
      },
      isAcceptPolicy: {
        required: "This field is required."
      }
    }
  }

  // Add more inputs
  //  1. last name
  var addFn_2 = $('#addFn_2');
  var addFn_3 = $('#addFn_3');
  var rmFn_2 = $('#rmFn_2');
  var rmFn_3 = $('#rmFn_3');

  var firstName2_block = $('#firstName2_block');
  var firstName3_block = $('#firstName3_block');

  var firstName2 = $('#jmbFirstName2');
  var firstName3 = $('#jmbFirstName3');
  var midName = $('#jmbMidName');
  var lastName = $('#jmbLastName');

  addFn_3.addClass('hidden');
  lastName.prop('required', true);

  addFn_2.click(function() {
    $(this).addClass('hidden');
    addFn_3.removeClass('hidden');
    firstName2_block.removeClass('hidden');
    firstName2.prop('required', true);
    lastName.prop('required', false);
    lastName.tooltip('destroy');
    lastName.prop('disabled', true);
    midName.prop('disabled', true);
  });

  addFn_3.click(function() {
    $(this).addClass('hidden');
    rmFn_2.addClass('hidden');
    firstName3_block.removeClass('hidden');
  });

  rmFn_3.click(function() {
    addFn_3.removeClass('hidden');
    rmFn_2.removeClass('hidden');
    $('#jmbFirstName3').val('');
    firstName3_block.addClass('hidden');
  });

  rmFn_2.click(function() {
    addFn_2.removeClass('hidden');
    addFn_3.addClass('hidden');
    $('#jmbFirstName2').val('');
    firstName2_block.addClass('hidden');
    firstName2.prop('required', false);
    lastName.prop('required', true);
    lastName.prop('disabled', false);
    midName.prop('disabled', false);
  });

  // 2. address 
  var addAddressBtn = $('.control-btn.address');
  var addressCount = 3;
  addAddressBtn.click(function() {
    var parent_block = $(this).parents('.form-group');
    var inserted_block = parent_block.clone(true, true);
    inserted_block.removeClass('has-feedback');
    inserted_block.find('.form-control-feedback').remove();
    inserted_block.find('.col-form-label').attr('for', 'address' + addressCount).text('Address ' + addressCount);
    inserted_block.find('input').attr({
      'id': 'address' + addressCount,
      'name': 'address' + addressCount,
      'placeholder': 'Address ' + addressCount
    });
    inserted_block.insertAfter(parent_block);
    $(this).addClass('hidden');
    addressCount = addressCount + 1;
  });

  // Check term checkbox when clicking term banner
  $(".term-banner>a").click(function(e) {
    $(".terms-checkbox").prop('checked', true);
  })

  // Scrollbar
  $('.scrollbar-inner').customScrollbar({
    skin: "default-skin",
    hScroll: false,
    updateOnWindowResize: true
  });

  // Input guides
  var infoTooltipBtns = $('.info-tooltip-btn');

  $('#firstName1Info').tooltip({
    title: messages.jmb.firstName.info,
    placement: 'top',
    trigger: 'manual',
    html: true
  });

  $('#firstName2Info').tooltip({
    title: messages.jmb.firstName2.info,
    placement: 'top',
    trigger: 'manual',
    html: true
  });

  $('#firstName3Info').tooltip({
    title: messages.jmb.firstName3.info,
    placement: 'top',
    trigger: 'manual',
    html: true
  });

  $('#lastNameInfo').tooltip({
    title: messages.jmb.lastName.info,
    placement: 'top',
    trigger: 'manual',
    html: true
  });

  $('#midNameInfo').tooltip({
    title: messages.jmb.midName.info,
    placement: 'top',
    trigger: 'manual',
    html: true
  });

  $('#pwInfo').tooltip({
    title: messages.jmb.password.info,
    placement: 'top',
    trigger: 'manual',
    html: true
  });

  $.each(infoTooltipBtns, function(index, tooltipBtn) {
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

  // Validation warning tooltip
  function showToolTip(el, msg) {
    el.tooltip('destroy');
    el.tooltip({
      'title': msg,
      'placement': 'bottom',
      'trigger': 'manual'
    });
    el.tooltip('show');
  }

  function hideToolTip(el) {
    el.tooltip('destroy');
  }

  // Validation custom rules
  $.validator.addMethod("valueNotContains", function(value, element, checkingArray) {
    var i = 0;
    for (i = 0; i < checkingArray.length; i++) {
      if (value.indexOf(checkingArray[i]) >= 0) {
        return false;
      }
    }
    return true;
  });

  $.validator.addMethod("lettersOnly", function(value, element) {
    return this.optional(element) || /^[a-z]+$/i.test(value);
  });

  $.validator.addMethod("exactLength", function(value, element, param) {
    return this.optional(element) || value.length === param;
  });

  $.validator.addMethod("numberAndDashOnly", function(value, element, param) {
    return this.optional(element) || /^[0-9\-]+$/i.test(value);
  });

  $.validator.addMethod("isNotSequentialNumber", function(value, element) {
    var i = 0;
    for (i; i < value.length - 1; i++) {
      var testVal = parseInt(value.charAt(i)) + 1;
      if (parseInt(value.charAt(i + 1)) != testVal) {
        return true;
      }
    }
    return false;
  });

  $.validator.addMethod("isNot6RepeatedNumChar", function(value, element) {
    if (value % 111111 == 0) {
      return false;
    } else {
      return true;
    }
  });

  // FJ - form validation
  $("#fjRegisterForm").validate({
    rules: {
      fullName: {
        required: true,
        maxlength: 50
      },
      email: {
        required: true,
        maxlength: 50,
        valueNotContains: emailBlackList
      },
      gender: {
        required: true
      },
      password: {
        minlength: 6,
        maxlength: 50
      },
      confirmPassword: {
        required: true,
        equalTo: "#fjPassword"
      },
      birthdayDay: {
        required: true
      },
      birthdayMonth: {
        required: true
      },
      birthdayYear: {
        required: true
      },
      location: {
        required: true
      },
      isAcceptPolicy: {
        required: true
      }
    },
    messages: messages.fj,
    errorPlacement: function(error, element) {
      var ele = $(element),
        err = $(error),
        msg = err.text();
      if (msg != null && msg !== "") {
        showToolTip(ele, msg);
      }
    },
    success: function(label, element) {
      var ele = $(element);
      ele.tooltip('hide');
    },
    submitHandler: function(form) {
      alert('valid form');
      return false;
    }
  });

  // JMB - form validation
  $("#jmbRegisterForm").validate({
    rules: {
      firstName: {
        required: true,
        maxlength: 10,
        lettersOnly: true
      },
      firstName2: {
        maxlength: 9
      },
      firstName3: {
        maxlength: 9
      },
      lastName: {
        maxlength: 9
      },
      midName: {
        maxlength: 9
      },
      password: {
        required: true,
        exactLength: 6,
        isNotSequentialNumber: true,
        isNot6RepeatedNumChar: true,
        valueNotContains: [userInfo.birthDate]
      },
      confirmPassword: {
        required: true,
        equalTo: "#jmbPassword"
      },
      city: {
        required: true
      },
      country: {
        required: true
      },
      address1: {
        required: true,
        maxlength: 30
      },
      address2: {
        required: true,
        maxlength: 30
      },
      address3: {
        maxlength: 30
      },
      address4: {
        maxlength: 30
      },
      zipcode: {
        required: true,
        maxlength: 10,
        numberAndDashOnly: true
      },
      phoneNumber: {
        required: true,
        maxlength: 20,
        numberAndDashOnly: true
      },
      isAcceptPolicy: {
        required: true
      }
    },
    messages: messages.jmb,
    errorPlacement: function(error, element) {
      var ele = $(element),
        err = $(error),
        msg = err.text();
      if (msg != null && msg !== "") {
        showToolTip(ele, msg);
      }
    },
    success: function(label, element) {
      var ele = $(element);
      ele.tooltip('hide');
    },
    submitHandler: function(form) {
      alert('valid form');
      return false;
    }
  });

  // JMB - Other validations rules
  // Password
  function isInPhoneNumber(testValue) {
    return $('#jmbPhoneNumber').val().indexOf(testValue) >= 0;
  }

  function isInHomeAddress(testValue) {
    var i = 0;
    for (i; i < $('.addressInput').length; i++) {
      if ($($('.addressInput')[i]).val().indexOf(testValue) >= 0) {
        return true;
      }
    }
    return false;
  }

  $('#jmbPassword').focusout(function() {
    setTimeout(
      function() {
        var jmbPassword = $('#jmbPassword');
        if (jmbPassword.val() != "" && isInPhoneNumber(jmbPassword.val())) {
          showToolTip(jmbPassword, messages.jmb.password.isNotInPhoneNumber);
        } else if (jmbPassword.val() != "" && isInHomeAddress(jmbPassword.val())) {
          showToolTip(jmbPassword, messages.jmb.password.isNotInAddress);
        } else {
          hideToolTip(jmbPassword);
        }
      }, 10
    );
  });

  $('#jmbPhoneNumber').focusout(function() {
    var jmbPassword = $('#jmbPassword');
    if (jmbPassword.val() != "" && isInPhoneNumber(jmbPassword.val())) {
      showToolTip(jmbPassword, messages.jmb.password.isNotInPhoneNumber);
    } else {
      hideToolTip(jmbPassword);
    }
  });

  $.each($('.addressInput'), function(index, el) {
    var jmbPassword = $('#jmbPassword');
    $(el).focusout(function() {
      if (jmbPassword.val() != "" && isInHomeAddress(jmbPassword.val()) == true) {
        showToolTip(jmbPassword, messages.jmb.password.isNotInAddress);
      } else {
        hideToolTip(jmbPassword);
      }
    });
  });
});