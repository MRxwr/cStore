document.addEventListener("DOMContentLoaded", function() {
    // Hide loading screen when everything is loaded
    window.addEventListener("load", function() {
        var loadingScreen = document.querySelector(".loading-screen");
        var content = document.getElementById("content");
        
        loadingScreen.style.display = "none";
        content.style.display = "block"; // Show the content
    });
});