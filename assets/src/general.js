document.addEventListener('DOMContentLoaded', function () {
  // Preloader logic
  const hidePreloader = () => { document.body.classList.add('loaded'); };
  window.addEventListener('load', () => { setTimeout(hidePreloader, 600); });
  setTimeout(hidePreloader, 3000); // Fallback

  // ── Sidebar logic
  const cartTrigger = document.getElementById('cartTrigger');
  const mobileCartTrigger = document.getElementById('mobileCartTrigger');
  const closeCart = document.getElementById('closeCart');
  const cartSidebar = document.getElementById('cartSidebar');
  const cartOverlay = document.getElementById('cartOverlay');

  // ── Mobile Megamenu Toggle
  const megaDropdown = document.querySelector('.has-megamenu .dropdown-toggle');
  if (megaDropdown) {
    megaDropdown.addEventListener('click', function (e) {
      if (window.innerWidth < 992) {
        e.preventDefault();
        this.parentElement.classList.toggle('active');
        const menu = this.nextElementSibling;
        if (menu) menu.style.display = (menu.style.display === 'block') ? 'none' : 'block';
      }
    });
  }

  // ── Cart sidebar toggle function
  const toggleCart = () => {
    if (!cartSidebar || !cartOverlay) return;
    cartSidebar.classList.toggle('open');
    cartOverlay.classList.toggle('active');
    document.body.style.overflow = cartSidebar.classList.contains('open') ? 'hidden' : '';
  };
  window.toggleCart = toggleCart; // Keep global for external calls if needed

  if (cartTrigger) cartTrigger.addEventListener('click', toggleCart);
  if (mobileCartTrigger) mobileCartTrigger.addEventListener('click', toggleCart);
  if (closeCart) closeCart.addEventListener('click', toggleCart);
  if (cartOverlay) cartOverlay.addEventListener('click', toggleCart);

  // ── Navbar scroll shadow (Throttled)
  const nav = document.getElementById('mainNav');
  const backTop = document.getElementById('backTop');
  let scrollTimer;

  window.addEventListener('scroll', () => {
    if (scrollTimer) return;
    scrollTimer = requestAnimationFrame(() => {
      if (nav) nav.classList.toggle('scrolled', window.scrollY > 30);
      if (backTop) backTop.classList.toggle('show', window.scrollY > 400);
      scrollTimer = null;
    });
  });

  // ── Scroll reveal with Animate.css
  const revealEls = document.querySelectorAll('.reveal, .reveal-left, .reveal-right');
  if (revealEls.length > 0) {
    const observer = new IntersectionObserver((entries) => {
      entries.forEach(e => {
        if (e.isIntersecting) {
          const el = e.target;
          const animation = el.dataset.animation || 'animate__fadeInUp';
          el.classList.add('animate__animated', animation);
          el.classList.add('visible');
          el.style.opacity = '1';
          observer.unobserve(el);
        }
      });
    }, { threshold: 0.1 });
    revealEls.forEach(el => observer.observe(el));
  }

  // ── Cart button feedback
  document.querySelectorAll('.btn-cart').forEach(btn => {
    btn.addEventListener('click', function (e) {
      const originalContent = this.innerHTML;
      this.textContent = '✓ Added!';
      this.classList.add('btn-success');
      setTimeout(() => {
        this.innerHTML = originalContent;
        this.classList.remove('btn-success');
      }, 1500);
    });
  });
});