<?php

$users = [
    [
        'email' => 'admin@gmail.com',
        'username' => 'adminxxx',
        'name' => 'Admin',
        'password' => password_hash('admin123', PASSWORD_DEFAULT)
    ],
    [
        'email' => 'sarham@gmail.com',
        'username' => 'sarham_aja',
        'name' => 'Sarham San',
        'password' => password_hash('sarham123', PASSWORD_DEFAULT),
        'gender' => 'Male',
        'faculty' => 'MIPA',
        'batch' => '2023'
    ],
    [
        'email' => 'icha@gmail.com',
        'username' => 'icha',
        'name' => 'Nur Ainun Aisyah H',
        'password' => password_hash('icha123', PASSWORD_DEFAULT),
        'gender' => 'Female',
        'faculty' => 'Hukum',
        'batch' => '2024'
    ],
    [
        'email' => 'jarwo@gmail.com',
        'username' => 'jarwo99',
        'name' => 'Jarwo Syabhan',
        'password' => password_hash('jarwo123', PASSWORD_DEFAULT),
        'gender' => 'Male',
        'faculty' => 'Keperawatan',
        'batch' => '2021'
    ],
    [
        'email' => 'jonbak@gmail.com',
        'username' => 'jon23',
        'name' => 'Jonas Baka',
        'password' => password_hash('jon123', PASSWORD_DEFAULT),
        'gender' => 'Male',
        'faculty' => 'Teknik',
        'batch' => '2020'
    ]
];
?>