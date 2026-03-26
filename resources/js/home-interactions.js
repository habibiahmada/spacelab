// FAQ
window.toggleFaq = function (i) {
  const body = document.getElementById('faq-' + i);
  const chev = document.getElementById('chevron-' + i);
  const isOpen = body.classList.contains('open');

  // Close all other FAQs
  document.querySelectorAll('.faq-body').forEach(el => {
    if (el !== body) el.classList.remove('open');
  });
  document.querySelectorAll('.faq-chevron').forEach(el => {
    if (el !== chev) el.classList.remove('rotated');
  });

  // Toggle current FAQ
  if (isOpen) {
    body.classList.remove('open');
    chev.classList.remove('rotated');
  } else {
    body.classList.add('open');
    chev.classList.add('rotated');
  }
}

// Smooth scroll
document.querySelectorAll('a[href^="#"]').forEach(a => {
  a.addEventListener('click', e => {
    const t = document.querySelector(a.getAttribute('href'));
    if (t) { e.preventDefault(); t.scrollIntoView({ behavior: 'smooth' }); }
  });
});