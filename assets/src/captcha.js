document.addEventListener('DOMContentLoaded', function () { 
    // ── CAPTCHA logic
    window.generateCaptcha = function () {
        const chars = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        let code = '';
        for (let i = 0; i < 5; i++) {
            code += chars.charAt(Math.floor(Math.random() * chars.length));
        }
        const codeEl = document.getElementById('captchaCode');
        if (codeEl) codeEl.textContent = code;
        const hiddenEl = document.getElementById('captchaGenerated');
        if (hiddenEl) hiddenEl.value = code;
        const inputEl = document.getElementById('captchaInput');
        if (inputEl) inputEl.value = '';
        const errorEl = document.getElementById('captchaError');
        if (errorEl) errorEl.style.display = 'none';
    };

    // Initialize captcha on load
    generateCaptcha();

    // contact form
    const contactForm = document.querySelector('form.wpcf7-form');
    if (contactForm) {
        contactForm.addEventListener('submit', function (e) {
            const codeEl = document.getElementById('captchaCode');
            const inputEl = document.getElementById('captchaInput');
            if (!codeEl || !inputEl) return;

            const code = codeEl.textContent;
            const input = inputEl.value;
            if (input.toUpperCase() !== code) {
                e.preventDefault();
                const errorEl = document.getElementById('captchaError');
                if (errorEl) errorEl.style.display = 'block';
                generateCaptcha();
                return;
            }
            // If correct, let it submit (or mock it)
            e.preventDefault();
            //alert('Message sent successfully!');
            this.reset();
            generateCaptcha();
        });
    }

    // product review form
    /*
    const reviewForm = document.querySelector('#tab-reviews form');
    if (reviewForm) {
      reviewForm.addEventListener('submit', function (e) {
        const codeEl = document.getElementById('captchaCode');
        const inputEl = document.getElementById('captchaInput');
        if (!codeEl || !inputEl) return;
  
        const code = codeEl.textContent;
        const input = inputEl.value;
        if (input.toUpperCase() !== code) {
          e.preventDefault();
          const errorEl = document.getElementById('captchaError');
          if (errorEl) errorEl.style.display = 'block';
          generateCaptcha();
          return;
        }
        // If correct, let it submit (or mock it)
        e.preventDefault();
        alert('Review submitted for moderation!');
        this.reset();
        generateCaptcha();
      });
    }
    */
    const reviewForm = document.querySelector('#tab-reviews form.reviewform');
    if (reviewForm) {
      reviewForm.addEventListener('submit', function (e) {
        const codeEl = document.getElementById('captchaCode');
        const inputEl = document.getElementById('captchaInput');
        if (!codeEl || !inputEl) return;
        const code = codeEl.textContent.trim();
        const input = inputEl.value.trim().toUpperCase();
        const errorEl = document.getElementById('captchaError'); 
        if (input !== code) {
          e.preventDefault();
          generateCaptcha();
          if (errorEl) {
            errorEl.style.display = 'block';
            errorEl.textContent = 'Incorrect CAPTCHA';
          }
          //generateCaptcha();
          return;
        }
        if (errorEl) errorEl.style.display = 'none';
      });
    }

});