document.addEventListener('DOMContentLoaded', () => {
    const loginPage = document.getElementById('login-page');
    const signupPage = document.getElementById('signup-page');
    const gotoSignupBtn = document.getElementById('goto-signup-btn');
    const gotoLoginBtn = document.getElementById('goto-login-btn');
    const loginForm = document.getElementById('login-form');
    const signupForm = document.getElementById('signup-form');
    const notification = document.getElementById('notification');

    const loginBg = document.getElementById('login-bg');
    const signupBg = document.getElementById('signup-bg');

    function showLoginPage() {
        loginPage.classList.remove('is-inactive-left');
        loginPage.classList.add('is-active');
        signupPage.classList.remove('is-active');
        signupPage.classList.add('is-inactive-right');

        loginBg.style.opacity = "1";
        signupBg.style.opacity = "0";
    }

    function showSignupPage() {
        loginPage.classList.remove('is-active');
        loginPage.classList.add('is-inactive-left');
        signupPage.classList.remove('is-inactive-right');
        signupPage.classList.add('is-active');

        loginBg.style.opacity = "0";
        signupBg.style.opacity = "1";
    }

    if (gotoLoginBtn) gotoLoginBtn.addEventListener('click', showLoginPage);
    if (gotoSignupBtn) gotoSignupBtn.addEventListener('click', showSignupPage);

    function showNotification(message, type = 'error') {
        notification.textContent = message;
        notification.className = `notification show ${type}`;
        setTimeout(() => {
            notification.classList.remove('show');
        }, 4000);
    }

    if (signupForm) {
        signupForm.addEventListener('submit', async (e) => {
            e.preventDefault();
            const formData = new FormData(signupForm);
            const submitButton = signupForm.querySelector('button[type="submit"]');
            submitButton.disabled = true;
            submitButton.textContent = 'Creating Account...';
            
            try {
                const response = await fetch('register.php', { method: 'POST', body: formData });
                const result = await response.json();

                if (result.status === 'success') {
                    showNotification(result.message, 'success');
                    signupForm.reset();
                    showLoginPage();
                } else {
                    showNotification(result.message, 'error');
                }
            } catch (error) {
                showNotification('A network error occurred. Please check the server.', 'error');
            } finally {
                submitButton.disabled = false;
                submitButton.textContent = 'Create Account';
            }
        });
    }

    if (loginForm) {
        loginForm.addEventListener('submit', async (e) => {
            e.preventDefault();
            const formData = new FormData(loginForm);
            const submitButton = loginForm.querySelector('button[type="submit"]');
            submitButton.disabled = true;
            submitButton.textContent = 'Logging In...';

            try {
                const response = await fetch('login.php', { method: 'POST', body: formData });

                let result;
                try {
                    result = await response.json();
                } catch {
                    showNotification('Server returned invalid response.', 'error');
                    return;
                }

                if (result.status === 'success') {
                    showNotification('Login successful! Redirecting...', 'success');
                    setTimeout(() => {
                        window.location.href = 'home.php';
                    }, 1500);
                } else {
                    showNotification(result.message || 'Login failed.', 'error');
                }
            } catch (error) {
                showNotification('A network error occurred. Please check the server.', 'error');
            } finally {
                submitButton.disabled = false;
                submitButton.textContent = 'Login';
            }
        });
    }
});