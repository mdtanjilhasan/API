<?php
$a = 1111111111111111111;
if (is_int($a))
    echo 'yes';
else
    echo 'no';
die();
print_r(password_hash('12345678',PASSWORD_BCRYPT));
