document.addEventListener('DOMContentLoaded', function () {

  // ── Reveal animations
  const obs = new IntersectionObserver(entries => {
    entries.forEach(e => {
      if (e.isIntersecting) {
        e.target.classList.add('visible');
        obs.unobserve(e.target);
      }
    });
  }, { threshold: .1 });
  document.querySelectorAll('.reveal, .reveal-left, .reveal-right').forEach(el => obs.observe(el));

  // ── Page Loader
  window.addEventListener('load', () => {
    setTimeout(() => {
      document.body.classList.add('loaded');
    }, 600);
  });

  // ── GLightbox initialization
  window.lightbox = GLightbox({ selector: '.glightbox' });

  // ── Hover to zoom "follow mouse" effect
  const wrap = document.getElementById('mainImgWrap');
  const img = document.getElementById('mainImg');
  if (wrap && img) {
    wrap.addEventListener('mousemove', (e) => {
      const { left, top, width, height } = wrap.getBoundingClientRect();
      const x = ((e.pageX - left - window.scrollX) / width) * 100;
      const y = ((e.pageY - top - window.scrollY) / height) * 100;
      img.style.transformOrigin = `${x}% ${y}%`;
    });
    wrap.addEventListener('mouseleave', () => {
      img.style.transformOrigin = 'center center';
    });
  }

  // ── Gallery Switch
  window.switchImg = function (thumb, src) {
    const img = document.getElementById('mainImg');
    const link = document.getElementById('mainImgLink');
    if (!img) return;

    document.querySelectorAll('.thumb').forEach(t => t.classList.remove('active'));
    thumb.classList.add('active');

    img.classList.add('switching');
    setTimeout(() => {
      img.src = src;
      if (link) link.href = src;
      if (window.lightbox) window.lightbox.reload();
      img.classList.remove('switching');
    }, 250);
  };

  // ── Tabs
  window.switchTab = function (btn, panelId) {
    document.querySelectorAll('.tab-btn').forEach(b => b.classList.remove('active'));
    document.querySelectorAll('.tab-panel').forEach(p => p.classList.remove('active'));
    btn.classList.add('active');
    document.getElementById(panelId).classList.add('active');
  };

  // ── Qty
  window.changeQty = function (d) {
    const i = document.getElementById('qtyInput');
    i.value = Math.max(1, +i.value + d);
  };

  // ── Wishlist
  window.toggleWish = function () {
    const b = document.getElementById('wishBtn'), ic = document.getElementById('wishIcon');
    b.classList.toggle('active');
    ic.className = b.classList.contains('active') ? 'bi bi-heart-fill' : 'bi bi-heart';
  };

  // ── Add to Cart
  window.handleCart = function () {
    const b = document.getElementById('cartBtn');
    const original = b.innerHTML;
    b.classList.add('added');
    b.innerHTML = '<i class="bi bi-check-lg me-2"></i>Added!';
    setTimeout(() => {
      b.classList.remove('added');
      b.innerHTML = original;
    }, 2000);
  };

  /* phone number validation */
  const phoneInput = document.querySelector('.reviewform input[name="phone"]');
  if (phoneInput) {
    phoneInput.addEventListener('input', function () {
      this.value = this.value.replace(/[^0-9+\-]/g, '');
    });
  }

  /* star rating */
  const stars = document.querySelectorAll('#ratingStars span');
  const ratingInput = document.getElementById('ratingValue');
  if(ratingInput) {
    function setRating(value) {
      ratingInput.value = value;
    
      stars.forEach((star, index) => {
        star.classList.toggle('active', index < value);
      });
    }
    stars.forEach((star, index) => {
      star.addEventListener('click', () => {
        setRating(index + 1);
      });
    });
    setRating(5); // set default
  }

});

function addCart(btn) {
  const originalContent = btn.innerHTML;
  btn.innerHTML = '<i class="bi bi-check-lg me-1"></i>Added!';
  btn.classList.add('added');
  setTimeout(() => { btn.innerHTML = originalContent; btn.classList.remove('added'); }, 1600);
}