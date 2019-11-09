// (function(){
//    navigator.getUserMedia = navigator.getUserMedia ||
//                             navigator.webkitGetUserMedia ||
//                             navigator.mozGetUserMedia;
   
//    if (navigator.getUserMedia) {
//       navigator.getUserMedia({ audio: false, video: { width: 1280, height: 720 } },
//          function(stream) {
//             var video = document.querySelector('video'),
//                canvas = document.getElementById('canvas'),
//                context = canvsa.getContext('2d');
//             video.srcObject = stream;
//             video.onloadedmetadata = function(e) {
//               video.play();
//             };
//          },
//          function(err) {
//             console.log("The following error occurred: " + err.name);
//          }
//       );
//    } else {
//       console.log("getUserMedia not supported");
//    }

//    document.getElementById('capture').addEventListener('click', function(){
//       context.drawImage(video,0,0,400,300);
//    });
//  })();

navigator.getUserMedia = navigator.getUserMedia ||
                         navigator.webkitGetUserMedia ||
                         navigator.mozGetUserMedia;

if (navigator.getUserMedia) {
   navigator.getUserMedia({ audio: false, video: { width: 1280, height: 720 } },
      function(stream) {
         var video = document.querySelector('video');
         // var canvas = document.getElementById('canvas');
         // var context = canvsa.getContext('2d');
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