$(function() {
    'use strict';

    //switch between login&singup
    $('.login-page h1 span').click(function() {
        $(this).addClass('selected').siblings().removeClass('selected');
        $('.login-page form').hide();
        console.log($('.' + $(this).data('class')).fadeIn(100));


        //$('.' + $(this).data('class')).fadeIn(100);
        // $('.' + $(this).data('class')).fadeIn(100);
    });

    /* selected     */

    $("select").selectBoxIt({
        autoWidth: false
    });


    //Hide Placeholder on form fucas
    $('[placeholder]').focus(function() {

        $(this).attr('data-text-input', $(this).attr('placeholder'));

        $(this).attr('placeholder', '');

    }).blur(function() {

        $(this).attr('placeholder', $(this).attr('data-text-input'));

    });

    /* add * to input required    */
    $('input').each(function() {
        if ($(this).attr('required') === 'required') {

            $(this).after('<span class="asterisk">*</span>');
        }
    });


    $('.confirm').click(function() {
        return confirm('Your are sure?');
    });

    $('.live').keyup(function() {

        $($(this).data('class')).text($(this).val());

    });



});