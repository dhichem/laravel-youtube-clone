var player = videojs('video');
var viewCounted = false; 

player.on('timeupdate', function () {
    var duration = player.duration();
    var currentTime = player.currentTime();
    
    if (duration >= 10) {
        // Count the view after 10 seconds of watching
        if (currentTime > 10 && !viewCounted) {
            viewCounted = true;
            window.axios.put(`/videos/${window.CURRENT_VIDEO}`)
        }
    } else if (duration < 10 && duration != 0) {
        // For videos shorter than 10 seconds, count the view at the end
        if (currentTime >= duration && !viewCounted) {
            console.log('ddddd', currentTime, player.currentTime())
            viewCounted = true;
            window.axios.put(`/videos/${window.CURRENT_VIDEO}`)
        }
    }
});

function countView() {
    
}