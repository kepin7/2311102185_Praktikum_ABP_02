# Laporan Praktikum ABP — Camera, Media & Notifikasi

**Nama:** [Nama Kamu]  
**NIM:** 2311102185  
**Matkul:** Pemrograman Aplikasi Berbasis Platform  
**Topik:** Kamera, Galeri, dan Notifikasi Lokal  

---

## Daftar Isi

1. [Deskripsi Aplikasi](#deskripsi-aplikasi)
2. [Screenshot Hasil](#screenshot-hasil)
3. [Penjelasan Widget](#penjelasan-widget)
4. [Setup & Konfigurasi](#setup--konfigurasi)
5. [Struktur File](#struktur-file)

---

## Deskripsi Aplikasi

Aplikasi Flutter sederhana yang menggabungkan dua fitur utama:

1. **Camera & Media** — Mengambil foto langsung dari kamera atau memilih foto dari galeri menggunakan `camera` dan `image_picker` package.
2. **Notifikasi Lokal** — Setelah foto berhasil diambil atau dipilih, aplikasi secara otomatis menampilkan notifikasi lokal menggunakan `flutter_local_notifications`.

---

## Screenshot Hasil

> 📌 **Petunjuk:** Letakkan screenshot kamu di bawah masing-masing label sesuai kondisi yang ditampilkan.

---

### 1. Halaman Utama (Belum Ada Foto)

<!-- LETAKKAN SCREENSHOT HALAMAN UTAMA (KOSONG) DI SINI -->
<!-- Contoh: ![Halaman Utama](screenshots/home_empty.jpg) -->

```
[ SS halaman utama sebelum foto diambil/dipilih ]
```

---

### 2. Halaman Kamera (Live Preview)

<!-- LETAKKAN SCREENSHOT TAMPILAN KAMERA DI SINI -->
<!-- Contoh: ![Halaman Kamera](screenshots/camera_preview.jpg) -->

```
[ SS tampilan kamera saat live preview aktif ]
```

---

### 3. Foto Berhasil Diambil dari Kamera

<!-- LETAKKAN SCREENSHOT FOTO DARI KAMERA DI SINI -->
<!-- Contoh: ![Foto Kamera](screenshots/foto_kamera.jpg) -->

```
[ SS foto yang ditampilkan setelah ambil dari kamera ]
```

---

### 4. Foto Berhasil Dipilih dari Galeri

<!-- LETAKKAN SCREENSHOT FOTO DARI GALERI DI SINI -->
<!-- Contoh: ![Foto Galeri](screenshots/foto_galeri.jpg) -->

```
[ SS foto yang ditampilkan setelah pilih dari galeri ]
```

---

### 5. Notifikasi Muncul (Setelah Foto dari Kamera)

<!-- LETAKKAN SCREENSHOT NOTIFIKASI KAMERA DI SINI -->
<!-- Contoh: ![Notif Kamera](screenshots/notif_kamera.jpg) -->

```
[ SS notifikasi "Foto Berhasil Diambil!" di notification bar ]
```

---

### 6. Notifikasi Muncul (Setelah Foto dari Galeri)

<!-- LETAKKAN SCREENSHOT NOTIFIKASI GALERI DI SINI -->
<!-- Contoh: ![Notif Galeri](screenshots/notif_galeri.jpg) -->

```
[ SS notifikasi "Foto Berhasil Dipilih!" di notification bar ]
```

---

## Penjelasan Widget

### `main()` — Entry Point

```dart
Future<void> main() async {
  WidgetsFlutterBinding.ensureInitialized();
  _cameras = await availableCameras();
  await flutterLocalNotificationsPlugin.initialize(initSettings);
  runApp(const MyApp());
}
```

| Fungsi | Penjelasan |
|--------|------------|
| `WidgetsFlutterBinding.ensureInitialized()` | Memastikan Flutter binding siap sebelum memanggil metode native (kamera, notifikasi) |
| `availableCameras()` | Mengambil daftar semua kamera yang tersedia di perangkat (depan/belakang) |
| `flutterLocalNotificationsPlugin.initialize()` | Menginisialisasi plugin notifikasi dengan icon launcher default |

---

### `MyApp` — Root Widget

```dart
class MyApp extends StatelessWidget {
  @override
  Widget build(BuildContext context) {
    return MaterialApp(
      theme: ThemeData(colorScheme: ..., useMaterial3: true),
      home: const HomePage(),
    );
  }
}
```

**Widget yang digunakan:**

| Widget | Penjelasan |
|--------|------------|
| `MaterialApp` | Root widget yang menyediakan tema, navigasi, dan konfigurasi app secara global |
| `ThemeData` | Mendefinisikan tema visual (warna, font, komponen Material 3) |
| `ColorScheme.fromSeed` | Membuat skema warna otomatis dari satu warna seed dengan dukungan dark mode |

---

### `HomePage` — Halaman Utama

Widget `StatefulWidget` sebagai halaman utama yang menampilkan tombol aksi dan preview foto.

**State variables:**

| Variabel | Tipe | Fungsi |
|----------|------|--------|
| `_selectedImage` | `File?` | Menyimpan file foto yang dipilih/diambil |
| `_isLoading` | `bool` | Indikator loading saat memilih dari galeri |
| `_animController` | `AnimationController` | Mengontrol animasi fade-in saat foto muncul |
| `_fadeAnim` | `Animation<double>` | Animasi opacity (0.0 → 1.0) |

**Method penting:**

| Method | Penjelasan |
|--------|------------|
| `_openCamera()` | Navigasi ke `CameraCapturePage`, menerima path foto via `Navigator.pop()` |
| `_pickFromGallery()` | Membuka galeri menggunakan `ImagePicker`, mengambil hasil sebagai `XFile` |
| `showPhotoNotification()` | Memanggil fungsi global untuk menampilkan notifikasi lokal |

**Widget yang digunakan:**

| Widget | Penjelasan |
|--------|------------|
| `Scaffold` | Struktur dasar halaman dengan AppBar dan body |
| `SafeArea` | Menghindari konten masuk ke area status bar / notch |
| `SingleChildScrollView` | Memungkinkan halaman di-scroll jika konten melebihi layar |
| `Column` | Menyusun widget secara vertikal |
| `AnimationController` + `FadeTransition` | Animasi fade-in foto saat pertama kali ditampilkan |

---

### `_HeaderSection` — Bagian Header

Widget `StatelessWidget` yang menampilkan informasi singkat di bagian atas halaman.

| Widget | Penjelasan |
|--------|------------|
| `Container` | Kotak dengan gradient background, border, dan radius untuk efek card |
| `LinearGradient` | Gradien dua warna dari kiri-atas ke kanan-bawah |
| `Row` | Menyusun icon dan teks secara horizontal |
| `Icon` | Ikon kamera dari Material Icons |

---

### `_ActionButton` — Tombol Aksi

Widget `StatelessWidget` custom yang merepresentasikan tombol interaktif.

```dart
_ActionButton(
  icon: Icons.camera_alt_rounded,
  label: 'Buka Kamera',
  subtitle: 'Ambil foto langsung dari kamera',
  onTap: _openCamera,
  color: Color(0xFF4F46E5),
)
```

| Widget | Penjelasan |
|--------|------------|
| `Material` + `InkWell` | Kombinasi untuk efek ripple saat tombol ditekan |
| `AnimatedContainer` | Container dengan transisi animasi saat properti berubah (misal: disabled state) |
| `Row` | Menyusun icon, teks, dan arrow secara horizontal |
| `Icon(Icons.arrow_forward_ios_rounded)` | Indikator arah navigasi di sisi kanan tombol |

---

### `_PreviewArea` — Area Preview Foto

Widget `StatelessWidget` yang menampilkan kondisi foto: kosong, loading, atau menampilkan foto.

| Kondisi | Widget yang Ditampilkan |
|---------|------------------------|
| `isLoading == true` | `CircularProgressIndicator` |
| `image == null` | `_EmptyPlaceholder` (placeholder teks + icon) |
| `image != null` | `FadeTransition` → `Image.file()` |

| Widget | Penjelasan |
|--------|------------|
| `FadeTransition` | Menerapkan animasi opacity yang dikontrol oleh `Animation<double>` |
| `Image.file()` | Menampilkan gambar dari path file lokal di perangkat |
| `Stack` | Menumpuk widget (foto + badge "Berhasil") di posisi yang sama |
| `Positioned` | Menempatkan badge di sudut kanan bawah foto |
| `ClipRect` / `clipBehavior: Clip.hardEdge` | Memotong konten agar tidak keluar dari border radius container |

---

### `CameraCapturePage` — Halaman Kamera

Widget `StatefulWidget` untuk menampilkan live preview kamera dan tombol shutter.

**Setup:**
```dart
_controller = CameraController(widget.camera, ResolutionPreset.high);
_initFuture = _controller.initialize();
```

| Widget | Penjelasan |
|--------|------------|
| `CameraPreview` | Menampilkan live feed dari kamera secara real-time (dari package `camera`) |
| `FutureBuilder` | Menunggu inisialisasi kamera selesai sebelum menampilkan preview |
| `Stack` | Menumpuk preview kamera dengan overlay tombol back dan shutter |
| `GestureDetector` | Mendeteksi tap pada tombol shutter dan tombol kembali |
| `AnimatedContainer` | Memberikan efek visual saat tombol shutter ditekan |

**Alur pengambilan foto:**
```
tap shutter → _takePicture() → controller.takePicture() → Navigator.pop(context, image.path)
                                                              ↓
                                                   HomePage._openCamera() menerima path
                                                   → setState → showPhotoNotification()
```

---

### `showPhotoNotification()` — Fungsi Notifikasi

```dart
Future<void> showPhotoNotification({required bool fromCamera}) async {
  const AndroidNotificationDetails androidDetails = AndroidNotificationDetails(
    'photo_channel',      // Channel ID (unik)
    'Photo Notifications', // Channel Name
    importance: Importance.high,
    priority: Priority.high,
  );
  await flutterLocalNotificationsPlugin.show(
    id: 0,
    title: fromCamera ? '📸 Foto Berhasil Diambil!' : '🖼️ Foto Berhasil Dipilih!',
    body: '...',
    notificationDetails: NotificationDetails(android: androidDetails),
  );
}
```

| Parameter | Penjelasan |
|-----------|------------|
| `channel_id` (`'photo_channel'`) | ID unik untuk notification channel (wajib di Android 8+) |
| `Importance.high` | Notifikasi muncul di bagian atas layar sebagai heads-up notification |
| `Priority.high` | Prioritas tinggi agar notifikasi segera disampaikan |
| `id: 0` | ID notifikasi; nilai sama = notifikasi lama diganti (tidak menumpuk) |
| `fromCamera` | Parameter bool untuk membedakan isi pesan notifikasi |

---

## Setup & Konfigurasi

### 1. Tambahkan Dependencies

Jalankan di terminal root project:

```bash
flutter pub add camera
flutter pub add image_picker
flutter pub add flutter_local_notifications
```

Atau gunakan `pubspec.yaml`:

```yaml
dependencies:
  camera: ^0.11.0+2
  image_picker: ^1.1.2
  flutter_local_notifications: ^17.2.4
```

Lalu jalankan:
```bash
flutter pub get
```

---

### 2. Konfigurasi AndroidManifest.xml

File: `android/app/src/main/AndroidManifest.xml`

Tambahkan permission berikut **di atas tag `<application>`**:

```xml
<uses-permission android:name="android.permission.CAMERA" />
<uses-permission android:name="android.permission.READ_EXTERNAL_STORAGE"
    android:maxSdkVersion="32" />
<uses-permission android:name="android.permission.READ_MEDIA_IMAGES" />
<uses-permission android:name="android.permission.POST_NOTIFICATIONS" />
<uses-permission android:name="android.permission.VIBRATE" />
```

Tambahkan `<queries>` untuk Android 11+ (sebelum `</manifest>`):

```xml
<queries>
    <intent>
        <action android:name="android.media.action.IMAGE_CAPTURE" />
    </intent>
    <intent>
        <action android:name="android.intent.action.GET_CONTENT" />
    </intent>
</queries>
```

---

### 3. Konfigurasi build.gradle.kts (App Level)

File: `android/app/build.gradle.kts`

```kotlin
android {
    compileOptions {
        sourceCompatibility = JavaVersion.VERSION_17
        targetCompatibility = JavaVersion.VERSION_17
        isCoreLibraryDesugaringEnabled = true   // ← wajib untuk flutter_local_notifications
    }
    defaultConfig {
        minSdk = 21
        targetSdk = 30   // Android 11
        multiDexEnabled = true
    }
}

dependencies {
    coreLibraryDesugaring("com.android.tools:desugar_jdk_libs:2.1.4")
}
```

> ⚠️ **JDK 23:** Meski kamu menggunakan JDK 23, `sourceCompatibility` dan `targetCompatibility` tetap diset ke `VERSION_17` karena Android Gradle Plugin (AGP) saat ini belum sepenuhnya mendukung JDK 23 sebagai target. JDK 23 akan tetap digunakan sebagai **runtime** untuk build tool-nya.

---

### 4. Jalankan Aplikasi

```bash
# Pastikan HP sudah terhubung via USB dengan USB Debugging aktif
flutter devices

# Jalankan di device
flutter run
```

---

## Struktur File

```
praktikum_camera_notif/
├── lib/
│   ├── main.dart                        ← Entry point, inisialisasi kamera & notifikasi
│   ├── pages/
│   │   ├── home_page.dart               ← Halaman utama (tombol + preview foto)
│   │   └── camera_page.dart             ← Halaman live kamera & shutter
│   ├── widgets/
│   │   ├── action_button.dart           ← Tombol aksi (kamera / galeri)
│   │   ├── header_section.dart          ← Banner info di bagian atas
│   │   └── photo_preview.dart           ← Area pratinjau foto + badge sukses
│   └── services/
│       └── notification_service.dart    ← Logika inisialisasi & tampilkan notifikasi
├── android/
│   └── app/
│       ├── src/main/
│       │   └── AndroidManifest.xml      ← Permission & konfigurasi Android
│       └── build.gradle.kts             ← Gradle config (desugaring, SDK target)
├── pubspec.yaml                         ← Dependencies Flutter
└── README.md                            ← Laporan ini
```

---

## Referensi

- [camera package — pub.dev](https://pub.dev/packages/camera)
- [image_picker package — pub.dev](https://pub.dev/packages/image_picker)
- [flutter_local_notifications package — pub.dev](https://pub.dev/packages/flutter_local_notifications)
- [Android Notification Guide — developer.android.com](https://developer.android.com/develop/ui/views/notifications)
- Kode referensi: [kode-Praktikum-ABP-2025](https://github.com/wafanakha/kode-Praktikum-ABP-2025)
