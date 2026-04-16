<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');

$profil = [
    'nama'          => 'Hizkia Kevin Octaviano',
    'nim'           => '2311102185',
    'prodi'         => 'S1 Teknik Informatika',
    'universitas'   => 'Telkom University Purwokerto',
    'angkatan'      => 2023,
    'no.telepon'     => '081328157664',
    'email'         => 'hizkiakevin8@gmail.com',
    'minat'         => ['Web Development', 'Machine Learning', 'Vision Computer']
];

echo json_encode($profil);