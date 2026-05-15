import 'package:flutter/material.dart';

PreferredSizeWidget buildAppBar(String title) {
  return AppBar(
    backgroundColor: const Color(0xFF1B0C0C),
    foregroundColor: Colors.white,
    title: Text(
      title,
      style: const TextStyle(
        fontWeight: FontWeight.w600,
        letterSpacing: 0.4,
      ),
    ),
    centerTitle: true,
  );
}
