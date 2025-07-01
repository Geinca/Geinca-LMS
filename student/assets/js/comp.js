document.addEventListener("DOMContentLoaded", function () {
    fetch("components/footer.html")
        .then(response => response.text())
        .then(data => {
            document.getElementById("footer").innerHTML = data;

        })
        .catch(error => console.error("Error loading the header:", error));
});


document.addEventListener("DOMContentLoaded", function () {
    fetch("components/hero.html")
        .then(response => response.text())
        .then(data => {
            document.getElementById("hero").innerHTML = data;

        })
        .catch(error => console.error("Error loading the header:", error));
});
document.addEventListener("DOMContentLoaded", function () {
    fetch("components/stats.html")
        .then(response => response.text())
        .then(data => {
            document.getElementById("stats").innerHTML = data;

        })
        .catch(error => console.error("Error loading the header:", error));
});

document.addEventListener("DOMContentLoaded", function () {
    fetch("components/testimonial.html")
        .then(response => response.text())
        .then(data => {
            document.getElementById("test").innerHTML = data;
             const cards = document.querySelectorAll('.review-card');
    const dots = document.querySelectorAll('.review-dot');
    const nextBtn = document.querySelector('.review-next');
    const prevBtn = document.querySelector('.review-prev');
    let currentIndex = 0;

    function updateSlider(index) {
      cards.forEach((card, i) => {
        card.classList.toggle('active', i === index);
      });

      dots.forEach((dot, i) => {
        dot.classList.toggle('active', i === index);
      });
    }

    nextBtn.addEventListener('click', () => {
      currentIndex = (currentIndex + 1) % cards.length;
      updateSlider(currentIndex);
    });

    prevBtn.addEventListener('click', () => {
      currentIndex = (currentIndex - 1 + cards.length) % cards.length;
      updateSlider(currentIndex);
    });

    dots.forEach((dot, i) => {
      dot.addEventListener('click', () => {
        currentIndex = i;
        updateSlider(currentIndex);
      });
    });

    // Optional: Auto-slide every 6 seconds
    // setInterval(() => {
    //   currentIndex = (currentIndex + 1) % cards.length;
    //   updateSlider(currentIndex);
    // }, 6000);


        })
        .catch(error => console.error("Error loading the header:", error));
});




