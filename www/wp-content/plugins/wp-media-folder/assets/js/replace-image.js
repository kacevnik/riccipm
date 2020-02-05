/** 
 * We developed this code with our hearts and passion.
 * @package wp-media-folder
 * @copyright Copyright (C) 2014 JoomUnited (http://www.joomunited.com). All rights reserved.
 * @license GNU General Public License version 2 or later; http://www.gnu.org/licenses/gpl-2.0.html
 */

(function ($) {
    $(document).ready(function () {
        bindselectchange = function () {
            $(document).on('change', '#wpmf_upload_input_version', function (event) {
                jQuery('#wpmf_progress').hide();
                $('#wpmf_result').html(null);
                $('#wpmf_bar').width(0);
                $('#wpmf_percent').html('0%');
                if(typeof event.target.files[0] != "undefined"){
                    var type = event.target.files[0].type;
                    if(type.substr(0, 5) == 'image'){
                        var tmppath = URL.createObjectURL(event.target.files[0]);
                        $(".wpmf_img_replace").fadeIn("fast").attr('src', URL.createObjectURL(event.target.files[0]));
                    }
                }else{
                    $(".wpmf_img_replace").fadeOut("fast");
                }
            });
        }

        bindselectchange();
    });
}(jQuery));