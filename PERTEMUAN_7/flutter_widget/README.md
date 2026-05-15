## Daftar Widget

| No | Widget | Deskripsi Singkat |
|----|--------|-------------------|
| 1 | Container | Kotak berwarna dengan dekorasi |
| 2 | GridView | Tampilan grid 2 kolom |
| 3 | ListView | List statis 3 item |
| 4 | ListView.builder | List dinamis dari array data |
| 5 | ListView.separated | List dengan garis pembatas |
| 6 | Stack | Tampilan widget bertumpuk |

---

## Home Page

<img width="397" height="832" alt="image" src="https://github.com/user-attachments/assets/e7510b90-ad25-4a0b-a013-1915cce4260c" />

Halaman utama berisi navigasi ke setiap demo widget. Menggunakan `ListView.separated` untuk menampilkan menu navigasi dengan separator antar item.

---

## 1. Container

<img width="400" height="835" alt="image" src="https://github.com/user-attachments/assets/bda77282-512f-433b-9604-f4b4822b3d55" />

**Container** adalah widget dasar di Flutter yang digunakan untuk menampilkan kotak dengan berbagai properti dekorasi.

**Yang ditampilkan:**
- Container warna solid
- Container dengan gradient dan shadow
- Container dengan padding dan margin
- Row berisi beberapa Container berwarna

**Properti utama yang digunakan:**
```dart
Container(
  width: double.infinity,
  height: 100,
  decoration: BoxDecoration(
    color: Colors.green,
    borderRadius: BorderRadius.circular(12),
    boxShadow: [...],
  ),
)
```

---

## 2. GridView

<img width="395" height="839" alt="image" src="https://github.com/user-attachments/assets/5beca03b-6c8a-4986-bbf0-5239b2fe356f" />

**GridView** adalah widget untuk menampilkan item dalam format grid (baris dan kolom).

**Yang ditampilkan:**
- Grid 2 kolom berisi 8 item buah
- Setiap item menampilkan emoji, nama buah, dan nomor urut

**Properti utama yang digunakan:**
```dart
GridView.builder(
  gridDelegate: SliverGridDelegateWithFixedCrossAxisCount(
    crossAxisCount: 2,       // jumlah kolom
    crossAxisSpacing: 12,    // jarak antar kolom
    mainAxisSpacing: 12,     // jarak antar baris
  ),
  itemCount: items.length,
  itemBuilder: (context, index) { ... },
)
```

---

## 3. ListView (Statis)

<img width="398" height="834" alt="image" src="https://github.com/user-attachments/assets/b80d071f-a3f2-4a9b-8b0b-c2bfa4096f08" />

**ListView** statis digunakan untuk menampilkan sejumlah item yang sudah ditentukan langsung di dalam widget tree.

**Yang ditampilkan:**
- 3 item statis berlabel A, B, dan C
- Setiap item menggunakan widget `StaticTile` custom

**Properti utama yang digunakan:**
```dart
ListView(
  children: [
    StaticTile(label: 'A', ...),
    StaticTile(label: 'B', ...),
    StaticTile(label: 'C', ...),
  ],
)
```

---

## 4. ListView.builder

<img width="398" height="835" alt="image" src="https://github.com/user-attachments/assets/c0bff298-9b77-4aa7-bf8f-901fc9ed7d2d" />

**ListView.builder** digunakan untuk menampilkan list secara dinamis dari sebuah array data. Cocok digunakan ketika jumlah item banyak atau berasal dari sumber data eksternal.

**Yang ditampilkan:**
- 7 data mahasiswa dari array `mahasiswaList`
- Setiap item menampilkan nama, NIM, dan program studi

**Properti utama yang digunakan:**
```dart
ListView.builder(
  itemCount: mahasiswaList.length,
  itemBuilder: (context, index) {
    final m = mahasiswaList[index];
    return Card(...);
  },
)
```

---

## 5. ListView.separated

<img width="396" height="832" alt="image" src="https://github.com/user-attachments/assets/6f6e4110-81eb-46e7-ac04-36b3a8ead39a" />

**ListView.separated** sama seperti `ListView.builder` namun memiliki `separatorBuilder` untuk menampilkan pemisah (separator) di antara setiap item.

**Yang ditampilkan:**
- 8 menu kantin dengan harga
- Garis `Divider` sebagai pemisah antar item

**Properti utama yang digunakan:**
```dart
ListView.separated(
  itemCount: menuKantin.length,
  separatorBuilder: (context, index) => Divider(
    thickness: 1,
    color: Color(0xFFEEEEEE),
  ),
  itemBuilder: (context, index) { ... },
)
```

---

## 6. Stack

<img width="398" height="833" alt="image" src="https://github.com/user-attachments/assets/59595dbd-6afa-4b07-a686-5532d3b87312" />

**Stack** adalah widget yang menumpuk beberapa widget di atas satu sama lain. Posisi setiap child dapat diatur menggunakan widget `Positioned`.

**Yang ditampilkan:**
- Demo 1: Tiga kotak Container bertumpuk
- Demo 2: Card dengan badge notifikasi di pojok
- Demo 3: Teks overlay di atas gradient background

**Properti utama yang digunakan:**
```dart
Stack(
  children: [
    Container(...),          // layer paling bawah
    Positioned(
      top: 10,
      left: 10,
      child: Container(...), // layer tengah
    ),
    Positioned(
      bottom: 16,
      left: 16,
      child: Text(...),      // layer paling atas
    ),
  ],
)
```

---

## Struktur Project

```
lib/
├── main.dart
├── pages/
│   ├── home_page.dart
│   ├── container_page.dart
│   ├── gridview_page.dart
│   ├── listview_page.dart
│   ├── listview_builder_page.dart
│   ├── listview_separated_page.dart
│   └── stack_page.dart
├── widgets/
│   ├── custom_app_bar.dart
│   ├── section_title.dart
│   └── static_tile.dart
└── data/
    ├── mahasiswa_data.dart
    └── menu_data.dart
```
