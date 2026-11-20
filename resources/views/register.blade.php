<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - Alignment</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="icon" href="./img/favicon.png" type="image/x-icon">
    <style>
        @keyframes gradient {
            0% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
            100% { background-position: 0% 50%; }
        }

        @keyframes blob {
            0%, 100% { transform: translate(0, 0) scale(1); }
            33% { transform: translate(30px, -50px) scale(1.1); }
            66% { transform: translate(-20px, 20px) scale(0.9); }
        }

        @keyframes rise {
            from { opacity: 0; transform: translateY(16px); }
            to { opacity: 1; transform: translateY(0); }
        }

        @keyframes shake {
            0%, 100% { transform: translateX(0); }
            20%, 60% { transform: translateX(-6px); }
            40%, 80% { transform: translateX(6px); }
        }

        @keyframes spin { to { transform: rotate(360deg); } }

        /* Tailwind's display utilities (flex, ...) otherwise beat the hidden attribute. */
        [hidden] { display: none !important; }

        .gradient-bg {
            background: linear-gradient(-45deg, #667eea 0%, #764ba2 25%, #f093fb 50%, #4facfe 75%, #667eea 100%);
            background-size: 400% 400%;
            animation: gradient 15s ease infinite;
        }

        .glass {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.3);
        }

        .animate-blob { animation: blob 7s infinite; }
        .animation-delay-2000 { animation-delay: 2s; }
        .animation-delay-4000 { animation-delay: 4s; }
        .rise { animation: rise .5s ease both; }
        .rise-late { animation: rise .5s .1s ease both; }
        .shake { animation: shake .4s ease; }

        .spinner {
            width: 1.1rem; height: 1.1rem; border-radius: 9999px;
            border: 2px solid rgba(255, 255, 255, .4); border-top-color: #fff;
            animation: spin .7s linear infinite;
        }

        .field input[aria-invalid="true"] { border-color: #f87171; }

        /* People who asked their system for less motion get a still page. */
        @media (prefers-reduced-motion: reduce) {
            .gradient-bg, .animate-blob, .rise, .rise-late, .shake { animation: none; }
        }
    </style>
</head>

<body class="gradient-bg min-h-screen flex flex-col items-center justify-center p-4">

    <!-- Floating decorative elements -->
    <div class="fixed inset-0 overflow-hidden pointer-events-none" aria-hidden="true">
        <div class="absolute top-20 left-10 w-72 h-72 bg-purple-300 rounded-full mix-blend-multiply filter blur-xl opacity-70 animate-blob"></div>
        <div class="absolute top-40 right-10 w-72 h-72 bg-yellow-300 rounded-full mix-blend-multiply filter blur-xl opacity-70 animate-blob animation-delay-2000"></div>
        <div class="absolute -bottom-8 left-20 w-72 h-72 bg-pink-300 rounded-full mix-blend-multiply filter blur-xl opacity-70 animate-blob animation-delay-4000"></div>
    </div>

    <main class="relative z-10 w-full max-w-md my-6">

        <!-- Back Button -->
        <div class="mb-6 rise">
            <a href="./"
                class="inline-flex items-center gap-2 px-4 py-2.5 glass rounded-xl hover:bg-white/80 transition-all transform hover:scale-105 shadow-lg focus:outline-none focus-visible:ring-2 focus-visible:ring-white">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5"
                    stroke="currentColor" class="w-5 h-5 text-indigo-600" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5L8.25 12l7.5-7.5" />
                </svg>
                <span class="font-semibold text-gray-700">Back to Home</span>
            </a>
        </div>

        <!-- Register Card -->
        <div id="card" class="glass rounded-3xl shadow-2xl p-8 md:p-10 rise-late">

            <!-- Logo/Header -->
            <div class="text-center mb-8">
                <div class="inline-flex items-center justify-center w-16 h-16 bg-gradient-to-r from-indigo-600 to-purple-600 rounded-2xl mb-4 shadow-lg">
                    <div class="w-10 h-10 bg-gradient-to-r from-purple-600 to-indigo-600 rounded-xl flex items-center justify-center overflow-hidden">
                        <img src="./img/favicon.png" alt="" class="w-6 h-6 object-contain">
                    </div>
                </div>
                <h1 class="text-3xl md:text-4xl font-bold">
                    <span class="bg-gradient-to-r from-indigo-600 to-purple-600 bg-clip-text text-transparent">Create Account</span>
                </h1>
                <p class="text-gray-600 mt-2">Start aligning your vocabularies</p>
            </div>

            <form id="registerForm" class="space-y-5" novalidate>

                <!-- Error message (network / server problems) -->
                <div id="formError" role="alert" aria-live="assertive" hidden
                    class="flex items-start gap-3 rounded-xl border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-700">
                    <svg class="w-5 h-5 shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 9v3.75m9-.75a9 9 0 11-18 0 9 9 0 0118 0zm-9 3.75h.008v.008H12v-.008z" />
                    </svg>
                    <span id="formErrorText"></span>
                </div>

                <!-- Name -->
                <div class="field">
                    <label for="name" class="block text-sm font-semibold text-gray-700 mb-2">Full name</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                            <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M5.121 17.804A9.965 9.965 0 0112 15c2.21 0 4.248.72 5.879 1.927M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                            </svg>
                        </div>
                        <input type="text" id="name" name="name" required autofocus maxlength="100"
                            autocomplete="name" placeholder="John Doe" aria-describedby="err-name"
                            class="w-full pl-12 pr-4 py-3.5 border-2 border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent text-gray-700 transition-all" />
                    </div>
                    <p id="err-name" class="mt-1.5 text-xs text-red-600" hidden></p>
                </div>

                <!-- Email -->
                <div class="field">
                    <label for="email" class="block text-sm font-semibold text-gray-700 mb-2">Email address</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                            <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207" />
                            </svg>
                        </div>
                        <input type="email" id="email" name="email" required maxlength="150"
                            autocomplete="username" autocapitalize="none" spellcheck="false"
                            placeholder="name@example.com" aria-describedby="err-email"
                            class="w-full pl-12 pr-4 py-3.5 border-2 border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent text-gray-700 transition-all" />
                    </div>
                    <p id="err-email" class="mt-1.5 text-xs text-red-600" hidden>
                        <span id="err-email-text"></span>
                        <a id="signinInstead" href="./login" class="font-semibold underline" hidden>Sign in instead</a>
                    </p>
                </div>

                <!-- Password -->
                <div class="field">
                    <label for="password" class="block text-sm font-semibold text-gray-700 mb-2">Password</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                            <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                            </svg>
                        </div>
                        <input type="password" id="password" name="password" required maxlength="128"
                            autocomplete="new-password" placeholder="At least 8 characters"
                            aria-describedby="passwordRule err-password"
                            class="w-full pl-12 pr-12 py-3.5 border-2 border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent text-gray-700 transition-all" />
                        <button type="button" id="togglePassword" aria-label="Show passwords" aria-pressed="false"
                            class="absolute inset-y-0 right-0 pr-4 flex items-center text-gray-400 hover:text-gray-600 focus:outline-none focus-visible:text-indigo-600">
                            <svg id="eyeOn" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                            </svg>
                            <svg id="eyeOff" class="w-5 h-5 hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21" />
                            </svg>
                        </button>
                    </div>
                    <p id="passwordRule" class="mt-1.5 text-xs text-gray-500">Use at least 8 characters.</p>
                    <p id="err-password" class="mt-1.5 text-xs text-red-600" hidden></p>
                    <p id="capsHint" class="mt-1.5 text-xs text-amber-600" hidden>Caps Lock is on.</p>
                </div>

                <!-- Confirm password -->
                <div class="field">
                    <label for="confirm" class="block text-sm font-semibold text-gray-700 mb-2">Confirm password</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                            <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 12.75L11.25 15 15 9.75m-3-7.036A11.959 11.959 0 013.598 6 11.99 11.99 0 003 9.749c0 5.592 3.824 10.29 9 11.623 5.176-1.332 9-6.03 9-11.622 0-1.31-.21-2.571-.598-3.751h-.152c-3.196 0-6.1-1.248-8.25-3.285z" />
                            </svg>
                        </div>
                        <input type="password" id="confirm" name="confirm" required maxlength="128"
                            autocomplete="new-password" placeholder="Repeat your password" aria-describedby="err-confirm"
                            class="w-full pl-12 pr-4 py-3.5 border-2 border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent text-gray-700 transition-all" />
                    </div>
                    <p id="err-confirm" class="mt-1.5 text-xs text-red-600" hidden></p>
                </div>

                <!-- Submit Button -->
                <button type="submit" id="submitBtn"
                    class="w-full bg-gradient-to-r from-indigo-600 to-purple-600 text-white font-bold py-3.5 px-4 rounded-xl hover:from-indigo-700 hover:to-purple-700 transform hover:scale-[1.02] transition-all shadow-lg hover:shadow-xl flex items-center justify-center gap-2 disabled:opacity-70 disabled:cursor-not-allowed disabled:hover:scale-100 focus:outline-none focus-visible:ring-4 focus-visible:ring-indigo-300">
                    <span id="submitText">Create account</span>
                    <svg id="submitArrow" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6" />
                    </svg>
                    <span id="submitSpinner" class="spinner hidden" aria-hidden="true"></span>
                </button>

                <!-- Login Link -->
                <p class="mt-8 text-center text-gray-600">
                    Already have an account?
                    <a href="./login" class="text-indigo-600 font-bold hover:text-indigo-700 hover:underline ml-1">Sign in →</a>
                </p>
            </form>
        </div>

        <!-- Footer -->
        <footer class="mt-6 text-white/90 text-sm text-center">
            &copy; <span id="current-year"></span> Alignment. All rights reserved.
        </footer>
    </main>

    <script>
        window.apiBaseUrl = "{{ config('api.base_url') }}";

        const MIN_PASSWORD = 8;
        const form = document.getElementById('registerForm');
        const card = document.getElementById('card');
        const submitBtn = document.getElementById('submitBtn');
        const errorBox = document.getElementById('formError');
        const errorText = document.getElementById('formErrorText');
        const inputs = {
            name: document.getElementById('name'),
            email: document.getElementById('email'),
            password: document.getElementById('password'),
            confirm: document.getElementById('confirm'),
        };

        document.getElementById('current-year').textContent = new Date().getFullYear();

        function goTo(url) { window.location.href = url; }

        // Already signed in: go to the dashboard. The token is checked first, so an expired
        // one is dropped instead of bouncing between pages.
        (async () => {
            let token = null;
            try { token = localStorage.getItem('token'); } catch (_) { }
            if (!token) return;
            try {
                const res = await fetch(`${window.apiBaseUrl}/me`, { headers: { Authorization: 'Bearer ' + token } });
                if (res.ok) goTo('./dashboard');
                else if (res.status === 401) localStorage.removeItem('token');
            } catch (_) { /* API unreachable: just show the form */ }
        })();

        // ---------- messages ----------
        function shake() {
            card.classList.remove('shake');
            void card.offsetWidth;                 // restart the animation when the error repeats
            card.classList.add('shake');
        }
        function showError(message) {
            errorText.textContent = message;
            errorBox.hidden = false;
            shake();
        }
        function setFieldError(field, message, withSignInLink = false) {
            const input = inputs[field];
            document.getElementById(field === 'email' ? 'err-email-text' : 'err-' + field).textContent = message;
            document.getElementById('err-' + field).hidden = false;
            if (field === 'email') document.getElementById('signinInstead').hidden = !withSignInLink;
            input.setAttribute('aria-invalid', 'true');
        }
        function clearField(field) {
            document.getElementById('err-' + field).hidden = true;
            inputs[field].removeAttribute('aria-invalid');
        }
        function clearAll() {
            errorBox.hidden = true;
            Object.keys(inputs).forEach(clearField);
        }
        function setBusy(busy, label) {
            submitBtn.disabled = busy;
            Object.values(inputs).forEach(i => { i.readOnly = busy; });
            document.getElementById('submitText').textContent = busy ? label : 'Create account';
            document.getElementById('submitArrow').classList.toggle('hidden', busy);
            document.getElementById('submitSpinner').classList.toggle('hidden', !busy);
        }

        // ---------- checks before anything is sent ----------
        function validate(v) {
            const problems = [];
            if (!v.name) problems.push(['name', 'Enter your name.']);
            if (!v.email) problems.push(['email', 'Enter your email address.']);
            else if (!inputs.email.checkValidity()) problems.push(['email', 'That email address does not look right.']);
            if (!v.password) problems.push(['password', 'Choose a password.']);
            else if (v.password.length < MIN_PASSWORD) problems.push(['password', `The password needs at least ${MIN_PASSWORD} characters.`]);
            if (!v.confirm) problems.push(['confirm', 'Repeat your password.']);
            else if (v.password !== v.confirm) problems.push(['confirm', 'The two passwords are not the same.']);
            return problems;
        }

        // The API answers with a string, or for invalid input with a list of {loc, msg}.
        function applyServerError(status, data) {
            const detail = data && data.detail;
            if (status === 400 && typeof detail === 'string' && /already registered/i.test(detail)) {
                setFieldError('email', 'This email is already registered.', true);
                inputs.email.focus();
                shake();
                return;
            }
            if (status === 422 && Array.isArray(detail)) {
                let first = null;
                detail.forEach(d => {
                    const field = Array.isArray(d.loc) ? d.loc[d.loc.length - 1] : null;
                    if (field && inputs[field]) {
                        setFieldError(field, 'Please check this field.');
                        first = first || field;
                    }
                });
                if (first) { inputs[first].focus(); shake(); return; }
                showError('Please check what you entered and try again.');
                return;
            }
            if (status === 429) return showError('Too many attempts. Wait a moment and try again.');
            if (status >= 500) return showError('The server had a problem. Please try again in a moment.');
            showError(typeof detail === 'string' ? detail : 'Could not create the account. Please try again.');
        }

        async function post(path, body, timeoutMs = 15000) {
            const controller = new AbortController();
            const timer = setTimeout(() => controller.abort(), timeoutMs);
            try {
                const response = await fetch(`${window.apiBaseUrl}${path}`, {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json' },
                    body: JSON.stringify(body),
                    signal: controller.signal,
                });
                let data = null;
                try { data = await response.json(); } catch (_) { /* not JSON */ }
                return { response, data };
            } finally {
                clearTimeout(timer);
            }
        }

        form.addEventListener('submit', async (e) => {
            e.preventDefault();
            if (submitBtn.disabled) return;                  // double click / Enter twice

            const v = {
                name: inputs.name.value.trim(),
                email: inputs.email.value.trim(),
                password: inputs.password.value,
                confirm: inputs.confirm.value,
            };
            clearAll();
            const problems = validate(v);
            if (problems.length) {
                problems.forEach(([field, msg]) => setFieldError(field, msg));
                inputs[problems[0][0]].focus();
                shake();
                return;
            }

            setBusy(true, 'Creating account…');
            try {
                const { response, data } = await post('/register', { name: v.name, email: v.email, password: v.password });
                if (!response.ok) {
                    applyServerError(response.status, data);
                    setBusy(false);
                    return;
                }
                // Account exists. Sign in right away; if that fails, the login page is the fallback.
                setBusy(true, 'Signing you in…');
                try {
                    const login = await post('/login', { email: v.email, password: v.password });
                    if (login.response.ok && login.data && login.data.access_token) {
                        localStorage.setItem('token', login.data.access_token);
                        goTo('./dashboard');
                        return;
                    }
                } catch (_) { /* fall through to the login page */ }
                goTo('./login');
                return;                                      // keep the button busy while the page changes
            } catch (err) {
                showError(err.name === 'AbortError'
                    ? 'The server took too long to answer. Please try again.'
                    : 'Cannot reach the server. Check your connection and try again.');
                setBusy(false);
            }
        });

        Object.entries(inputs).forEach(([field, input]) => {
            input.addEventListener('input', () => {
                errorBox.hidden = true;
                clearField(field);
                if (field === 'password') {
                    clearField('confirm');
                    const rule = document.getElementById('passwordRule');
                    const ok = input.value.length >= MIN_PASSWORD;
                    rule.textContent = ok ? '✓ Long enough.' : 'Use at least 8 characters.';
                    rule.classList.toggle('text-green-600', ok);
                    rule.classList.toggle('text-gray-500', !ok);
                }
            });
        });

        // One eye button shows or hides both password fields.
        const toggle = document.getElementById('togglePassword');
        toggle.addEventListener('click', () => {
            const show = inputs.password.type === 'password';
            inputs.password.type = inputs.confirm.type = show ? 'text' : 'password';
            toggle.setAttribute('aria-pressed', String(show));
            toggle.setAttribute('aria-label', show ? 'Hide passwords' : 'Show passwords');
            document.getElementById('eyeOn').classList.toggle('hidden', show);
            document.getElementById('eyeOff').classList.toggle('hidden', !show);
            inputs.password.focus();
        });

        const caps = document.getElementById('capsHint');
        const checkCaps = (e) => { if (e.getModifierState) caps.hidden = !e.getModifierState('CapsLock'); };
        [inputs.password, inputs.confirm].forEach(el => {
            el.addEventListener('keydown', checkCaps);
            el.addEventListener('keyup', checkCaps);
            el.addEventListener('blur', () => { caps.hidden = true; });
        });
    </script>

</body>

</html>