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

  document.getElementById("loginBtn").addEventListener("click", function() {
    showLoginPopup();
  });

  document.querySelector("#loginSection button[onclick='hideLoginPopup()']").addEventListener("click", function() {
    hideLoginPopup();
  });
});

function searchRooms() {
  const checkIn = document.getElementById('check-in').value;
  const checkOut = document.getElementById('check-out').value;
  const rooms = document.getElementById('rooms').value;

  const roomElements = document.querySelectorAll('.room-info');
  roomElements.forEach(room => {
    const roomCount = room.getAttribute('data-rooms');

    if (parseInt(rooms) == parseInt(roomCount)) {
      room.style.display = 'flex'; // Display matching rooms
    } else {
      room.style.display = 'none'; // Hide non-matching rooms
    }
  });
}

// Fungsi untuk menampilkan pop-up login dan overlay
function showLoginPopup() {
  var loginSection = document.getElementById("loginSection");
  var overlay = document.getElementById("overlay");
  loginSection.classList.add("active");
  overlay.style.display = "block";
}

// Fungsi untuk menyembunyikan pop-up login dan overlay
function hideLoginPopup() {
  var loginSection = document.getElementById("loginSection");
  var overlay = document.getElementById("overlay");
  loginSection.classList.remove("active");
  overlay.style.display = "none";
}

document.addEventListener('DOMContentLoaded', function() {
  // Tambahkan event listener untuk tombol login
  document.getElementById("loginBtn").addEventListener("click", function() {
    showLoginPopup();
  });

  // Tambahkan event listener untuk tombol close
  document.querySelector("#loginSection button[onclick='hideLoginPopup()']").addEventListener("click", function() {
    hideLoginPopup();
  });
});
// Fungsi untuk menampilkan pop-up login dan overlay
function showLoginPopup() {
  var loginSection = document.getElementById("loginSection");
  var overlay = document.getElementById("overlay");
  loginSection.classList.add("active");
  overlay.style.display = "block";
}

// Fungsi untuk menyembunyikan pop-up login dan overlay
function hideLoginPopup() {
  var loginSection = document.getElementById("loginSection");
  var overlay = document.getElementById("overlay");
  loginSection.classList.remove("active");
  overlay.style.display = "none";
}

document.addEventListener('DOMContentLoaded', function() {
  // Tambahkan event listener untuk tombol login
  document.getElementById("loginBtn").addEventListener("click", function() {
    showLoginPopup();
  });
});
function handleSearch() {
  const checkIn = document.getElementById('check-in').value;
  const checkOut = document.getElementById('check-out').value;
  const rooms = document.getElementById('rooms').value;

  const queryString = `?checkIn=${checkIn}&checkOut=${checkOut}&rooms=${rooms}`;
  window.location.href = `results.html${queryString}`;
}
function handleSearch() {
  const checkIn = document.getElementById('check-in').value;
  const checkOut = document.getElementById('check-out').value;
  const rooms = document.getElementById('rooms').value;

  const queryString = `?checkIn=${checkIn}&checkOut=${checkOut}&rooms=${rooms}`;
  window.location.href = `Search.html${queryString}`;
}