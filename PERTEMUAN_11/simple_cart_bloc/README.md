# Aplikasi Keranjang Belanja dengan Cubit (flutter_bloc)

---

## 1. Deskripsi Aplikasi

Aplikasi ini adalah simulasi kasir kedai kopi sederhana yang terdiri dari:

- **Halaman Daftar Produk** — menampilkan 6 produk (kopi & makanan ringan) lengkap dengan nama, kategori, dan harga.
- **Halaman Keranjang** — menampilkan produk yang sudah ditambahkan, jumlah (quantity) per produk, serta total harga.
- **Badge jumlah item** pada ikon keranjang di AppBar yang ter-update secara *real-time* setiap kali produk ditambah/dikurangi.

State management sepenuhnya menggunakan **Cubit** dari package `flutter_bloc` (bagian dari keluarga BLoC, versi yang lebih sederhana karena tanpa Event, hanya berisi method biasa yang memanggil `emit()`).

![alt text](image-2.png)

![alt text](image-3.png)

![alt text](image-4.png)

---

## 2. Struktur Folder

```
lib/
 ├── main.dart                  # entry point + BlocProvider
 ├── models/
 │    └── product.dart          # model data Product
 ├── data/
 │    └── products.dart         # daftar 6 produk statis
 ├── cubit/
 │    ├── cart_cubit.dart        # logika bisnis keranjang (Cubit)
 │    └── cart_state.dart        # CartState & CartItem
 ├── screens/
 │    ├── home_screen.dart       # halaman daftar produk
 │    └── cart_screen.dart       # halaman keranjang
 └── widgets/
      └── product_card.dart     # kartu produk + tombol tambah/kurang
```

---

## 3. Penjelasan Implementasi Cubit

### 3.1 CartState — Representasi State

`CartState` (di `cart_state.dart`) menyimpan satu `List<CartItem>`, di mana setiap `CartItem` adalah pasangan `Product` + `quantity`. Dari list ini, dua getter dihitung secara otomatis:

- `totalItemCount` → akumulasi quantity seluruh item (dipakai untuk badge keranjang).
- `totalPrice` → total harga seluruh item.

Karena hanya ada **satu bentuk state** (selalu berupa daftar item, baik kosong maupun terisi), tidak diperlukan banyak subclass state seperti pada BLoC dengan Event (`CartLoading`, `CartLoaded`, dst). Ini salah satu alasan Cubit dipilih: lebih ringkas untuk kasus penggunaan ini.

### 3.2 CartCubit — Logika Bisnis

`CartCubit extends Cubit<CartState>` (di `cart_cubit.dart`) memiliki tiga method utama:

| Method | Fungsi |
|---|---|
| `addToCart(product)` | Jika produk sudah ada di keranjang, quantity-nya ditambah 1. Jika belum ada, ditambahkan sebagai item baru dengan quantity 1. |
| `removeFromCart(product)` | Mengurangi quantity 1. Jika quantity tersisa 1, item dihapus sepenuhnya dari list. |
| `clearCart()` | Mengembalikan state ke `CartState()` kosong. |

Setiap method membuat *copy* baru dari list item, memodifikasinya, lalu memanggil `emit(CartState(items: items))`. Pemanggilan `emit()` inilah yang memberi tahu semua widget pendengar untuk membangun ulang (rebuild) tampilannya dengan data terbaru.

### 3.3 BlocProvider — Menyediakan Cubit ke Widget Tree

Di `main.dart`, `BlocProvider` membungkus `MaterialApp` dan membuat satu instance `CartCubit` yang dapat diakses oleh seluruh halaman (`HomeScreen` dan `CartScreen`) melalui `context.read<CartCubit>()`. Dengan ini, state keranjang tetap konsisten walau pengguna berpindah halaman.

```dart
BlocProvider(
  create: (_) => CartCubit(),
  child: MaterialApp(
    home: const HomeScreen(),
  ),
)
```

### 3.4 BlocBuilder — Menampilkan State secara Reaktif

`BlocBuilder<CartCubit, CartState>` digunakan di tiga tempat:

1. **Badge jumlah item** di AppBar (`home_screen.dart`) — hanya membangun ulang lingkaran kecil badge, bukan seluruh AppBar, sehingga efisien.
2. **Tombol "Tambah" / stepper quantity** di setiap `ProductCard` (`product_card.dart`) — menampilkan tombol "Tambah" jika produk belum ada di keranjang, atau stepper `[- qty +]` jika sudah ada.
3. **Daftar isi keranjang & ringkasan total** di `cart_screen.dart` — menampilkan list item beserta total bayar yang otomatis berubah setiap `emit()` terjadi.

Karena `BlocBuilder` hanya rebuild widget yang membungkusnya (bukan seluruh halaman), aplikasi tetap efisien meski state berubah cukup sering (setiap kali tombol tambah/kurang ditekan).

### 3.5 Alur Data Singkat

```
User tekan "Tambah" pada ProductCard
        │
        ▼
context.read<CartCubit>().addToCart(product)
        │
        ▼
CartCubit memproses list item baru → emit(CartState baru)
        │
        ▼
Semua BlocBuilder<CartCubit, CartState> yang aktif otomatis rebuild
   (badge keranjang, stepper di ProductCard, halaman CartScreen)
```

---

## 4. Kesimpulan

Cubit terbukti cukup untuk kasus keranjang belanja sederhana ini karena hanya melibatkan operasi tambah/kurang/hapus item tanpa kebutuhan event yang kompleks. Pemisahan `CartState` (data) dan `CartCubit` (logika) membuat kode lebih mudah dibaca, diuji, dan dikembangkan lebih lanjut (misalnya menambahkan diskon, validasi stok, atau penyimpanan ke local storage).
