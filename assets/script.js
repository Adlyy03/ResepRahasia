window.onload = function() {
  // Hapus bagian hash dari URL (contoh: #footer)
  if (window.location.hash) {
    history.replaceState(null, null, window.location.pathname);
  }

  // Paksa scroll ke atas saat halaman selesai dimuat
  window.scrollTo(0, 0);
};

document.addEventListener('DOMContentLoaded', () => {
  // Hamburger menu functionality
  const hamburgerBtn = document.getElementById('hamburgerBtn');
  const navLinks = document.getElementById('nav-links');
  const mobileOverlay = document.getElementById('mobileOverlay');

  if (hamburgerBtn && navLinks) {
    hamburgerBtn.addEventListener('click', () => {
      hamburgerBtn.classList.toggle('active');
      navLinks.classList.toggle('active');
      mobileOverlay.classList.toggle('active');
      
      // Toggle aria-expanded for accessibility
      const isExpanded = hamburgerBtn.getAttribute('aria-expanded') === 'true';
      hamburgerBtn.setAttribute('aria-expanded', !isExpanded);
    });

    // Close menu when clicking on overlay
    mobileOverlay.addEventListener('click', () => {
      hamburgerBtn.classList.remove('active');
      navLinks.classList.remove('active');
      mobileOverlay.classList.remove('active');
      hamburgerBtn.setAttribute('aria-expanded', 'false');
    });

    // Close menu when clicking on a link
    document.querySelectorAll('.nav-links a').forEach(link => {
      link.addEventListener('click', () => {
        hamburgerBtn.classList.remove('active');
        navLinks.classList.remove('active');
        mobileOverlay.classList.remove('active');
        hamburgerBtn.setAttribute('aria-expanded', 'false');
      });
    });
  }

  // Dark mode toggle
  const toggleBtn = document.getElementById('darkToggle');
  const body = document.body;
  
  if (toggleBtn) {
    // Restore user preference
    if (localStorage.getItem('darkMode') === 'enabled') {
      body.classList.add('dark');
    }
    
    toggleBtn.addEventListener('click', (e) => {
      e.preventDefault();
      body.classList.toggle('dark');
      localStorage.setItem(
        'darkMode',
        body.classList.contains('dark') ? 'enabled' : 'disabled'
      );
    });
  }

  // Search functionality
  const searchInput = document.getElementById('searchInput');
  const dropdown = document.getElementById('searchDropdown');
  
  function getResepCards() {
    return Array.from(document.querySelectorAll('.resep-card'));
  }

  function filterResep() {
    const query = searchInput.value.toLowerCase();
    getResepCards().forEach(card => {
      const nama = card.getAttribute('data-nama').toLowerCase();
      const bahan = card.getAttribute('data-bahan').toLowerCase();
      const kategori = card.getAttribute('data-kategori').toLowerCase();
      
      card.style.display = 
        nama.includes(query) || bahan.includes(query) || kategori.includes(query)
          ? 'block'
          : 'none';
    });
  }

  function autoSearch() {
    const input = searchInput.value.toLowerCase();
    dropdown.innerHTML = '';
    
    if (!input) {
      dropdown.style.display = 'none';
      return;
    }

    let found = 0;
    getResepCards().forEach(card => {
      const nama = card.getAttribute('data-nama').toLowerCase();
      if (nama.includes(input)) {
        const li = document.createElement('li');
        li.textContent = card.querySelector('h3').textContent;
        li.addEventListener('click', () => {
          searchInput.value = li.textContent;
          dropdown.style.display = 'none';
          filterResep();
        });
        dropdown.appendChild(li);
        found++;
      }
    });
    
    dropdown.style.display = found ? 'block' : 'none';
  }

  if (searchInput) {
    searchInput.addEventListener('input', () => {
      filterResep();
      autoSearch();
    });
    
    // Hide dropdown when clicking outside
    document.addEventListener('click', (e) => {
      if (!e.target.closest('.search-section')) {
        dropdown.style.display = 'none';
      }
    });
  }

  // Make filterResep available globally
  window.filterResep = filterResep;
});