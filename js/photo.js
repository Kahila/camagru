// (function(){
//     var video = document.getElementById('video'),
//     vendorUrl = window.URL || window.webkitURL;
//     navigator.getMedia = navigator.getUserMedia ||
//                             navigator.webkitGetUserMedia ||
//                             navigator.mozGetUserMedia;

//     navigator.getMedia({
//         video:true,
//         audio: false
//     }, function(self) {
//         video.src = vendorUrl.createObjectURL(self);
//         video.play();
//     }, function(error){
//         //an error
//         //error code
//     });
// })();

navigator.getUserMedia = navigator.getUserMedia ||
                         navigator.webkitGetUserMedia ||
                         navigator.mozGetUserMedia;

if (navigator.getUserMedia) {
   navigator.getUserMedia({ audio: false, video: { width: 1280, height: 720 } },
      function(stream) {
         var video = document.querySelector('video');
         video.srcObject = stream;
         video.onloadedmetadata = function(e) {
           video.play();
         };
      },
      function(err) {
         console.log("The following error occurred: " + err.name);
      }
   );
} else {
   console.log("getUserMedia not supported");
}