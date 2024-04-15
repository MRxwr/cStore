document.addEventListener("DOMContentLoaded", function() {
    // Hide loading screen when everything is loaded
    window.addEventListener("load", function() {
        var loadingScreen = document.querySelector(".loading-screen");
        var content = document.getElementById("content");
        
        if (loadingScreen !== null) {
            loadingScreen.style.display = "none";
        }
        
        if (content !== null) {
            content.style.display = "block"; // Show the content
        }
    });
});