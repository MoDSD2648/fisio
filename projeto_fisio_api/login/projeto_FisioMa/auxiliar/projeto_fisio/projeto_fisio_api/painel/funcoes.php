<?php
function gerarApiKey() {
    return bin2hex(random_bytes(32));
}
