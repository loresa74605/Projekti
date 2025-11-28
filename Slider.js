let index = 0;
const slider=document.getElementById("slider");
const slides=document.querySelectorAll(".slide");

function showSlide(i){
    index = (i+slides.length)%slides.length;
    slider.style.transform=`translateX(${-index*100}%)`
}
function nextSlide(){
    showSlide(index + 1);
}
function prevSlide(){
    showSlide(index - 1);
}
setInterval(()=>{
    nextSlide();
},10000)