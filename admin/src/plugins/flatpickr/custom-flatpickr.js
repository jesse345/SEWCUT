// Flatpickr
var tDate = new Date();
var f1 = flatpickr(document.getElementsByClassName('flatpickr-input'), {
    altInput: false,
    altFormat: "F j, Y",
    dateFormat: "M d Y",
    // defaultDate: tDate
});

// var f2 = flatpickr(document.getElementById('dateTimeFlatpickr'), {
//     enableTime: true,
//     dateFormat: "m/d/Y",
// });
// var f3 = flatpickr(document.getElementById('rangeCalendarFlatpickr'), {
//     mode: "range",
// });
// var f4 = flatpickr(document.getElementById('timeFlatpickr'), {
//     enableTime: true,
//     noCalendar: true,
//     dateFormat: "H:i",
//     defaultDate: "13:45"
// });