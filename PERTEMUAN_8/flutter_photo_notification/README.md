## Deskripsi Aplikasi

Aplikasi Flutter sederhana yang menggabungkan dua fitur utama:

1. **Camera & Media** — Mengambil foto langsung dari kamera atau memilih foto dari galeri menggunakan `camera` dan `image_picker` package.
2. **Notifikasi Lokal** — Setelah foto berhasil diambil atau dipilih, aplikasi secara otomatis menampilkan notifikasi lokal menggunakan `flutter_local_notifications`.

### 1. Halaman Utama (Belum Ada Foto)

<img width="1080" height="2400" alt="image" src="https://github.com/user-attachments/assets/a39e2ea8-61a0-428f-b139-c840dabd3f81" />

---

### 2. Halaman Kamera (Live Preview)

<img width="720" height="1600" alt="image" src="https://github.com/user-attachments/assets/c8e98d8b-0bfd-46b0-9b28-802abea69b84" />

---

### 3. Foto Berhasil Diambil dari Kamera

<img width="720" height="1600" alt="image" src="https://github.com/user-attachments/assets/06cb1fb6-2e0e-4b0d-9903-22c6deb74d4a" />

---

### 4. Foto Berhasil Dipilih dari Galeri

<img width="720" height="1600" alt="image" src="https://github.com/user-attachments/assets/43dd80af-65f0-4c2a-9cdb-fb07d6eec660" />

---

### 5. Notifikasi Muncul (Setelah Foto dari Kamera)

<img width="574" height="275" alt="image" src="https://github.com/user-attachments/assets/e38e65e0-b7cc-4389-ab68-0196f738be69" />

---

### 6. Notifikasi Muncul (Setelah Foto dari Galeri)

<img width="684" height="321" alt="image" src="https://github.com/user-attachments/assets/ec735f4c-d5af-4e4c-8c3a-23b970cd6077" />

---

## Penjelasan Widget

### `main()` — Entry Point

```dart
List<CameraDescription> cameras = <CameraDescription>[];

Future<void> main() async {
  WidgetsFlutterBinding.ensureInitialized();

  try {
    cameras = await availableCameras();
  } catch (_) {
    cameras = <CameraDescription>[];
  }

  await NotificationService.init();
  runApp(const MyApp());
}
```

| Fungsi | Penjelasan |
|--------|------------|
| `WidgetsFlutterBinding.ensureInitialized()` | Memastikan Flutter binding siap sebelum memanggil fitur native seperti kamera dan notifikasi |
| `availableCameras()` | Mengambil daftar kamera yang tersedia pada perangkat dan menyimpannya ke variabel global `cameras` |
| `try-catch` pada kamera | Mencegah aplikasi langsung crash jika kamera tidak tersedia atau izin kamera belum diberikan |
| `NotificationService.init()` | Menginisialisasi plugin notifikasi lokal dan meminta izin notifikasi pada Android 13+ |
| `runApp(const MyApp())` | Menjalankan aplikasi Flutter dengan root widget `MyApp` |

---

### `MyApp` — Root Widget

```dart
class MyApp extends StatelessWidget {
  const MyApp({super.key});

  @override
  Widget build(BuildContext context) {
    return MaterialApp(
      debugShowCheckedModeBanner: false,
      title: 'Camera & Notifikasi',
      theme: ThemeData(
        colorScheme: ColorScheme.fromSeed(
          seedColor: const Color(0xFF1A1A2E),
          brightness: Brightness.dark,
        ),
        useMaterial3: true,
      ),
      home: const HomePage(),
    );
  }
}
```

**Widget yang digunakan:**

| Widget | Penjelasan |
|--------|------------|
| `MaterialApp` | Root widget yang menyediakan tema, navigasi, dan konfigurasi aplikasi secara global |
| `ThemeData` | Mendefinisikan tema visual aplikasi, termasuk warna dasar, mode gelap, AppBar, dan Material 3 |
| `ColorScheme.fromSeed` | Membuat skema warna otomatis dari satu warna utama atau seed color |
| `HomePage` | Halaman utama aplikasi yang menampilkan tombol kamera, tombol galeri, dan preview foto |

---

