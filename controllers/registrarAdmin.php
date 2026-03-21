<?php

// Hasheo para registrar el primer usuario ADMIN manualmente en la BD

echo password_hash("(contraseña a hashear)", PASSWORD_DEFAULT);