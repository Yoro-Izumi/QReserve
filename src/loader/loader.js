// // script.js
// window.addEventListener("load", () => {
//   // Minimum time the preloader should be visible (in milliseconds)
//   const minimumLoadTime = 1000; // 2 seconds

//   // Record the start time when the page starts loading
//   const startTime = new Date().getTime();

//   // Function to hide the preloader
//   const hidePreloader = () => {
//     const preloader = document.getElementById("preloader");
//     const content = document.getElementById("content");

//     preloader.style.display = "none";
//     content.style.display = "block";
//   };

//   // Calculate the time elapsed since the start
//   const timeElapsed = new Date().getTime() - startTime;

//   // If the time elapsed is less than the minimum load time, delay hiding the preloader
//   if (timeElapsed < minimumLoadTime) {
//     setTimeout(hidePreloader, minimumLoadTime - timeElapsed);
//   } else {
//     hidePreloader();
//   }
// });

// script.js
window.addEventListener('load', () => {
    const preloader = document.getElementById('preloader');
    const content = document.getElementById('content');

    preloader.style.display = 'none';
    content.style.display = 'block';
});
