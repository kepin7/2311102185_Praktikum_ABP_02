<?php

// Data mahasiswa
$mahasiswa = [
    [
        "nama"        => "Hizkia Kevin Octaviano",
        "nim"         => "2311102185",
        "nilai_tugas" => 88,
        "nilai_uts"   => 95,
        "nilai_uas"   => 90,
    ],
    [
        "nama"        => "Andi Pratama",
        "nim"         => "2311102101",
        "nilai_tugas" => 75,
        "nilai_uts"   => 70,
        "nilai_uas"   => 68,
    ],
    [
        "nama"        => "Eja",
        "nim"         => "2311102112",
        "nilai_tugas" => 85,
        "nilai_uts"   => 89,
        "nilai_uas"   => 94,
    ],
    [
        "nama"        => "Budiono Siregar",
        "nim"         => "2311102133",
        "nilai_tugas" => 55,
        "nilai_uts"   => 48,
        "nilai_uas"   => 52,
    ],
    [
        "nama"        => "Rina Marlina",
        "nim"         => "2311102144",
        "nilai_tugas" => 2,
        "nilai_uts"   => 26,
        "nilai_uas"   => 33,
    ],
    [
        "nama"        => "Dimas",
        "nim"         => "2311102155",
        "nilai_tugas" => 51,
        "nilai_uts"   => 38,
        "nilai_uas"   => 48,
    ],
];

// Functions

/**
 * Hitung nilai akhir dengan bobot:
 * Tugas 30% | UTS 35% | UAS 35%
 */
function hitungNilaiAkhir(float $tugas, float $uts, float $uas): float {
    return ($tugas * 0.30) + ($uts * 0.35) + ($uas * 0.35);
}

// Tentukan grade

function tentukanGrade(float $nilai): string {
    if ($nilai > 85) {
        return "A";
    } elseif ($nilai > 75) {
        return "AB";
    } elseif ($nilai > 65) {
        return "B";
    } elseif ($nilai > 60) {
        return "BC";
    } elseif ($nilai > 50) {
        return "C";
    } elseif ($nilai > 40) {
        return "D";
    } else {
        return "E";
    }
}


// Tentukan status kelulusan (lulus jika nilai akhir >= 60)

function tentukanStatus(float $nilai): string {
    return ($nilai > 50) ? "Lulus" : "Tidak Lulus";
}

// Proses data

$hasilMahasiswa  = [];
$totalNilaiAkhir = 0;
$nilaiTertinggi  = -1;
$mahasiswaTertinggi = "";

foreach ($mahasiswa as $mhs) {
    $na     = hitungNilaiAkhir($mhs["nilai_tugas"], $mhs["nilai_uts"], $mhs["nilai_uas"]);
    $grade  = tentukanGrade($na);
    $status = tentukanStatus($na);

    $hasilMahasiswa[] = [
        "nama"        => $mhs["nama"],
        "nim"         => $mhs["nim"],
        "nilai_tugas" => $mhs["nilai_tugas"],
        "nilai_uts"   => $mhs["nilai_uts"],
        "nilai_uas"   => $mhs["nilai_uas"],
        "nilai_akhir" => round($na, 2),
        "grade"       => $grade,
        "status"      => $status,
    ];

    $totalNilaiAkhir += $na;

    if ($na > $nilaiTertinggi) {
        $nilaiTertinggi     = $na;
        $mahasiswaTertinggi = $mhs["nama"];
    }
}

$jumlahMahasiswa = count($hasilMahasiswa);
$rataRataKelas   = round($totalNilaiAkhir / $jumlahMahasiswa, 2);
$lulusCount      = count(array_filter($hasilMahasiswa, fn($m) => $m["status"] === "Lulus"));

// FILTER & SEARCH (GET params)
$searchQuery  = isset($_GET["search"]) ? trim($_GET["search"]) : "";
$filterGrade  = isset($_GET["grade"])  ? trim($_GET["grade"])  : "";
$filterStatus = isset($_GET["status"]) ? trim($_GET["status"]) : "";

$tampil = array_filter($hasilMahasiswa, function ($mhs) use ($searchQuery, $filterGrade, $filterStatus) {
    $matchSearch = $searchQuery === ""
        || stripos($mhs["nama"], $searchQuery) !== false
        || stripos($mhs["nim"],  $searchQuery) !== false;

    $matchGrade  = $filterGrade  === "" || $mhs["grade"]  === $filterGrade;
    $matchStatus = $filterStatus === "" || $mhs["status"] === $filterStatus;

    return $matchSearch && $matchGrade && $matchStatus;
});