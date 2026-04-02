<?php require_once "sistem_penilaian_mahasiswa.php"; ?>
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistem Nilai Mahasiswa</title>
    <link
        href="https://fonts.googleapis.com/css2?family=Space+Mono:wght@400;700&family=Sora:wght@300;400;600;700&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="style.css">
</head>

<body>

    <!-- ── HEADER ── -->
    <div class="header">
        <h1>Sistem Nilai <span>Mahasiswa</span></h1>
        <p>Bobot: Tugas 30% &nbsp;|&nbsp; UTS 35% &nbsp;|&nbsp; UAS 35%</p>
    </div>

    <!-- ── STAT CARDS ── -->
    <div class="stats">
        <div class="stat-card blue">
            <div class="label">Total Mahasiswa</div>
            <div class="value"><?= $jumlahMahasiswa ?></div>
            <div class="sub">terdaftar</div>
        </div>
        <div class="stat-card green">
            <div class="label">Nilai Rata-rata Kelas</div>
            <div class="value"><?= $rataRataKelas ?></div>

        </div>
        <div class="stat-card warn">
            <div class="label">Nilai Tertinggi</div>
            <div class="value"><?= round($nilaiTertinggi, 2) ?></div>
            <div class="sub"><?= htmlspecialchars($mahasiswaTertinggi) ?></div>
        </div>
        <div class="stat-card green">
            <div class="label">Tingkat Kelulusan</div>
            <div class="value"><?= round(($lulusCount / $jumlahMahasiswa) * 100) ?>%</div>
            <div class="sub"><?= $lulusCount ?> dari <?= $jumlahMahasiswa ?> mahasiswa</div>
        </div>
    </div>

    <!-- ── FILTER FORM ── -->
    <form method="GET" action="">
        <div class="filters">
            <div class="filter-group">
                <label>Cari Nama / NIM</label>
                <input type="text" name="search" placeholder="Ketik nama atau NIM..."
                    value="<?= htmlspecialchars($searchQuery) ?>">
            </div>
            <div class="filter-group">
                <label>Filter Grade</label>
                <select name="grade">
                    <option value="">Semua Grade</option>
                    <?php foreach (["A", "AB", "B", "BC", "C", "D", "E"] as $g): ?>
                    <option value="<?= $g ?>" <?= $filterGrade === $g ? "selected" : "" ?>>
                        <?= $g ?>
                    </option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="filter-group">
                <label>Filter Status</label>
                <select name="status">
                    <option value="">Semua Status</option>
                    <option value="Lulus" <?= $filterStatus === "Lulus"       ? "selected" : "" ?>>Lulus</option>
                    <option value="Tidak Lulus" <?= $filterStatus === "Tidak Lulus" ? "selected" : "" ?>>Tidak Lulus
                    </option>
                </select>
            </div>
            <button type="submit" class="btn-filter">Terapkan</button>
            <a href="?" style="text-decoration:none;">
                <button type="button" class="btn-reset">Reset</button>
            </a>
        </div>
    </form>

    <!-- ── RESULT HINT ── -->
    <div class="result-hint">
        Menampilkan <span><?= count($tampil) ?></span> dari <?= $jumlahMahasiswa ?> mahasiswa
        <?php if ($searchQuery || $filterGrade || $filterStatus): ?>
        &nbsp;· filter aktif:
        <?php if ($searchQuery):  ?> <span>"<?= htmlspecialchars($searchQuery) ?>"</span><?php endif; ?>
        <?php if ($filterGrade):  ?> <span>Grade <?= $filterGrade ?></span><?php endif; ?>
        <?php if ($filterStatus): ?> <span><?= $filterStatus ?></span><?php endif; ?>
        <?php endif; ?>
    </div>

    <!-- ── TABLE ── -->
    <div class="table-wrap">
        <table>
            <thead>
                <tr>
                    <th>#</th>
                    <th>Nama Mahasiswa</th>
                    <th>NIM</th>
                    <th>Tugas</th>
                    <th>UTS</th>
                    <th>UAS</th>
                    <th>Nilai Akhir</th>
                    <th>Grade</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                <?php if (count($tampil) === 0): ?>
                <tr>
                    <td colspan="9">
                        <div class="empty-state">
                            <div class="icon">🔎</div>
                            <div>Tidak ada data yang cocok dengan filter.</div>
                        </div>
                    </td>
                </tr>
                <?php else: ?>
                <?php $no = 1; foreach ($tampil as $mhs): ?>
                <?php
                $pct      = min(100, round($mhs["nilai_akhir"]));
                $barColor = $mhs["nilai_akhir"] >= 75 ? "#4ade80"
                          : ($mhs["nilai_akhir"] >= 60 ? "#fbbf24" : "#f87171");
            ?>
                <tr>
                    <td style="color:var(--muted);font-family:var(--mono);font-size:.8rem"><?= $no++ ?></td>
                    <td><strong><?= htmlspecialchars($mhs["nama"]) ?></strong></td>
                    <td class="nim-cell"><?= htmlspecialchars($mhs["nim"]) ?></td>
                    <td><?= $mhs["nilai_tugas"] ?></td>
                    <td><?= $mhs["nilai_uts"] ?></td>
                    <td><?= $mhs["nilai_uas"] ?></td>
                    <td class="na-cell">
                        <div class="mini-bar-wrap">
                            <?= $mhs["nilai_akhir"] ?>
                            <div class="mini-bar">
                                <div class="mini-bar-fill" style="width:<?= $pct ?>%;background:<?= $barColor ?>"></div>
                            </div>
                        </div>
                    </td>
                    <td>
                        <span class="badge badge-<?= $mhs["grade"] ?>"><?= $mhs["grade"] ?></span>
                    </td>
                    <td>
                        <?php if ($mhs["status"] === "Lulus"): ?>
                        <span class="status-lulus">Lulus</span>
                        <?php else: ?>
                        <span class="status-tidak">Tidak Lulus</span>
                        <?php endif; ?>
                    </td>
                </tr>
                <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</body>

</html>