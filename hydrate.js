document.addEventListener('DOMContentLoaded', async () => {
  try {
    const res = await fetch('/api/content');
    if (!res.ok) return;
    const content = await res.json();
    
    // Replace text content
    const elements = document.querySelectorAll('[data-content-key]');
    elements.forEach(el => {
      const key = el.getAttribute('data-content-key');
      if (content[key]) {
        if (el.tagName === 'A') {
          // If it's a link to a file/url or mailto, we need to be careful
          if (el.hasAttribute('href')) {
            const href = el.getAttribute('href');
            if (href.startsWith('mailto:')) {
               el.setAttribute('href', 'mailto:' + content[key]);
            } else if (href.includes('github') || href.includes('linkedin') || href.includes('instagram') || href.includes('wa.link')) {
               el.setAttribute('href', content[key]);
            } else if (key === 'home_resume_url') {
               el.setAttribute('href', content[key]);
            } else {
               el.textContent = content[key];
            }
          }
        } else {
          el.textContent = content[key];
        }
      }
    });

    // Special handlers for complex keys if needed
    if (content.about_contact_text) {
      const contactBtn = document.querySelector('.about .content .btn');
      if (contactBtn) contactBtn.textContent = content.about_contact_text;
    }
  } catch(e) {
    console.error('Failed to load content', e);
  }
});
