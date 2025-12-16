var i=0;
var imgArray = [
    "cupcakes.jpg",
    "bluess.jpg",
    "papaya.jpg"
];
function ndrroImg(){
    document.getElementById('slideshow').src=imgArray[i];
    i=(i+1)%imgArray.length
}