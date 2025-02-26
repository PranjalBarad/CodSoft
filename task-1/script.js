const images=["h1.jpg","h2.jpg","h3.jpg","h4.jpg","h5.jpg","h6.jpg","h7.jpg"];
let index=0;
function ChangeImg(){
    index=(index+1) % images.length;
    document.getElementById("himg").src=images[index];
}
setInterval(ChangeImg,3000)