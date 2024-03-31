// Function to reload the page
function reloadPage() {
    location.reload(); 
}

// Schedule the reload at the specified time
function scheduleReload(reloadTime) {
    var reloadDate = new Date(reloadTime); 
    var now = new Date();
    var timeUntilReload = reloadDate - now; 
    if (timeUntilReload < 0) {
        timeUntilReload += 24 * 60 * 60 * 1000; 
    }
        setTimeout(reloadPage, timeUntilReload); 
    }
scheduleReload('<?php echo $starttime; ?>');
 // Function to update the current time
    function updateCurrentTime() {
        var currentTime = new Date();
        var hours = currentTime.getHours();
        var minutes = currentTime.getMinutes();
        var seconds = currentTime.getSeconds();

        hours = (hours < 10 ? "0" : "") + hours;
        minutes = (minutes < 10 ? "0" : "") + minutes;
        seconds = (seconds < 10 ? "0" : "") + seconds;

        document.getElementById("currentTime").textContent = hours + ":" + minutes + ":" + seconds;
    }

    updateCurrentTime();

    // Update the current time every second
    setInterval(updateCurrentTime, 1000);

    function countdownTimer(endtime) {
            var endTime = new Date(endtime).getTime();
            
            var interval = setInterval(function() {
                var currentTime = new Date().getTime();
                var remainingTime = endTime - currentTime;

                if (remainingTime <= 0) {
                    clearInterval(interval);
                } else {
                    var seconds = Math.floor((remainingTime % (1000 * 60)) / 1000);
                    var minutes = Math.floor((remainingTime % (1000 * 60 * 60)) / (1000 * 60));
                    var hours = Math.floor((remainingTime % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                    document.getElementById('countdown').innerHTML = hours + "h " + minutes + "m " + seconds + "s ";
                }
            }, 1000);
        }

    countdownTimer("<?php echo $formattedEndTime ?>");

// Define the function to auto-submit the form
function autoSubmitForm() {
    document.getElementById("myButton").click();
}

const currentTime = new Date();
const desiredTime = new Date("<?php echo $formattedEndTime; ?>"); 

const delay = desiredTime.getTime() - currentTime.getTime();

// Check if the desired time is in the future
if (delay > 0) {
    setTimeout(autoSubmitForm, delay);
}
// Function to run after the document has finished loading
    document.addEventListener("DOMContentLoaded", function() {
        const currentTime = new Date();
        const startTime = new Date("<?php echo $formattedstarttime; ?>");
        const endTime = new Date("<?php echo $formattedEndTime; ?>");

        if (currentTime >= startTime && currentTime <= endTime) {
            document.getElementById("category").style.display = "block"; 
            document.getElementById("message").style.display = "none"; 
        }
        else{
            document.getElementById("category").style.display = "none"; 
           document.getElementById("message").style.display = "block";
        }
    });