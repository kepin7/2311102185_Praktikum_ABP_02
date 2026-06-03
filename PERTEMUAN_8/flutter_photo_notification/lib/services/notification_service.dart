import 'package:flutter_local_notifications/flutter_local_notifications.dart';

class NotificationService {
  static final FlutterLocalNotificationsPlugin _plugin =
      FlutterLocalNotificationsPlugin();

  /// Inisialisasi plugin notifikasi, dipanggil satu kali di main()
  static Future<void> init() async {
    const AndroidInitializationSettings androidSettings =
        AndroidInitializationSettings('@mipmap/ic_launcher');

    const InitializationSettings initSettings =
        InitializationSettings(android: androidSettings);

    await _plugin.initialize(initSettings);

    // Minta izin notifikasi (Android 13+). Pada Android versi lama,
    // implementasi ini akan bernilai null atau tidak membutuhkan izin runtime.
    await _plugin
        .resolvePlatformSpecificImplementation<
          AndroidFlutterLocalNotificationsPlugin
        >()
        ?.requestNotificationsPermission();
  }

  /// Tampilkan notifikasi setelah foto diambil atau dipilih
  static Future<void> showPhotoNotification({
    required bool fromCamera,
  }) async {
    const AndroidNotificationDetails androidDetails =
        AndroidNotificationDetails(
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
}
