$(document).ready(function() {
    $('#loginBtn').click(function(e) {
      e.preventDefault();
      $('#loginSection').toggleClass('active');
    });
  });
  
  document.addEventListener('DOMContentLoaded', function() {
    const lightboxTrigger = document.querySelectorAll('.lightbox-trigger');
    const lightbox = document.querySelector('.lightbox');
  
    lightboxTrigger.forEach(function(trigger) {
      trigger.addEventListener('click', function() {
        const imageSrc = this.getAttribute('src');
        const lightboxImage = lightbox.querySelector('.lightbox-image');
        lightboxImage.setAttribute('src', imageSrc);
        lightbox.style.display = 'block';
      });
    });
  
    lightbox.addEventListener('click', function(e) {
      if (e.target === this) {
        this.style.display = 'none';
      }
    });
  });
  document.addEventListener('DOMContentLoaded', function() {
    const lightboxTriggers = document.querySelectorAll('.lightbox-trigger');
    const lightbox = document.querySelector('.lightbox');
    const lightboxImage = lightbox.querySelector('.lightbox-image');
    const prev = lightbox.querySelector('.prev');
    const next = lightbox.querySelector('.next');
  
    let currentIndex = 0;
    let images = [];
  
    lightboxTriggers.forEach(function(trigger, index) {
      images.push({
        src: trigger.getAttribute('src'),
        alt: trigger.getAttribute('alt')
      });
  
      trigger.addEventListener('click', function() {
        currentIndex = index;
        showImage(currentIndex);
        lightbox.style.display = 'flex';
      });
    });
  
    function showImage(index) {
      lightboxImage.setAttribute('src', images[index].src);
      lightboxImage.setAttribute('alt', images[index].alt);
    }
  
    prev.addEventListener('click', function() {
      currentIndex = (currentIndex === 0) ? images.length - 1 : currentIndex - 1;
      showImage(currentIndex);
    });
  
    next.addEventListener('click', function() {
      currentIndex = (currentIndex === images.length - 1) ? 0 : currentIndex + 1;
      showImage(currentIndex);
    });
  
    lightbox.addEventListener('click', function(e) {
      if (e.target === this || e.target === lightboxImage) {
        this.style.display = 'none';
      }
    });
  });
  
  document.addEventListener('DOMContentLoaded', function() {
    const lightboxTriggers = document.querySelectorAll('.lightbox-trigger');
    const lightbox = document.querySelector('.lightbox');
    const lightboxImage = lightbox.querySelector('.lightbox-image');
  
    lightboxTriggers.forEach(function(trigger) {
      trigger.addEventListener('click', function() {
        const imageSrc = this.getAttribute('src');
        lightboxImage.setAttribute('src', imageSrc);
        lightbox.style.display = 'flex';
      });
    });
  
    lightbox.addEventListener('click', function(e) {
      if (e.target === this) {
        this.style.display = 'none';
      }
    });
  });
  
  document.addEventListener('DOMContentLoaded', function() {
    const loginSection = document.getElementById('loginSection');
    const blurBackgroundClass = 'blur-background';
  
    loginSection.addEventListener('click', function() {
      document.body.classList.add(blurBackgroundClass);
    });
  });
  