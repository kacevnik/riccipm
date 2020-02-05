(function($){
    if(typeof ajaxurl == "undefined"){
        ajaxurl = wpmflang.ajaxurl;
    }
    $(document).ready(function(){
        $(document).on('click', '.wpmf_btn_duplicate', function (event) {
            $('.wpmf_spinner_duplicate').show().css('visibility','visible');
            $('.wpmf_message_duplicate').html(null);
            var id = $('.attachment-details').data('id');
            if(typeof id != 'undefined'){
                $.ajax({
                    method : 'post',
                    url : ajaxurl,
                    dataType : 'json',
                    data : {
                        action : 'wpmf_duplicate_file',
                        id : id
                    },
                    success : function(res){
                        $('.wpmf_spinner_duplicate').hide();
                        if(res.status == true){
                            $('.wpmf_message_duplicate').html('<div class="updated">'+ res.message + '</div>');
                        }else{
                            $('.wpmf_message_duplicate').html('<div class="error">'+ res.message + '</div>');
                        }
                        
                        if(page != 'table' && wpmflang.wpmf_pagenow != 'upload.php'){
                            setTimeout(function(){
                                wp.Uploader.queue.reset();
                            },1000);
                            
                        }
                    }
                });
            }
        });
    });
}(jQuery));