### `HomePage` — Halaman Utama

Widget `StatefulWidget` sebagai halaman utama yang menampilkan tombol aksi dan preview foto.

**State variables:**

| Variabel | Tipe | Fungsi |
|----------|------|--------|
| `_picker` | `ImagePicker` | Objek untuk membuka galeri dan memilih gambar dari perangkat |
| `_selectedImage` | `File?` | Menyimpan file foto yang dipilih dari galeri atau diambil dari kamera |
| `_isLoading` | `bool` | Indikator loading saat proses memilih foto dari galeri sedang berjalan |
| `_animController` | `AnimationController` | Mengontrol animasi fade-in saat foto berhasil ditampilkan |
| `_fadeAnim` | `Animation<double>` | Animasi opacity dari 0.0 ke 1.0 untuk preview foto |

**Method penting:**

| Method | Penjelasan |
|--------|------------|
| `_openCamera()` | Mengecek ketersediaan kamera, membuka `CameraPage`, menerima path foto dari `Navigator.pop()`, lalu menampilkan notifikasi |
| `_pickFromGallery()` | Membuka galeri menggunakan `ImagePicker`, mengambil hasil sebagai `XFile`, lalu menampilkan foto dan notifikasi |
| `_setImage(File file)` | Mengubah state `_selectedImage`, menghentikan loading, dan menjalankan animasi preview foto |
| `_showSnackBar(String message)` | Menampilkan pesan singkat jika kamera tidak tersedia atau proses memilih foto gagal |
| `NotificationService.showPhotoNotification()` | Memanggil service untuk menampilkan notifikasi setelah foto berhasil diambil atau dipilih |

**Widget yang digunakan:**

| Widget | Penjelasan |
|--------|------------|
| `Scaffold` | Struktur dasar halaman dengan AppBar dan body |
| `SafeArea` | Menghindari konten masuk ke area status bar atau notch |
| `SingleChildScrollView` | Memungkinkan halaman di-scroll jika konten melebihi tinggi layar |
| `Column` | Menyusun komponen halaman secara vertikal |
| `HeaderSection` | Menampilkan banner informasi di bagian atas halaman |
| `ActionButton` | Tombol custom untuk membuka kamera dan memilih foto dari galeri |
| `PhotoPreview` | Area untuk menampilkan kondisi kosong, loading, atau foto yang sudah dipilih |

---

### `HeaderSection` — Bagian Header

Widget `StatelessWidget` yang menampilkan informasi singkat di bagian atas halaman utama.

| Widget | Penjelasan |
|--------|------------|
| `Container` | Kotak dengan gradient background, border, padding, dan radius untuk efek card |
| `LinearGradient` | Gradien warna dari kiri atas ke kanan bawah |
| `Row` | Menyusun ikon dan teks secara horizontal |
| `Icon(Icons.photo_camera_rounded)` | Ikon kamera yang menggambarkan fitur utama aplikasi |
| `Text` | Menampilkan judul `Ambil & Pilih Foto` dan deskripsi singkat bahwa notifikasi muncul otomatis setelah foto berhasil |

---

### `ActionButton` — Tombol Aksi

Widget `StatelessWidget` custom yang merepresentasikan tombol interaktif untuk membuka kamera atau memilih foto dari galeri.

```dart
ActionButton(
  icon: Icons.camera_alt_rounded,
  label: 'Buka Kamera',
  subtitle: 'Ambil foto langsung dari kamera',
  onTap: _isLoading ? null : _openCamera,
  color: const Color(0xFF4F46E5),
)
```

| Widget | Penjelasan |
|--------|------------|
| `Material` + `InkWell` | Kombinasi untuk memberi efek ripple saat tombol ditekan |
| `AnimatedContainer` | Container dengan transisi animasi saat kondisi tombol berubah, misalnya ketika disabled |
| `Row` | Menyusun icon, teks, dan arrow secara horizontal |
| `Icon` | Menampilkan ikon sesuai aksi, misalnya kamera atau galeri |
| `Icon(Icons.arrow_forward_ios_rounded)` | Indikator arah navigasi di sisi kanan tombol |

---

### `PhotoPreview` — Area Preview Foto

