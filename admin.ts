import { login, getUser, handleAuthCallback, logout } from '@netlify/identity';

document.addEventListener('DOMContentLoaded', async () => {
  // Try to process a callback hash if present
  await handleAuthCallback();
  
  const user = await getUser();
  
  const loginSection = document.getElementById('login-section');
  const adminSection = document.getElementById('admin-section');
  const loginForm = document.getElementById('login-form') as HTMLFormElement;
  const adminForm = document.getElementById('admin-form') as HTMLFormElement;
  const loginError = document.getElementById('login-error');
  const logoutBtn = document.getElementById('logout-btn');
  const saveBtn = document.getElementById('save-btn');

  if (user) {
    loginSection!.style.display = 'none';
    adminSection!.style.display = 'block';
    loadContent();
  } else {
    loginSection!.style.display = 'block';
    adminSection!.style.display = 'none';
  }

  logoutBtn?.addEventListener('click', async () => {
    await logout();
    window.location.reload();
  });

  loginForm?.addEventListener('submit', async (e) => {
    e.preventDefault();
    loginError!.textContent = '';
    const email = (document.getElementById('email') as HTMLInputElement).value;
    const password = (document.getElementById('password') as HTMLInputElement).value;
    
    try {
      await login(email, password);
      window.location.reload();
    } catch (err: any) {
      loginError!.textContent = err.message || 'Login failed';
    }
  });

  adminForm?.addEventListener('submit', async (e) => {
    e.preventDefault();
    saveBtn!.textContent = 'Saving...';
    
    const formData = new FormData(adminForm);
    const payload: Record<string, string> = {};
    formData.forEach((value, key) => {
      payload[key] = value.toString();
    });

    try {
      const res = await fetch('/api/content', {
        method: 'PUT',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify(payload)
      });
      if (res.ok) {
        alert('Saved successfully');
      } else {
        alert('Error saving content');
      }
    } catch (err) {
      alert('Error saving content');
    }
    saveBtn!.textContent = 'Save Content';
  });

  async function loadContent() {
    try {
      const res = await fetch('/api/content');
      if (res.ok) {
        const data = await res.json();
        for (const [key, value] of Object.entries(data)) {
          const input = adminForm?.elements.namedItem(key) as HTMLInputElement;
          if (input) {
            input.value = value as string;
          }
        }
      }
    } catch (err) {
      console.error('Error loading content', err);
    }
  }
});