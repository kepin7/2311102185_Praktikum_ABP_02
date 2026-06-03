import 'package:flutter_test/flutter_test.dart';

import 'package:flutter_photo_notification/main.dart';

void main() {
  testWidgets('menampilkan halaman utama aplikasi', (WidgetTester tester) async {
    await tester.pumpWidget(const MyApp());

    expect(find.text('Camera & Notifikasi'), findsOneWidget);
    expect(find.text('Buka Kamera'), findsOneWidget);
    expect(find.text('Pilih dari Galeri'), findsOneWidget);
    expect(find.text('PRATINJAU FOTO'), findsOneWidget);
  });
}
