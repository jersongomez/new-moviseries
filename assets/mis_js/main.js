var running = false;
var sugerencias;
$(function(){

    $('#modal-search').apFullscreenModal({
        openSelector: '#search-movie-serie'
    });


    $('#modal-login').apFullscreenModal({
        openSelector: '#open-login'
    });

    $('.nav-toggle').click(function (e) {
        $('#main-nav').toggleClass('open');
    });

    $('#main-content').click(function (e) {
        $('#main-nav').removeClass('open');
    });


    $("#toTop").click(function () {
        //1 second of animation time
        //html works for FFX but not Chrome
        //body works for Chrome but not FFX
        //This strange selector seems to work universally
        $("html, body").animate({scrollTop: 0}, 400);
    });


    var scrollTop = 0;
    $(window).scroll(function () {
        scrollTop = $(window).scrollTop();
        var width = $(window).width();


        if (scrollTop >= 100) {
            $("#toTop").fadeIn('slow');
        } else {
            $("#toTop").fadeOut('slow');
        }


    });


    $('#input-search').on('input', function () {
        $('#sugerencias').html("");
        $.ajax({
            url: $('#search-link').val(),
            type: 'get',
            data: 'query=' + $('#input-search').val(),
            success: function (data) {
                var arr = JSON.parse(data);
                var html = "<ul class='list-group' >";

                for (var i = 0; i < arr.length; i++) {
                    if (arr[i]['type'] == 'movie') {
                        html += "<a class='list-group-item' href='<?php echo base_url() ?>peliculas/" + arr[i]['id'] + "'>" + arr[i]['name'] + "</a>";
                    } else {
                        html += "<a class='list-group-item' href='<?php echo base_url() ?>series/" + arr[i]['id'] + "'>" + arr[i]['name'] + "</a>";
                    }

                }
                html += "</ul>";
                $('#sugerencias').html(html);

            }
        });


    });

    $('#login-form').submit(function () {
        if (running == false) {
            running = true;
            $('#gif-login').show();
            var url = $('#login-form').attr('action');
            var data = $('#login-form').serialize();

            $.ajax({
                type: 'post',
                url: url,
                data: data,
                success: function (result) {
                    running = false;
                    $('#gif-login').hide();

                    if ($.trim(result) === 'exito') {
                        location.reload();
                    } else {
                        $('#result-login').show();
                        $('#result-login').html(result);
                    }


                },
                error: function (result) {
                    running = false;
                    $('#gif-login').hide();
                    $('#result-login').show();
                    $('#result-login').html("Posiblemente este email ya se encuentra registrado");

                }
            });

        }
        return false;
    });

    $('#register-form').submit(function () {
        if (running == false) {
            running = true;
            $('#gif-register').show();
            var url =  $('#register-form').attr('action');
            var data = $('#register-form').serialize();

            $.ajax({
                type: 'post',
                url: url,
                data: data,
                success: function (result) {
                    running = false;
                    $('#gif-register').hide();
                    $('#result-register').show();
                    $('#register-form').trigger("reset");
                    $('#result-register').html(result);
                },
                error: function (result) {
                    running = false;
                    $('#gif-register').hide();
                    $('#result-register').show();
                    $('#result-register').html(result);

                }
            });

        }
        return false;
    });

    $('#lost-form').submit(function () {
        if (running == false) {
            running = true;
            $('#gif-lost').show();
            var url = $('#lost-form').attr('action');
            var data = $('#lost-form').serialize();

            $.ajax({
                type: 'post',
                url: url,
                data: data,
                success: function (result) {
                    running = false;
                    $('#gif-lost').hide();
                    $('#result-lost').show();
                    $('#lost-form').trigger("reset");
                    $('#result-lost').html(result);
                },
                error: function (result) {
                    running = false;
                    $('#gif-lost').hide();
                    $('#result-lost').show();
                    $('#result-lost').html(result);

                }
            });

        }
        return false;
    })
});
