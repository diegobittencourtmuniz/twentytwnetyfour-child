<?php
if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}
?>
<div id="consent-banner" style="position: fixed; bottom: 0; width: 100%; background-color: #f8f9fa; text-align: center; padding: 10px; box-shadow: 0 -2px 5px rgba(0,0,0,0.1);">
    <p>This website uses cookies to ensure you get the best experience on our website. By continuing to browse the site, you agree to our use of cookies.</p>
    <button id="accept-cookies" style="margin-left: 10px;">Accept</button>
    <button id="decline-cookies" style="margin-left: 10px;">Decline</button>
</div>
<script>
document.getElementById('accept-cookies').onclick = function() {
    document.getElementById('consent-banner').style.display = 'none';
    document.cookie = "consent=true; max-age=31536000; path=/";
};
document.getElementById('decline-cookies').onclick = function() {
    document.getElementById('consent-banner').style.display = 'none';
    document.cookie = "consent=false; max-age=31536000; path=/";
};
</script>
