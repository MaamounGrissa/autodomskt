/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

// window.Vue = require('vue');

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i)
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))

// Vue.component('example-component', require('./components/ExampleComponent.vue').default);

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

/*
const app = new Vue({
   el: '#app',
});
*/

$(document).ready(function () {

    "use strict";

    // Ajax Setup

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    // Fixing Header on scroll

    $(window).scroll(function () {
        var scroll = $(window).scrollTop();
        if (scroll >= 100) {
            $(".welcom-header").addClass("sticky");
        } else {
            $(".welcom-header").removeClass("sticky");
        }
    })

    // Reset Password Modal

    $("a[data='reset-password']").click(function(e) {
        e.preventDefault();
        $("#reset").fadeIn(500);
        $("#reset").addClass("flex");
        $("#password").focus();
    })

    $("#close-modal").click(function(e) {
        e.preventDefault();
        $("#reset").fadeOut(0);
        $("#reset").removeClass("flex")
    })

    // Reset Password Form

    $("form[name=password-reset]").on('submit', function(e) {
        e.preventDefault();

        var password = $("#password").val(),
            passwordComfirm = $("#password-confirm").val(),
            userID = $("#reset").attr("data-store"),
            errorMsg = $("#error-confirmation"),
            successMsg = $("#success"),
            url = $(this).attr("action");

            errorMsg.fadeOut(400);
            successMsg.fadeOut(400);

        if (password.length < 8) {
            errorMsg.text("Password min: 8 Char !");
            errorMsg.fadeIn(400);
        } else {
            if (password == passwordComfirm) {

                $.ajax({
                    type:'POST',
                    url: url,
                    data:{id:userID, password:password},
                    success:function(data){
                        successMsg.text("Password changed");
                        successMsg.fadeIn(400);
                        $("#password").val('');
                        $("#password-confirm").val('');
                    }
                });

            } else {
                errorMsg.text("Error Confirmation");
                errorMsg.fadeIn(400);
            }
        }
    })

    // Filter

    $(".myfilter").on('click', function(e) {
        e.preventDefault();
        var index = $(this).attr('data-value').trim(),
            target = $("#mytable tbody tr");
        $(".myfilter").removeClass("active");
        $(this).addClass("active");

        if (index == 'All') {
            $(target).each(function() {
                $(this).show();
            })
        } else {
            $(target).each(function() {
                if ( $(this).find('.type').text().trim() == index ) {
                    $(this).show();
                } else {
                    $(this).hide();
                }
            })
        }
    })

    // Search 

    // Search Items On Table

    $("#searchItem").keyup(function(e) {
        e.preventDefault();

        var myFilter = $(this).val().toUpperCase();
           
        tableItemSearch(myFilter, ".username", ".useremail", ".userphone");
        
    })

    function tableItemSearch(filter, colName, colName2="", colName3="") {
        var data = $("#mytable tbody tr")
        
        data.each(function() {
            var txtDataVal = $(this).find(colName).text().toUpperCase()

            if (colName2 != "") {
                txtDataVal += " " + $(this).find(colName2).text().toUpperCase()
            }

            if (colName3 != "") {
                txtDataVal += " " + $(this).find(colName3).text().toUpperCase()
            }

            if (txtDataVal.indexOf(filter) > -1) {
                $(this).show();
            } else {
                $(this).hide();
            }

            if (filter == "") {
                $(this).show();
            }
        })
    }

    // Images Selection

    var defaultImg = $("#select").attr("data-img");

    if ($("select[name=parent]").val() == 0 ) {
        $(".form-group-image").show();
        $(".form-group-image input[type=radio]").attr('required', 'required');
    } else {
        $(".form-group-image").hide();
        $(".form-group-image input[type=radio]").removeAttr('checked');
        $(".form-group-image input[type=radio]").removeAttr('required');
    }

    $("select[name=parent").on("change", function() {
        if ($(this).val() == 0 ) {
            $(".form-group-image").slideDown(500);
            $(".form-group-image input[type=radio]").attr('required', 'required');
            $(".form-group-image input[type=radio]").removeAttr('checked');
            $("#select").css("background-image", 'url(' + defaultImg + ')');
        } else {
            $(".form-group-image").slideUp(500);
            $(".form-group-image input[type=radio]").removeAttr('checked');
            $(".form-group-image input[type=radio]").removeAttr('required');
        }
    })

    $("#select").on('click', function() {
        $("#container").fadeToggle(200);
    })

    $(".image-container").on('click', function() {
       var url = $(this).find("img").attr("src");
       $("#select").css("background-image", "url(" + url + ")");
       $(this).find("input").attr("checked", "checked");
       $("#container").fadeOut(200);
    })

    $(".checkImage").on("submit", function() {
        alert("ok");
        if ($(this).find('input[type=radio]').hasAttr("required")) {
            $(this).find('.warning-alert').slideDown(500);
        }
    })

})
