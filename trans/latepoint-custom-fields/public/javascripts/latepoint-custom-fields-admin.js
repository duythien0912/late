!function(e){"use strict";function t(){var t=e(".os-default-fields"),s=t.find("form").serialize(),o={action:"latepoint_route_call",route_name:t.data("route"),params:s,return_format:"json"};e.ajax({type:"post",dataType:"json",url:latepoint_helper.ajaxurl,data:o,success:function(e){}})}e((function(){e('.os-default-field input[type="checkbox"], .os-default-field select').on("change",(function(){t()})),e(".os-default-field .os-toggler").on("ostoggler:toggle",(function(){e(this).hasClass("off")?e(this).closest(".os-default-field").addClass("is-disabled"):e(this).closest(".os-default-field").removeClass("is-disabled"),t()}))}))}(jQuery);