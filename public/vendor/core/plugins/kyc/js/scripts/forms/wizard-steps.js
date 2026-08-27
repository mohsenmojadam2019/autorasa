/*=========================================================================================
    File Name: wizard-steps.js
    Description: wizard steps page specific js
    ----------------------------------------------------------------------------------------
    Item Name: Stack - Responsive Admin Theme
    Version: 3.0
    Author: PIXINVENT
    Author URL: http://www.themeforest.net/user/pixinvent
==========================================================================================*/

// Wizard tabs with numbers setup
// $(".number-tab-steps").steps({
//     headerTag: "h6",
//     bodyTag: "fieldset",
//     transitionEffect: "fade",
//     titleTemplate: '<span class="step">#index#</span> #title#',
//     labels: {
//         finish: 'ارسال اطلاعات',
//         next: 'بعدی',
//         previous: 'قبلی'
//     },
//
//     // Triggered before moving to the next step
//     onStepChanging: function (event, currentIndex, newIndex) {
//         console.log("Changing step from:", currentIndex + 1, "to", newIndex + 1);
//
//         // Example: Validate input fields before proceeding
//         let isValid = validateStepFields(currentIndex);
//         return isValid; // Return true to allow the step change, false to prevent it
//     },
//
//     // Triggered after step change
//     onStepChanged: function (event, currentIndex, priorIndex) {
//         console.log("Step changed to:", currentIndex + 1);
//         let formData = new FormData($("#kyc-form")[0]);
//
//         console.log(formData);
//         $.ajax({
//             url: "{{ route('public.kyc.nextStep') }}", // Adjust route as needed
//             type: "POST",
//             data: formData,
//             contentType: false,
//             processData: false,
//             success: function (response) {
//                 alert("اطلاعات ارسال شد!");
//                 window.location.href = response.redirect_url; // Redirect if needed
//             },
//             error: function (xhr) {
//                 alert("خطا در ارسال اطلاعات");
//                 console.error(xhr.responseText);
//             }
//         });
//     },
//
//     // Final submission on the last step
//     onFinished: function (event) {
//         alert("فرم با موفقیت ارسال شد!");
//
//         // Optionally, submit the form via AJAX
//
//     }
// });
//
// // Function to validate form fields per step
// function validateStepFields(stepIndex) {
//     let isValid = true;
//
//     // Select the current step's fields
//     $(`.wizard-circle fieldset:eq(${stepIndex}) input`).each(function () {
//         if ($(this).prop('required') && $(this).val().trim() === '') {
//             isValid = false;
//             $(this).addClass("is-invalid"); // Add Bootstrap error styling
//         } else {
//             $(this).removeClass("is-invalid");
//         }
//     });
//
//     return isValid;
// }
//

// Wizard tabs with icons setup
$(".icons-tab-steps").steps({
    headerTag: "h6",
    bodyTag: "fieldset",
    transitionEffect: "fade",
    titleTemplate: '<span class="step">#index#</span> #title#',
    labels: {
        finish: 'Submit'
    },
    onFinished: function (event, currentIndex) {
        alert("Form submitted.");
    }
});

// Vertical tabs form wizard setup
// $(".vertical-tab-steps").steps({
//     headerTag: "h6",
//     bodyTag: "fieldset",
//     transitionEffect: "fade",
//     stepsOrientation: "vertical",
//     titleTemplate: '<span class="step">#index#</span> #title#',
//     labels: {
//         finish: 'Submit'
//     },
//     onFinished: function (event, currentIndex) {
//         alert("Form submitted.");
//     }
// });

// Validate steps wizard

// Show form
var form = $(".steps-validation").show();

$(".steps-validation").steps({
    headerTag: "h6",
    bodyTag: "fieldset",
    transitionEffect: "fade",
    titleTemplate: '<span class="step">#index#</span> #title#',
    labels: {
        finish: 'Submit'
    },
    onStepChanging: function (event, currentIndex, newIndex)
    {
        // Allways allow previous action even if the current form is not valid!
        if (currentIndex > newIndex)
        {
            return true;
        }
        // Forbid next action on "Warning" step if the user is to young
        if (newIndex === 3 && Number($("#age-2").val()) < 18)
        {
            return false;
        }
        // Needed in some cases if the user went back (clean up)
        if (currentIndex < newIndex)
        {
            // To remove error styles
            form.find(".body:eq(" + newIndex + ") label.error").remove();
            form.find(".body:eq(" + newIndex + ") .error").removeClass("error");
        }
        form.validate().settings.ignore = ":disabled,:hidden";
        return form.valid();
    },
    onFinishing: function (event, currentIndex)
    {
        form.validate().settings.ignore = ":disabled";
        return form.valid();
    },
    onFinished: function (event, currentIndex)
    {
        alert("Submitted!");
    }
});

// Initialize validation
$(".steps-validation").validate({
    ignore: 'input[type=hidden]', // ignore hidden fields
    errorClass: 'danger',
    successClass: 'success',
    highlight: function(element, errorClass) {
        $(element).removeClass(errorClass);
    },
    unhighlight: function(element, errorClass) {
        $(element).removeClass(errorClass);
    },
    errorPlacement: function(error, element) {
        error.insertAfter(element);
    },
    rules: {
        email: {
            email: true
        }
    }
});


// Initialize plugins
// ------------------------------

// Pick a date
// $('.pickadate').pickadate();
//
// // Date & Time Range
// $('.datetime').daterangepicker({
//     timePicker: true,
//     timePickerIncrement: 30,
//     locale: {
//         format: 'MM/DD/YYYY h:mm A'
//     }
// });
