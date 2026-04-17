<script>
let slides=document.querySelectorAll('.slide');
let index=0;

function showSlide(i){
    slides.forEach(slide=>slide.classList.remove('active'));
    slides[i].classList.add('active');
}

function nextSlide(){
    index=(index+1)%slides.length;
    showSlide(index);
}

function prevSlide(){
    index=(index-1+slides.length)%slides.length;
    showSlide(index);
}

// AUTO SLIDE
setInterval(nextSlide,4000);

function goToOrder(){
    window.location.href='order.php';
}
</script>