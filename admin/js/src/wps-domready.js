var $        = require('jquery'),
    jplayer  = require('jplayer');

$( document ).ready(function() {

    $("<div id='jquery_jplayer'></div>").prependTo("body");

    $("#jquery_jplayer").jPlayer({
        ready: function() {
            $(this).jPlayer("setMedia", {
                mp3: null // "/audio/no_response.mp3"
            });
        },
        swfPath: "/js"
    });
    

    
    
    
    $( "div.wps-notices").addClass("wps-hide");
    $( "textarea.wps-notices").addClass("wps-hide");

    var notice = $("input.wps-notices:checked").val();
    $("#"+notice).removeClass("wps-hide");
    



    $.each( WPS.localize.images, function(key, value) {
    
        var hit = $(key);
        
        var html =  "<a class='wps-audio' aria-label='Play Alt Text'>";
            html += "<i title='Speak the \'Alt Text\'.' class='fa fa-microphone' aria-hidden='true'>";
            html += "<span>";
            html += value;
            html += "</span></i>";

        $(html).insertAfter(key);
        
    });
    
    $('.wps-audio').on('click', function(e) {
        if (!e) {
            e = window.event;
        }
        
        if (e.stopPropagation) {
            /* IE9 & Other Browsers */
            e.stopPropagation();
        } else {
            /* IE8 and Lower */
            e.cancelBubble = true;
        }

        e.preventDefault();
        
        var text = $(this).text().trim();
        
        var textarea_id = $(this).attr("textarea-id");
        if ( typeof $(this).attr("textarea-id") !== typeof undefined && textarea_id !== false ) {
            text = $("#"+textarea_id).val();
        }
        
        if ( ! $(this).hasClass("wps-selected") ) {
            $(this).addClass("wps-selected");
        }

        WPS.PROBLEMS.audio_onDemand(text, 'wps');
    });
    
    $("input.wps-radio").change(function() {
        var cnt = $(this).attr('wps-cnt');
        
        $( ".wps-audio-choice.wps-"+cnt).removeClass("wps-selected");
    
        if (this.value == 'use_img_attr_alt') {
            $( ".wps-audio-choice.wps-img-attr-alt.wps-"+cnt ).addClass("wps-selected");
        }
        else if (this.value == 'use_img_alt') {
            $( ".wps-audio-choice.wps-img-alt.wps-"+cnt ).addClass("wps-selected");
        }
        else if (this.value == 'use_image_alt') {
            $( ".wps-audio-choice.wps-image-alt.wps-"+cnt ).addClass("wps-selected");
        }
    })
    

});


