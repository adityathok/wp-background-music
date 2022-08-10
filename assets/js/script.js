jQuery(function($) {    
    $( '.wpbgn-music-bubble-content-close' ).click(function(){
        $('.wpbgn-music-bubble').toggleClass('close');
    });  
    $( '.wpbgn-music-play' ).click(function(){
        var audiowpbgn = document.getElementById("wpbgn-music-audio");
        audiowpbgn.play();

        $('.wp-bgn-music').addClass('active');
        $('.wpbgn-music-bubble').addClass('close');

        //set cookie       
        var today = new Date();
        var expire = new Date();
        expire.setTime(today.getTime() + 3600000*24*14);
        const expires = "expires=" + expire.toUTCString();
        document.cookie = "audiowpbgn=true; " + expires + "; path=/";
    });
    // $( '.wp-bgn-music.active' ).ready(function(){
    //     var audiowpbgn = document.getElementById("wpbgn-music-audio");
    //     audiowpbgn.play();
    // });
});