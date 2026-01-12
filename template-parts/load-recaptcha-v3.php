<?php if (!empty(Configuration::$rc_site_key)): ?>
<?php
// Check if there are any forms with g-recaptcha-v3 class on the page
// Load the script directly for reliability
?>
<script src="https://www.google.com/recaptcha/api.js?render=<?= Configuration::$rc_site_key ?>"></script>
<script>
    // Make grecaptcha badge visible once loaded
    if (typeof grecaptcha !== 'undefined') {
        grecaptcha.ready(function() {
            const badge = document.querySelector(".grecaptcha-badge");
            if (badge) {
                badge.classList.add("visible");
            }
        });
    } else {
        // Fallback: wait for script to load
        window.addEventListener('load', function() {
            setTimeout(function() {
                const badge = document.querySelector(".grecaptcha-badge");
                if (badge) {
                    badge.classList.add("visible");
                }
            }, 500);
        });
    }
</script>
<?php else: ?>
<!-- reCAPTCHA: Site key not configured. Please add reCAPTCHA v3 keys in WordPress Admin > Configuration -->
<?php endif; ?>