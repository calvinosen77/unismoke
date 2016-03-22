var config = {};
var lastElementClicked;

var mainModule = (function($) {  // The Revealing Module Pattern
    config = { varOne: '/url/', varTwo: '/url/',
        arrayName: ['reportSummary'],
        activeHoverElements: '#wish, #account'
    };

    config['arrayOne'] = [ 'varX', 'varY'  ];
    config['arrayNameThree'] = [ 'varT', 'varZ'  ];
    config['allArrays'] = [config.arrayNameTwo, config.arrayNameThree];

    function init() {
        initPlugin();
        customClick();
        activeHoverToElements();
    }

    function initPlugin(){
        $(".scrolled").mCustomScrollbar();
        $('.main-slider').bxSlider({
            mode: 'fade',
            slideWidth: 1170,
            nextSelector: '#main-slider-next',
            prevSelector: '#main-slider-prev',
            adaptiveHeight: true,
            nextText: 'next',
            prevText: 'prev'
        });
    }

    function activeHoverToElements(){
        $(config.activeHoverElements).on('mouseover', function () {
            if($('.iSearchBox').is(':visible')) {
                $('.iSearchBox').slideUp(50);
            }
            $(config.activeHoverElements).removeClass('open');
            $(this).addClass('open');
        }).on('mouseout', function (e) {
            if (!$(e.target).parents('#ajaxLoginBox').length > 0) {
                $(this).removeClass('open');
            }
        });
    }

    function customClick(){
        var html = $('html');

        $('.dropdown-menu label').click(function(e){
            e.stopPropagation()
        });

        $('.overlay').click(function(){
            if(html.hasClass('menu-open')){
                html.removeClass('menu-open');
            }
        });

        $('.navbar-toggle').click(function(){
            html.removeClass('search-open');
            if(!html.hasClass('menu-open')) {
                html.addClass('menu-open');
            }
            else {
                html.removeClass('menu-open');
            }
        });

        $('.has-sub-menu').click(function(e){
            e.preventDefault();
            var $this = $(this);
            if($(window).width()>=901) {
                if (!$(this).parent('li').hasClass('open')) {
                    $this.parents('ul').find('.open').find('.sub-menu-box').hide();
                    $this.parents('ul').find('.open').removeClass('open');
                    $this.parent('li').addClass('open');
                    $this.parent('li').find('.sub-menu-box').show();
                }
                else {
                    $this.parent('li').find('.sub-menu-box').hide();
                    $this.parent('li').removeClass('open');
                }
            }
            else {
                if (!$this.parent('li').hasClass('open')) {
                    if ($this.parents('ul').find('.open').length > 0) {
                        $this.parents('ul').find('.open').find('.sub-menu-box').slideUp();
                        $this.parents('ul').find('.open').removeClass('open');
                        setTimeout(function () {
                            $this.parent('li').addClass('open');
                            $this.parent('li').find('.sub-menu-box').slideDown();
                        }, 400)
                    }
                    else {
                        $this.parent('li').addClass('open');
                        $this.parent('li').find('.sub-menu-box').slideDown();
                    }
                }
                else {
                    $this.parent('li').find('.sub-menu-box').slideUp();
                    $this.parent('li').removeClass('open');
                }
            }
        });

        $('.close-menu').click(function(){
            $('html').removeClass('menu-open');
        });


        $('.open-search').click(function(){
            html.removeClass('menu-open');
            if(!html.hasClass('search-open')) {
                html.addClass('search-open');
            }
            else {
                html.removeClass('search-open');
            }
        });

        /*
         $('.navbar-nav .btn-view').click(function(e){  // Display more submenu categories not in use.
         e.stopPropagation();
         if(!$(this).hasClass('toggled')) {
         $(this).parent().find('.hidden-sub-menu').slideDown();
         $(this).addClass('toggled').html('').html('Close');
         }
         else {
         $(this).parent().find('.hidden-sub-menu').slideUp();
         $(this).removeClass('toggled').html('').html('View all');
         }
         });
         */

        $('.next-btn').click(function(){
            $('html, body').stop().animate({
                scrollTop: $('.cat-box').offset().top
            }, 400);
        });
        $('.to-top').click(function(){
            $('html, body').stop().animate({
                scrollTop: $('html').offset().top
            }, 400);
        });

        $('.map-list h3').click(function(){
            if(!$(this).parent().hasClass('open')) {
                $(this).parent().addClass('open');
                $(this).parent().find('ul').slideDown();
            }
            else {
                $(this).parent().removeClass('open');
                $(this).parent().find('ul').slideUp();
            }
        });

        /*$('#welcomeModal').modal('show');*/
        $('.popup-login').click(function(e){
            e.preventDefault();
            $('#welcomeModal').modal('hide');
            setTimeout(function(){
                $('#loginModal').modal('show');
                $('body').addClass('modal-open').css({paddingRight: '17px'})
            },410);
        });

        $('.account, .wish').on('show.bs.dropdown', function () {
            html.removeClass('menu-open');
            if($('#main-menu').find('.open').length>0) {
                $('#main-menu').find('.open').find('.sub-menu-box').hide();
                $('#main-menu').find('.open').removeClass('open');
            }
        })
    }

    return {
        init: init
    };
})(jQuery);

