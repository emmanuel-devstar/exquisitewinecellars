<?php if (!empty(Configuration::$rc_site_key)): ?>
<script src="https://www.google.com/recaptcha/api.js?render=<?= Configuration::$rc_site_key ?>"></script>
<script>
    if (typeof grecaptcha !== 'undefined') {
        grecaptcha.ready(function() {
            const badge = document.querySelector(".grecaptcha-badge");
            if (badge) {
                badge.classList.add("visible");
            }
        });
    } else {
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
<!-- reCAPTCHA: Site key not configured -->
<?php endif; ?>
