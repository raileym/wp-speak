/* See https://stackoverflow.com/questions/5292372/how-to-pass-parameters-to-a-script-tag */
    
(function($) {

    var id = 'ctns_speak_' + Math.floor(Math.random() * Math.floor(1000000)),
        text = document.currentScript.getAttribute('text') || "Welcome to Site Prep Guides for math";

    document.write("<span id='"+id+"' class='ctns-speak-control'><i class='fas fa-microphone'></i></span>");

    $("#"+id).on("click", (function(text) {
    
        return function() {
            if ( ! jQuery(this).hasClass("ctns-selected") ) {
                $(this).addClass("ctns-selected");
            }

            window.CTNS.PROBLEMS.audio_onDemand(text);
        };
        
        })(text)
        
    );

})(jQuery);