var accountModule = (function($) {  // Account related module ( Login, Register )
    config = {
        ajaxLoader: '<img src="/image/catalog/ajax-loader.gif" />',
        ajaxLoaderWhite: '<img src="/image/catalog/ajax-loader-white-transparent.gif" />',
        arrayName: ['reportSummary'],
        activeHoverElements: '#wish, #account'
    };

    function init() {
        initAccountModule();
    }

    function initAccountModule(){
        $('#ajaxLogin').click(function() {
            // Call ValidatLoginForm();
            ajaxLogin();
        });
        $('#login-form-email ,#login-form-password').keypress(function(e){
            if(e.which == 13){  // Enter key pressed
                ajaxLogin();
            }
        });
    }

    function ajaxLogin(){
        var homeAjaxLoginForm = $('#homeAjaxLogin').serializeArray();
        console.log(homeAjaxLoginForm);
        console.log($('#homeAjaxLogin').attr( 'action' ));
        $.ajax({
            type: "POST",
            url: 'index.php?route=common/ajax_login',
            data: 'email=' + encodeURIComponent($('input[name=\'email\']').val()) + '&password=' + encodeURIComponent($('input[name=\'password\']').val()),
            dataType: 'json',
            beforeSend: function() {
                $('#ajaxLoaderWhite').html(config.ajaxLoaderWhite);
                $('#ajaxLoaderWhite').css('display', 'block');
            },
            complete: function() {
                $('#ajaxLoaderWhite').css('display', 'none');
                $('#ajaxLoaderWhite').html('');
            },
            success: function(data) {
                if (typeof(data.error_warning) != 'undefined' && data.error_warning !== null){
                    if(data.error_warning == ''){  // if User successfully logged in.
                        // display account related links
                        debugger;
                        var currentUrl = window.location.href;
                        if (currentUrl.toLowerCase().indexOf("logout") >= 0){  // If we are in route=account/logout redirect the user back to the home page after he logged in.
                            window.location.replace("/");  // Home Page
                        }else {
                            location.reload();
                        }
                    }else{
                        $('#ajaxLoginErrorMessage').html(data.error_warning)
                        $('#ajaxLoginErrorMessageBox').removeClass('hidden');
                    }
                }
            },
            error: function(xhr, ajaxOptions, thrownError) {
                alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
            }
        });
    }

    return {
        init: init
    };
})(jQuery);

jQuery(document).ready(function ($) {  // Loading the js modules.
    mainModule.init();
    accountModule.init();
});