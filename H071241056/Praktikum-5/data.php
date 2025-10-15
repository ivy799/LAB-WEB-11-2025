<?php 

$users = [
    [
        'email' => 'admin@gmail.com', 
        'username' => 'adminxxx', 
        'name' => 'Admin', 
        'password' => password_hash('admin123', PASSWORD_DEFAULT),
    ],

    [
        'email' => 'indira@gmail.com', 
        'username' => 'indira_aja', 
        'name' => 'Indi', 
        'password' => password_hash('indi123', PASSWORD_DEFAULT), 
        'gender' => 'Female', 
        'faculty' => 'MIPA', 
        'batch' => '2024', 
    ],
    [
        'email' => 'soyas@gmail.com', 
        'username' => 'soyas', 
        'name' => 'soya', 
        'password' => password_hash('soyas123', PASSWORD_DEFAULT), 
        'gender' => 'Female', 
        'faculty' => 'MIPA', 
        'batch' => '2024', 
    ],
    [
        'email' => 'rafardan@gmail.com', 
        'username' => 'rafardan', 
        'name' => 'rafa', 
        'password' => password_hash('rafa123', PASSWORD_DEFAULT), 
        'gender' => 'Male', 
        'faculty' => 'TEKNIK', 
        'batch' => '2034', 
    ],

    [
        'email' => 'ramayani@gmail.com',
        'username' => 'rara112',
        'name' => 'ra',
        'password' => password_hash('rara123', PASSWORD_DEFAULT),
        'gender' => 'Male',
        'faculty' => 'Hukum',
        'batch' => '2023'
    ]
]
?>