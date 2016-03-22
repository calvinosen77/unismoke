var productModule = (function($) {  // The Revealing Module Pattern

    function init() {
        productPlugin();
        productAssignEvents();
    }

    function productPlugin(){
        $('.like-slider').slick({  // Customers Who Bought This Item Also Bought TODO Change text from "You May Also Like" to "Customers Who Bought This Item Also Bought"
            slidesToShow: 5,
            prevArrow: '<button type="button" class="slick-prev"></button>',
            nextArrow: '<button type="button" class="slick-next"></button>',
            responsive: [
                {
                    breakpoint: 1024,
                    settings: {
                        slidesToShow: 4
                    }
                },
                {
                    breakpoint: 767,
                    settings: {
                        slidesToShow: 3
                    }
                },
                {
                    breakpoint: 640,
                    settings: {
                        slidesToShow: 2
                    }
                },
                {
                    breakpoint: 480,
                    settings: {
                        slidesToShow: 1
                    }
                }
            ]
        });

        $('.mobile .product-slider, .tablet .product-slider').bxSlider({
            pagerCustom: '#product-pager',
            nextText: '.',
            prevText: '.'
        });
        $(".desktop .img-container").imagezoomsl({
            zoomrange: [1,2],
            zindex: 2,
            magnifiersize: [300,522]
        });

        $('.tooltipster').tooltipster({});
        $('form').FlowupLabels({});
    }

    function productAssignEvents(){
        var html = $('html');

        $('.open-review-form').click(function(){
            $('#reviewModal').modal('show');
        });
        $('.popup-login').click(function(e){
            e.preventDefault();
            $('#welcomeModal').modal('hide');
            setTimeout(function(){
                $('#loginModal').modal('show');
                $('body').addClass('modal-open').css({paddingRight: '17px'})
            },410);
        });


        $('.desktop #product-pager a').click(function(e){
            e.preventDefault();
        });

        $(window).load(function(){
            $('.img-zoom-container').height($(".img-container").height())
        });
        $(window).resize(function(){
            $('.img-zoom-container').height($(".img-container").height())
        })
        $('.desktop #product-pager a').mouseenter(function(){
            if(!$(this).hasClass('active')) {
                var that = $(this);
                that.parent().find('.active').removeClass('active');
                that.addClass('active');
                $(".img-container").fadeOut(300, function(){
                    $(this).attr("src", that.attr("data-default"))
                        .attr("data-large", that.attr("data-large"))
                        .fadeIn(500);
                });
            }
        });

        $('.upgrade > p').click(function(){
           if(!$(this).hasClass('open')) {
               $(this).addClass('open');
               $(this).parent().find('.hidden-block').slideDown();
           }
            else {
               $(this).removeClass('open');
               $(this).parent().find('.hidden-block').slideUp();
           }
        });

        $('.color input[type="radio"]').on('change', function(){
            var color = $(this).attr('id');
            var id    = $(this).attr('value');
            $('.main_common').css('display', 'none');
            var main_img_url = $('#init_img' + id).val();
            $('#main_img_url' + id).attr('src', main_img_url);
            $('#main_img_url' + id).attr('data-large', main_img_url);
            $('.main_img' + id).css('display', 'block');
            $('.side_common').css('display', 'none');
            $('.side_img' + id).css('display', 'block');
            $(this).parents('.color').find('.ch-color').html(color);
        });

        $('.swatches_img').hover(function(){
            var color = $(this).attr('id');
            var id    = $(this).attr('value');
            $('.main_common').css('display', 'none');
            var main_img_url = $('#init_img' + id).val();
            $('#main_img_url' + id).attr('src', main_img_url);
            $('#main_img_url' + id).attr('data-large', main_img_url);
            $('.main_img' + id).css('display', 'block');
            $(this).parents('.color').find('.ch-color').html(color);
        });

        $('.change').click(function(e){
            e.preventDefault();
            $(this).parents('.quantity').find('.controls').css({display: 'inline-block'});
            $(this).hide();
            $(this).parent().find('input').attr('readonly', false)
        });
        $('.update').click(function(e){
            e.preventDefault();
            $(this).parents('.controls').css({display: 'none'});
            $(this).parents('.quantity').find('.change').show();
            $(this).parents('.quantity').find('input').attr('readonly', true)
        });

        $('.cancel-review').click(function(){
            $('#reviewModal').modal('hide');
        });

        $('.all-review-box a').click(function(e){
            e.preventDefault();
            if(!$(this).hasClass('toggled')) {
                $(this).addClass('toggled').text('Close');
                $('.hidden-review').slideDown();
            }
            else {
                $(this).removeClass('toggled').text('See all reviews');
                $('.hidden-review').slideUp();
            }
        });

        $('.product-info form .sel-box-choosen').click(function(e){
            e.stopPropagation()
            if(!$(this).parent().find('.sel-box-result').hasClass('open')){
                $(this).parent().find('.sel-box-result').show(0);
                $(this).parent().find('.sel-box-result').addClass('open');
            }
            else {
                $(this).parent().find('.sel-box-result').hide(0);
                $(this).parent().find('.sel-box-result').removeClass('open');
            }
        });

        $('.sel-box-result li').on('click', function(e){  // Upgrade Dropdown
            e.stopPropagation();
            var valueBox = $(this).find('.good-name').text();
            if ($(this).hasClass('default-value')) {
                valueBox = $(this).find('p').text();
            }
            $(this).parent().find('.active').removeClass('active');
            $(this).addClass('active');
            $(this).parents('.form-group').find('.sel-box-choosen p').text('').text(valueBox);
            $(this).parents('.form-group').find('.sel-box-result').hide(0);
            $(this).parents('.form-group').find('.sel-box-result').removeClass('open');
        });
    }

    return {
        init: init
    };
})(jQuery);

jQuery(document).ready(function ($) {  // Loading the js modules.
    productModule.init();
});