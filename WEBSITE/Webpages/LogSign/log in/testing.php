<?php
$entered_password = 'your_password';
$stored_hash = 'your_hashed_password';

if (password_verify($entered_password, $stored_hash)) {
    echo "Password is correct.";
} else {
    echo "Password is incorrect.";
}