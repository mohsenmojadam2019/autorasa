@php
   Theme::set('breadcrumbHeight', 100);
@endphp

{!! $form->bannerDirection('horizontal')->renderForm() !!}
<style>
    button[type="submit"] {
        background-color: #314088 !important;
        color: black;
        border-radius: 16px !important;
        transition: background-color 0.3s ease, color 0.3s ease;
        border: none; /* اگه بخوای حاشیه نداشته باشه */
        padding: 10px 20px; /* اندازه دلخواه برای دکمه */
        cursor: pointer;
    }

    button[type="submit"]:hover {
        background-color: black !important;
        color: white;
    }


</style>
