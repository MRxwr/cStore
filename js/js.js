document.addEventListener("DOMContentLoaded", function() {
    var loadingScreen = document.querySelector(".loading-screen");
    var content = document.getElementById("content");

    // Function to hide loading screen
    function hideLoadingScreen() {
        if (loadingScreen !== null) {
            loadingScreen.style.display = "none";
        }
        if (content !== null) {
            content.style.display = "block"; // Show the content
        }
    }

    // Function to show loading screen
    function showLoadingScreen(backgroundColor) {
        if (loadingScreen !== null) {
            loadingScreen.style.display = "flex"; // Show loading screen
            var loader = document.querySelector(".loader");
            if (loader !== null) {
                loader.style.borderTopColor = backgroundColor; // Set spinner color
            }
        }
        if (content !== null) {
            content.style.display = "none"; // Hide content
        }
    }

    window.addEventListener("load", hideLoadingScreen);

    // Add event listeners to all clickable elements on the page
    var clickableElements = document.querySelectorAll("a, button, input[type='button'], input[type='submit']");
    if (clickableElements.length > 0) {
        clickableElements.forEach(function(element) {
            element.addEventListener("click", function(event) {
                // Check if the clicked element is a link (<a>) and has an href attribute
                if (element.tagName.toLowerCase() === "a" && element.getAttribute("href")) {
                    // Check if the link is not an anchor link (starts with "#")
                    if (!element.getAttribute("href").startsWith("#")) {
                        var header = document.querySelector(".header");
                        if (header !== null) {
                            var computedStyle = window.getComputedStyle(header);
                            var backgroundColor = computedStyle.backgroundColor;
                            showLoadingScreen(backgroundColor);
                        } else {
                            showLoadingScreen("#3498db"); // Default color if header is not found
                        }
                    }
                }
                // If the clicked element is not a link or doesn't have an href attribute, show loading screen
                else {
                    showLoadingScreen("#3498db"); // Default color for non-link elements
                }
            });
        });
    }
});
