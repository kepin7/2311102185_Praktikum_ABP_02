import 'package:firebase_messaging/firebase_messaging.dart';
import 'package:flutter/material.dart';
import 'package:flutter_local_notifications/flutter_local_notifications.dart';

class FcmService {
  FcmService._();

  static final FcmService instance = FcmService._();

  final FirebaseMessaging _messaging = FirebaseMessaging.instance;
  final FlutterLocalNotificationsPlugin _localNotifications =
      FlutterLocalNotificationsPlugin();

  static const String _channelId = 'todo_fcm_channel';
  static const String _channelName = 'Todo FCM Notifications';
  static const String _channelDescription =
      'Channel untuk menampilkan notifikasi Firebase Cloud Messaging.';

  String? _token;
  String? get token => _token;

  Future<void> initLocalNotifications() async {
    const androidInitializationSettings =
        AndroidInitializationSettings('@mipmap/ic_launcher');

    const initializationSettings = InitializationSettings(
      android: androidInitializationSettings,
    );

    await _localNotifications.initialize(initializationSettings);

    const androidNotificationChannel = AndroidNotificationChannel(
      _channelId,
      _channelName,
      description: _channelDescription,
      importance: Importance.high,
    );

    await _localNotifications
        .resolvePlatformSpecificImplementation<
            AndroidFlutterLocalNotificationsPlugin>()
        ?.createNotificationChannel(androidNotificationChannel);
  }

  Future<void> requestPermissionAndToken() async {
    final settings = await _messaging.requestPermission(
      alert: true,
      badge: true,
      sound: true,
    );

    debugPrint('Status izin notifikasi: ${settings.authorizationStatus}');

    _token = await _messaging.getToken();
    debugPrint('FCM TOKEN: $_token');
  }

  Future<String?> getToken() async {
    _token ??= await _messaging.getToken();
    return _token;
  }

  void listenForegroundMessage() {
    FirebaseMessaging.onMessage.listen((RemoteMessage message) async {
      final notification = message.notification;

      if (notification == null) return;

      await _localNotifications.show(
        notification.hashCode,
        notification.title ?? 'Notifikasi',
        notification.body ?? '',
        const NotificationDetails(
          android: AndroidNotificationDetails(
            _channelId,
            _channelName,
            channelDescription: _channelDescription,
            importance: Importance.high,
            priority: Priority.high,
          ),
        ),
      );
    });

    FirebaseMessaging.onMessageOpenedApp.listen((RemoteMessage message) {
      debugPrint('Notifikasi dibuka: ${message.messageId}');
    });
  }
}
