$(document).ready(function() {
    var mousetimeout;
    var screensaver_active = false;
    var idletime = 20;
    
    function show_screensaver(){
        $('#screensaver').fadeIn();
        $('#content').addClass('hidden');
        screensaver_active = true;
        screensaver_animation();
    }
    
    function stop_screensaver(){
        $('#screensaver').fadeOut();
        $('#content').removeClass('hidden');
        screensaver_active = false;
    }
    
    function getRandomColor() {
        var letters = '0123456789ABCDEF'.split('');
        var color = '#';
        for (var i = 0; i < 6; i++ ) {
            color += letters[Math.round(Math.random() * 15)];
        }
        return color;
    }
    
    $(document).click(function(){
        clearTimeout(mousetimeout);
        
        if (screensaver_active) {
            stop_screensaver();
            $("#content").removeClass('hidden')
        }
    
        mousetimeout = setTimeout(function(){
            show_screensaver();
            $("#content").addClass('hidden')
        }, 500 * idletime);			
    });
    
    $(document).mousemove(function(){
        clearTimeout(mousetimeout); 
    
        mousetimeout = setTimeout(function(){
            show_screensaver();
        }, 1000 * idletime); // 5 secs			
    });
    
    function screensaver_animation(){
        if (screensaver_active) {
            $('#screensaver').animate(
                {backgroundColor: getRandomColor()},
                400,
                screensaver_animation);
        }
    }
});