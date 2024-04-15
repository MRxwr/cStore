document.addEventListener("DOMContentLoaded", function() {
    var loadingScreen = document.querySelector(".loading-screen");
    var content = document.getElementById("content");

    // Hide loading screen when everything is loaded
    function hideLoadingScreen() {
        if (loadingScreen !== null) {
            loadingScreen.style.display = "none";
        }
        if (content !== null) {
            content.style.display = "block"; // Show the content
        }
    }

    window.addEventListener("load", hideLoadingScreen);

    // Function to show loading screen
    function showLoadingScreen() {
        if (loadingScreen !== null) {
            loadingScreen.style.display = "flex"; // Show loading screen
        }
        if (content !== null) {
            content.style.display = "none"; // Hide content
        }
    }

    // Add event listeners to all clickable elements on the page
    var clickableElements = document.querySelectorAll("a, button, input[type='button'], input[type='submit']");
    if (clickableElements.length > 0) {
        clickableElements.forEach(function(element) {
            element.addEventListener("click", function(event) {
                // Check if the element is a link (<a>) and has an href attribute
                if (element.tagName.toLowerCase() === "a" && element.getAttribute("href")) {
                    // Check if the link is not an anchor link (starts with "#")
                    if (!element.getAttribute("href").startsWith("#")) {
                        showLoadingScreen();
                    }
                }
                // If the element is not a link or doesn't have an href attribute, show loading screen
                else {
                    showLoadingScreen();
                }
            });
        });
    }
});
