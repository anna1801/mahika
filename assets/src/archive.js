document.addEventListener('DOMContentLoaded', function () {
  window.addCart = function (btn) {
    const originalContent = btn.innerHTML;
    btn.innerHTML = '<i class="bi bi-check-lg me-1"></i>Added!';
    btn.style.background = 'var(--green)';
    setTimeout(() => { btn.innerHTML = originalContent; btn.style.background = ''; }, 1600);
  };

  window.setView = function (v) {
    const grid = document.getElementById('productsGrid');
    const gb = document.getElementById('gridBtn'), lb = document.getElementById('listBtn');
    if (v === 'list') {
      grid.classList.add('list-view');
      grid.querySelectorAll('.col-product').forEach(c => { c.classList.remove('col-6', 'col-md-4'); });
      lb.classList.add('active'); gb.classList.remove('active');
    } else {
      grid.classList.remove('list-view');
      grid.querySelectorAll('.col-product').forEach(c => { c.classList.add('col-6', 'col-md-4'); });
      gb.classList.add('active'); lb.classList.remove('active');
    }
  };

  // ── Dual Range Logic
  const rangeInput = document.querySelectorAll(".range-input input");
  const progress = document.querySelector(".range-selected");
  const minValText = document.getElementById("minPriceVal");
  const maxValText = document.getElementById("maxPriceVal");
  const priceGap = 10;

  if (rangeInput.length > 0) {
    rangeInput.forEach(input => {
      input.addEventListener("input", e => {
        let minVal = parseInt(rangeInput[0].value),
          maxVal = parseInt(rangeInput[1].value);

        if (maxVal - minVal < priceGap) {
          if (e.target.className === "min") {
            rangeInput[0].value = maxVal - priceGap;
          } else {
            rangeInput[1].value = minVal + priceGap;
          }
        } else {
          minValText.textContent = minVal;
          maxValText.textContent = maxVal;
          progress.style.left = ((minVal - rangeInput[0].min) / (rangeInput[0].max - rangeInput[0].min)) * 100 + "%";
          progress.style.right = 100 - ((maxVal - rangeInput[1].min) / (rangeInput[1].max - rangeInput[1].min)) * 100 + "%";
        }
      });
    });
  }

  window.resetPriceFilter = function () {
    if (rangeInput.length > 0) {
      // rangeInput[0].value = min_price;
      // rangeInput[1].value = max_price;
      // minValText.textContent = min_price;
      // maxValText.textContent = max_price;
      progress.style.left = "0%";
      progress.style.right = "0%";
      filterProducts();
    }
  };

  // Initialize on load
  if (progress && rangeInput.length > 0) {
    let minVal = parseInt(rangeInput[0].value);
    let maxVal = parseInt(rangeInput[1].value);
    progress.style.left = ((minVal - rangeInput[0].min) / (rangeInput[0].max - rangeInput[0].min)) * 100 + "%";
    progress.style.right = 100 - ((maxVal - rangeInput[1].min) / (rangeInput[1].max - rangeInput[1].min)) * 100 + "%";
  }
});

window.filterProducts = function () {
  const rangeInput = document.querySelectorAll(".range-input input");
  if (rangeInput.length < 2) return;

  const minPrice = parseInt(rangeInput[0].value);
  const maxPrice = parseInt(rangeInput[1].value);
  const products = document.querySelectorAll('.col-product');
  let visibleCount = 0;

  products.forEach(p => {
    const price = parseInt(p.dataset.price || 0);
    if (price >= minPrice && price <= maxPrice) {
      p.classList.remove('d-none');
      p.style.display = 'block';
      visibleCount++;
    } else {
      p.classList.add('d-none');
      p.style.display = 'none';
    }
  });

  // Update Results Count
  const resultsEl = document.querySelector('.toolbar .results');
  if (resultsEl) {
    resultsEl.innerHTML = visibleCount > 0 ?
      `Showing <strong>1–${visibleCount}</strong> of <strong>${products.length}</strong> results` :
      `Showing <strong>0</strong> of <strong>${products.length}</strong> results`;
  }

  // Show/Hide "No Products" message
  const msg = document.getElementById('noProductsMsg');
  if (msg) {
    visibleCount === 0 ? msg.classList.remove('d-none') : msg.classList.add('d-none');
  }
};