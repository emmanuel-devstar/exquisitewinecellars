<?php if (!empty(Configuration::$rc_site_key)): ?>
<script>
    console.log('[reCAPTCHA Loader] ✅ Site key configured:', "<?= Configuration::$rc_site_key ?>");
    console.log('[reCAPTCHA Loader] Loading reCAPTCHA script...');
</script>
<script src="https://www.google.com/recaptcha/api.js?render=<?= Configuration::$rc_site_key ?>" onload="console.log('[reCAPTCHA Loader] ✅ Script loaded successfully!')" onerror="console.error('[reCAPTCHA Loader] ❌ Script FAILED to load!')"></script>
<script>
    console.log('[reCAPTCHA Loader] Checking grecaptcha availability...');
    console.log('[reCAPTCHA Loader] typeof grecaptcha:', typeof grecaptcha);
    
    if (typeof grecaptcha !== 'undefined') {
        console.log('[reCAPTCHA Loader] grecaptcha exists immediately');
        grecaptcha.ready(function() {
            console.log('[reCAPTCHA Loader] ✅ grecaptcha.ready() - FULLY INITIALIZED!');
            const badge = document.querySelector(".grecaptcha-badge");
            if (badge) {
                badge.classList.add("visible");
                console.log('[reCAPTCHA Loader] Badge made visible');
            }
        });
    } else {
        console.log('[reCAPTCHA Loader] grecaptcha not immediately available, waiting for window load...');
        window.addEventListener('load', function() {
            console.log('[reCAPTCHA Loader] Window loaded');
            console.log('[reCAPTCHA Loader] typeof grecaptcha now:', typeof grecaptcha);
            setTimeout(function() {
                if (typeof grecaptcha !== 'undefined') {
                    console.log('[reCAPTCHA Loader] ✅ grecaptcha available after delay');
                    grecaptcha.ready(function() {
                        console.log('[reCAPTCHA Loader] ✅ grecaptcha.ready() fired');
                    });
                } else {
                    console.error('[reCAPTCHA Loader] ❌ grecaptcha STILL UNDEFINED! Check: 1) Site key valid? 2) Domain registered? 3) Network blocking?');
                }
                const badge = document.querySelector(".grecaptcha-badge");
                if (badge) {
                    badge.classList.add("visible");
                }
            }, 500);
        });
    }
</script>
<?php else: ?>
<!-- reCAPTCHA: Site key not configured -->
<script>
    console.error('[reCAPTCHA Loader] ❌ SITE KEY NOT CONFIGURED! Go to WordPress Admin > Configuration > reCAPTCHA');
</script>
<?php endif; ?>