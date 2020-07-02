var $        = require('jquery'),
    NUMBERS  = require('wps-numbers').default,
    MD5      = require('md5');

var PROBLEMS = {};
    

PROBLEMS.audio_onDemand = function(text, key) {

    var speak_words = text;

    var speak_file = key + "-" + MD5.hex_md5(speak_words);

    // see https://jonsuh.com/blog/jquery-ajax-call-to-php-script-with-json-return/
    $.ajax({
        url: WPS.localize.ajax.url, // where to submit the data
        type:"POST",
        dataType: "json",
        data: {
            action : 'wps_speak',
            file   : speak_file,
            words  : speak_words,
            audio  : WPS.localize.ajax.audio
        },
        success: function(data) {
            var my_data = "Stop Here";

            $("#jquery_jplayer").jPlayer("setMedia", {
                mp3: data.mp3
            }).jPlayer("play");
        },
        error: function(XMLHttpRequest, textStatus, errorThrown) { 
          var my_data = "Stop Here";
        }  				
    });
};
    
PROBLEMS.audio_inline_onDemand = (function(numbers, problems) {

    return function(text) {
    
        var id = 'wps_speak_' + numbers.getRandomInt(1000000),
            results;
            
        $("body").on("click", "#"+id, (function(problems, text) {

            return function() {
                if ( ! $(this).hasClass("wps-selected") ) {
                    $(this).addClass("wps-selected");
                }

                problems.audio_onDemand(text);
            };
        
        })(problems, text));
        
        
        return "<span id='"+id+"' class='wps-speak-control'><i class='fas fa-microphone'></i></span>";
    
    };
    
})(NUMBERS, PROBLEMS);
        
global.WPS.PROBLEMS = PROBLEMS;

export default PROBLEMS;