Widget `StatelessWidget` yang menampilkan kondisi foto: kosong, loading, atau menampilkan foto.

| Kondisi | Widget yang Ditampilkan |
|---------|------------------------|
| `isLoading == true` | `CircularProgressIndicator` |
| `image == null` | `_EmptyPlaceholder` berisi icon dan teks `Belum ada foto` |
| `image != null` | `FadeTransition` yang menampilkan `Image.file()` dan badge `Berhasil` |

| Widget | Penjelasan |
|--------|------------|
| `FadeTransition` | Menerapkan animasi opacity yang dikontrol oleh `Animation<double>` |
| `Image.file()` | Menampilkan gambar dari path file lokal di perangkat |
| `Stack` | Menumpuk foto dan badge `Berhasil` dalam satu area preview |
| `Positioned` | Menempatkan badge di sudut kanan bawah foto |
| `clipBehavior: Clip.hardEdge` | Memotong gambar agar mengikuti bentuk container dengan border radius |

---

### `CameraPage` — Halaman Kamera

Widget `StatefulWidget` untuk menampilkan live preview kamera dan tombol shutter.

**Setup:**
```dart
_controller = CameraController(
  widget.camera,
  ResolutionPreset.high,
  enableAudio: false,
);
_initFuture = _controller.initialize();
```

| Widget | Penjelasan |
|--------|------------|
| `CameraController` | Mengontrol kamera yang digunakan untuk preview dan pengambilan foto |
| `CameraPreview` | Menampilkan live feed dari kamera secara real-time dari package `camera` |
| `FutureBuilder` | Menunggu proses inisialisasi kamera selesai sebelum menampilkan preview |
| `Stack` | Menumpuk preview kamera dengan overlay tombol kembali dan tombol shutter |
| `GestureDetector` | Mendeteksi tap pada tombol shutter dan tombol kembali |
| `AnimatedContainer` | Memberikan efek visual pada tombol shutter, terutama saat proses mengambil foto |
| `_CameraErrorView` | Tampilan alternatif jika kamera gagal dibuka atau izin kamera belum diberikan |

**Alur pengambilan foto:**
```
tap shutter → _takePicture() → _controller.takePicture() → Navigator.pop(context, image.path)
                                                                  ↓
                                                       HomePage._openCamera() menerima path
                                                       → _setImage(File(path))
                                                       → NotificationService.showPhotoNotification(fromCamera: true)
```

---

### `NotificationService.showPhotoNotification()` — Fungsi Notifikasi

```dart
static Future<void> showPhotoNotification({
  required bool fromCamera,
}) async {
  const AndroidNotificationDetails androidDetails = AndroidNotificationDetails(
    'photo_channel',
    'Photo Notifications',
    channelDescription: 'Notifikasi setelah mengambil atau memilih foto',
    importance: Importance.high,
    priority: Priority.high,
    ticker: 'foto berhasil',
    icon: '@mipmap/ic_launcher',
  );

  await _plugin.show(
    DateTime.now().millisecondsSinceEpoch ~/ 1000,
    fromCamera ? '📸 Foto Berhasil Diambil!' : '🖼️ Foto Berhasil Dipilih!',
    fromCamera
        ? 'Foto dari kamera sudah siap ditampilkan.'
        : 'Foto dari galeri sudah siap ditampilkan.',
    const NotificationDetails(android: androidDetails),
  );
}
```

| Parameter | Penjelasan |
|-----------|------------|
| `photo_channel` | ID unik untuk notification channel pada Android 8+ |
| `Photo Notifications` | Nama channel notifikasi yang digunakan aplikasi |
| `channelDescription` | Deskripsi channel untuk menjelaskan fungsi notifikasi |
| `Importance.high` | Membuat notifikasi memiliki tingkat kepentingan tinggi |
| `Priority.high` | Membuat notifikasi segera ditampilkan oleh sistem |
| `DateTime.now().millisecondsSinceEpoch ~/ 1000` | ID notifikasi dinamis agar notifikasi baru tidak selalu menimpa notifikasi sebelumnya |
| `fromCamera` | Parameter boolean untuk membedakan judul dan isi notifikasi kamera atau galeri |

---
