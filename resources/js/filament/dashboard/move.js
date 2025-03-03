document.getElementById('scroll').addEventListener('click', function () {
    const targetSection = document.getElementById('event');
    targetSection.scrollIntoView({ behavior: 'smooth' });
  });
  
const slides = document.querySelector('.slides');
const indicators = document.querySelectorAll('.indicator');
let currentIndex = 0;

const updateCarousel = () => {
    slides.style.transform = `translateX(-${currentIndex * 100}%)`;
    indicators.forEach((indicator, index) => {
        indicator.classList.toggle('bg-[#fff]', index === currentIndex);
        indicator.classList.toggle('bg-gray-300', index !== currentIndex);
    });
};

indicators.forEach((indicator, index) => {
    indicator.addEventListener('click', () => {
        currentIndex = index;
        updateCarousel();
    });
});

const autoScroll = () => {
    currentIndex = (currentIndex + 1) % indicators.length;
    updateCarousel();
};

setInterval(autoScroll, 5000); 


let judul = document.getElementById('caption')[0];
// let dikit = document.getElementsByClassName('dikit')[0];


window.addEventListener('scroll', function () {
    let value = window.scrollY;

    caption.style.marginBottom = value * 0.5 + 'px';
    // dikit.style.marginBottom = value * 0.5 + 'px';


});

$(document).ready(function() {
    // Initialize datepicker
    $('#datepicker').datepicker({
        format: 'yyyy-mm-dd',
        autoclose: true,
        todayHighlight: true,
        clearBtn: true,
        zIndexOffset: 1000
    });

    // Add event listener for form submission
    $('form').on('submit', function() {
        let date = $('#datepicker').val();
        if (date) {
            $(this).find('input[name="tanggal"]').val(date);
        }
    });
});

