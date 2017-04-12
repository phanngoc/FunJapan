$(function () {
    var datePickerFrom = $("#geolocation-datepicker-from");
    var datePickerTo = $("#geolocation-datepicker-to");
    var monthNames = ["1 ", "2 ", "3 ", "4 ", "5 ", "6 ", "7 ", "8 ", "9 ", "10 ", "11 ", "12 "]

    datePickerFrom.datepicker({
        defaultDate: "-1m",
        changeMonth: true,
        numberOfMonths: 2,
        prevText: "",
        nextText: "",
        monthNames: monthNames,
        monthNamesShort: monthNames,
        onClose: function (selectedDate) {
            datePickerTo.datepicker("option", "minDate", selectedDate);
        }
    });

    datePickerTo.datepicker({
        defaultDate: null,
        changeMonth: true,
        numberOfMonths: 2,
        showCurrentAtPos: 1,
        prevText: "",
        nextText: "",
        monthNames: monthNames,
        monthNamesShort: monthNames,
        onClose: function (selectedDate) {
            datePickerFrom.datepicker("option", "maxDate", selectedDate);
        }
    });

    var defaultDateFrom =  new Date(datePickerFrom.val());
    var defaultDateTo =  new Date(datePickerTo.val());

    datePickerFrom.datepicker("setDate", defaultDateFrom);
    datePickerFrom.datepicker("option", "maxDate", defaultDateTo);
    datePickerTo.datepicker("setDate", defaultDateTo);
    datePickerTo.datepicker("option", "minDate", defaultDateFrom);

});
