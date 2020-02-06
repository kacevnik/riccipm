jQuery(function() {
    // Анимируем значок YouTube

        // $('.error404').addClass('page-template-default');


    //Анимация элементов
    //это чтобы работал анимация
    (function($) {
        $.fn.animated = function(inEffect) {
            $(this).each(function() {
                var ths = $(this);
                ths.css("opacity", "0").addClass("animated").waypoint(function(dir) {
                    if (dir === "down") {
                        ths.addClass(inEffect).css("opacity", "1");
                    };
                }, {
                    offset: "90%"
                });
    
            });
        };
    })(jQuery);
    
    //конец настройки
    
    //анимация первой секции
    
    $("#T1").animated("fadeIn");
    $(".row_map").animated("fadeIn");
    // $(".row_consultation").animated("fadeIn");
    // $(".director_photo p").animated("fadeIn");
    $(".yotube_videos").animated("fadeIn");
    $(".go_to_all_category").animated("zoomInRight"); 
    $(".director_photo img").animated("bounceIn"); 
    $(".main_navigation li").animated("pulse"); 


    setTimeout(function() {
        $(".main_navigation li").removeClass("animated");
}, 3000);


    
    
    var screen_width = $(window).width();
    
    if (screen_width<1230) {
        
    } else {
                    // footer
    $(".copyright_wrapper span").animated("fadeIn"); 
    $(".write").animated("fadeIn"); 
    $("footer .call_to_phone").animated("fadeIn"); 
    }

    
    // конец анимации
    
    // Анимируем количесво проектов
        var show = true;
        var countbox = ".counter";
        $(window).on("scroll load resize", function(){
            
            if(!show) return false;                   // Отменяем показ анимации, если она уже была выполнена
            var w_top = $(window).scrollTop();        // Количество пикселей на которое была прокручена страница
            var e_top = $(countbox).offset();     // Расстояние от блока со счетчиками до верха всего документа
            var w_height = $(window).height();        // Высота окна браузера
            var d_height = $(document).height();      // Высота всего документа
            var e_height = $(countbox).outerHeight(); // Полная высота блока со счетчиками
            if(w_top + 50 >= e_top || w_height + w_top == d_height || e_height + e_top < w_height){
               $(".counter").spincrement({
                    thousandSeparator: " ",
                    duration: 2200
                });
                show = false;
            }
        });
        
        $(".counter").spincrement({
            thousandSeparator: " ",
            duration: 4200
        });
    
     
       
    
    
    //Запуск галереи на странице проекта
    var bodyclass =$("body").hasClass("single-post");
    
        if (bodyclass !=false) {
            jQuery("#gallery").unitegallery({
                theme_enable_fullscreen_button: false,
                theme_enable_play_button: false,
                theme_enable_hidepanel_button: false,
                theme_enable_text_panel: false,
                //option
                gallery_width:1170,
                gallery_height:700,
                gallery_carousel:true,
                gallery_background_color: "#ffffff",
                slider_control_zoom:false, //zoom
                slider_enable_zoom_panel: false, //zoom-pANEL
                slider_enable_arrows: true,
                slider_enable_progress_indicator: false,
                //thumbs options
                thumb_width:100,
                thumb_height:100,
                thumb_selected_border_width: 3,
                thumb_selected_border_color: "#0065ba",
                thumb_overlay_color: "#dddddd",
                thumb_overlay_opacity: 0.3,
                //stript thumbs panel options
                strippanel_padding_top:10,
                strippanel_padding_bottom:10,
                strippanel_padding_left:  10,
                strippanel_padding_right:  10,	
                strippanel_enable_buttons: false,
                strippanel_buttons_role : "scroll_strip", 
                strippanel_enable_handle: true,
                strip_thumbs_align: "center",
                strip_space_between_thumbs:10,
                strippanel_background_color:"#fff",
                strip_control_avia:false,
                strip_control_touch:true,
            });
        }
    
    
    
     // настройки табов ОТЗЫВЫ
     $(".text_tab").not(":first").hide(); // делаем первый по списку выделеным
     $(".btn_tab").click(function() {
     $(".btn_tab").removeClass("active").eq($(this).index()).addClass("active");
     $(".text_tab").hide().eq($(this).index()).fadeIn(1500)
     }).eq(0).addClass("active");
    // Tabs end

    $("body").on('click', '[href*="#"]', function(e){
        var fixed_offset = 100;
        $('html,body').stop().animate({ scrollTop: $(this.hash).offset().top - fixed_offset }, 1000);
        e.preventDefault();
      });
    
    
     // настройки  карусели отзывов
     $('.carusel_img').slick({
        infinite: false,
        nextArrow: '<span class="arrow-my-right"><i class="fa fa-angle-right" aria-hidden="true"></i></span>',
        prevArrow: '<span class="arrow-my-left"><i class="fa fa-angle-left" aria-hidden="true"></i></span>',
        slidesToShow: 6,
        slidesToScroll: 1,
        centerMode: false,
        autoplay: false,
        autoplaySpeed: 2000,
      });
    
     
      $(".btn_tab").click(function() {
        $(".carusel_img").slick('reinit'); //переинициализировать слайдер после клика на таб
        // $('.arrow-my-right').click();
      });
    
     // настройки  карусели отзывов

        $('.yotube_videos').slick({
            infinite: true,
            nextArrow: '<span class="arrow-my-right"><i class="fa fa-angle-right" aria-hidden="true"></i></span>',
            prevArrow: '<span class="arrow-my-left"><i class="fa fa-angle-left" aria-hidden="true"></i></span>',
            touchMove: true,
            slidesToShow: 3,
            slidesToScroll: 1,
            autoplay: false,
            autoplaySpeed: 8000,
          });
       

     // настройки OWL карусели Youtube
    
    
        // Настройки проигрывания видео в модальном окне Fancybox 2018.june.08
        $('[data-fancybox]').fancybox({
            youtube : {
                controls : 1,
                showinfo : 1
            },
            vimeo : {
                color : 'f00'
            }
        });
            // end Script
    
    
     // настройки табов ПРОЕКТЫ

        $(".tab_item").not(":first").hide(); // делаем первый по списку выделеным
        $(".tabs_project_list li").click(function() {
        $(".tabs_project_list li").removeClass("active").eq($(this).index()).addClass("active");
        $(".tab_item").hide().eq($(this).index()).fadeIn(1500)
        }).eq(0).addClass("active");
    // Tabs end
    
    
    //Скрипт для работы формы отправки
    $( ".owner input" ).focusin(function(){
        $('.lab1').addClass("active_label");
        $(this).addClass("border_blue");
    
    });
    
    $( ".owner input" ).focusout(function(){
        $('.lab1').removeClass("active_label");
        $(this).removeClass("border_blue");
        if($(this).val().length!=0) {
            $('.lab1').addClass("active_label");
        }else  {
            $('.lab1').removeClass("active_label");
        }
          });
    
    //Маска поля NAME
          $(".owner input").on("keypress", function(e) { 
            var char = /["a-zA-Z а-яА-Я]/;
            var val = String.fromCharCode(e.which);
            var test = char.test(val);  
            if(!test) return false
     });
    //Маска поля Email
        $( ".owner2 input" ).focusin(function(){
        $('.lab2').addClass("active_label");
        $(this).addClass("border_blue");
    });
    
    $( ".owner2 input" ).focusout(function(){
        $('.lab2').removeClass("active_label");
        $(this).removeClass("border_blue");
        if($(this).val().length!=0) {
            $('.lab2').addClass("active_label");
        }else  {
            $('.lab2').removeClass("active_label");
        }
        var email = $(this).val();
      if (email.length > 0 && (email.match(/.+?\@.+/g) || []).length !== 1) {
    // делаем что при не правильном вводе
        $(this).addClass("error");
      } else {$(this).removeClass("error");
    //делаем то что надо при правильном емайле
      }
          });
    
    //Настройки поля PHONE
    $( ".owner3 input" ).focusin(function(){
        $('.lab3').addClass("active_label");
        $(this).addClass("border_blue");
    
    });
    
    $( ".owner3 input" ).focusout(function(){
        if($(this).val().match(/[\_]/g)){
            $('.lab3').removeClass("active_label");
        }
        $('.lab3').removeClass("active_label");
        $(this).removeClass("border_blue");

       if($( ".owner3 input" ).val().match(/[\_]/g)) {
        $('.lab3').removeClass("active_label");
       
        } else  {
            $('.lab3').addClass("active_label");
       
         }
          });
    
    $(".owner3 input").mask("+7(999) 999-99-99");
    
    
    
    //Проверка и отправка формы
    //Подсветка кнопки
    
    
        function checkParams() {
        var name = $('.owner input').val();
        var email = $('.owner2 input').val();
        var phone = $('.owner3 input').val();
        var chek = $("#cheked");
        
         
        if(name.length >= 3 && email.length >= 5 && phone.length >= 10 && chek.is(':checked')) {
            $('.submit_form').removeAttr('disabled');
            $('.submit_form').addClass('submit_form_good');
        } else {
            $('.submit_form').attr('disabled', 'disabled')
            $('.submit_form').removeClass('submit_form_good');;
        }
    }
    
    $( ".owner input, .owner2 input, .owner3 input" ).keyup(function(){
        checkParams();
    });
    $("#cheked").click(function() {
        jQuery.preloadImages = function()
{
for(var i = 0; i < arguments.length; i++)
{
jQuery("<img>").attr("src", arguments[ i ]);
}
};
//указываем путь к изображению, которое нужно подгрузить
$.preloadImages("/wp-content/themes/s-a-ricci/img/last_frame.jpg", "/wp-content/themes/s-a-ricci/img/email_send.gif");
        checkParams();
      });
    
    
    // Отправка
    $(".fromconsul").submit(function() {


        $.ajax({
            type: "POST",
            url: "/wp-content/themes/s-a-ricci/mail.php",
            data: $(this).serialize()
        }).done(function() {
            $('.fromconsul input, .fromconsul button, .fromconsul label, .fromconsul span').hide(300);
            setTimeout(function() {
                $('.form_section').css('backgroundImage', 'url(/wp-content/themes/s-a-ricci/img/last_frame.jpg)');
                $('.form_section').css('backgroundImage', 'url(/wp-content/themes/s-a-ricci/img/email_send.gif)');
        }, 1000);
            setTimeout(function() {
                $('.form_section').css('backgroundImage', 'url(/wp-content/themes/s-a-ricci/img/last_frame.jpg)');
               
                $('.fromconsul .owner5').css('paddingTop',  "60px");
                $('.fromconsul .owner5').html('Ожидайте звонка.<br>Наш менеджер свяжется с вами в самое ближайшее время');
                // jQuery.fancybox.close();
            }, 4400);
        });
        return false;
    });
    
    
    //Скрипт для работы кнопки Больше проектов
    var $set = $('.tabs_project_list li');
    $(".tabs_project_list li").click(function() {
    
    
    
        var realLi = $set.index(this) + 1; 
        var Tnumber = '#T'+ realLi; // определили на какой блок ID соответсвует этому пункту меню
        var countItems = $( Tnumber + ' .tabs_container__item:not(:visible)').length; //вынимаем кол-во блоков в нужной вкладке
        var buttonMore = $( Tnumber + ' .show_more').length; //знает есть ли в текущей вкладке ссылка
    
        if (countItems>0 & Tnumber !="#T1" & buttonMore<1) {
    
            $( Tnumber + ' .point_enter').append("<a class='show_more' href='#none'><img src='/wp-content/themes/s-a-ricci/img/arrow-pointing-to-right.png' alt='arrow'> Больше проектов</a>");
        } else if (buttonMore<1) {
            $('.main_content').css('padding-bottom', '75px')
        }
    //то что делаем по клику на кнопку Больше проектов
        $( Tnumber + ' .show_more').click(function(){
            $(Tnumber).find(".tabs_container__item:not(:visible):lt(3)").slideToggle('slow',function() {
        
                if ($(Tnumber).find(".tabs_container__item:not(:visible)").length==0) {
                    $( Tnumber + ' .show_more').css("display","none"); //скрыть существующую кнопку
                    $('.main_content').css('padding-bottom', '75px')
                                    
                            } else {
                                $( Tnumber + ' .show_more').css("display","none"); //скрыть существующую кнопку
                            }
                    }
            );
            return false;
        });
    
     });
    
     //Больше проектов
    
     //Проверяем 1 вкладку
    
     if ($('#T1').find(".tabs_container__item:not(:visible)").length>0) {
        $("#T1 .point_enter").append("<a class='show_more t1' href='#none'><img src='/wp-content/themes/s-a-ricci/img/arrow-pointing-to-right.png' alt='arrow'> Больше проектов</a>");
     } 
    
     $("#T1 .show_more").click(function(){
        $('#T1').find(".tabs_container__item:not(:visible):lt(3)").slideToggle('slow',function() {
    
            if ($('#T1').find(".tabs_container__item:not(:visible)").length==0) {
            $("#T1 .show_more").css("display","none");
                                
                        }
                }
        );
        return false;
    });
     



    });
    