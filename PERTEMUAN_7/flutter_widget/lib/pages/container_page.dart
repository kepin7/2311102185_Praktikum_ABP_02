import 'package:flutter/material.dart';
import '../widgets/section_title.dart';
import '../widgets/custom_app_bar.dart';

class ContainerPage extends StatelessWidget {
  const ContainerPage({super.key});

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      backgroundColor: const Color(0xFFF5F3EE),
      appBar: buildAppBar('Container'),
      body: SingleChildScrollView(
        padding: const EdgeInsets.all(20),
        child: Column(
          crossAxisAlignment: CrossAxisAlignment.start,
          children: [
            const SectionTitle('Container Dasar'),
            const SizedBox(height: 12),
            Container(
              width: double.infinity,
              height: 80,
              color: const Color(0xFF4C5C2D),
              child: const Center(
                child: Text(
                  'Container biasa — warna solid',
                  style: TextStyle(color: Colors.white, fontWeight: FontWeight.w600),
                ),
              ),
            ),
            const SizedBox(height: 16),
            const SectionTitle('Container dengan Dekorasi'),
            const SizedBox(height: 12),
            Container(
              width: double.infinity,
              height: 100,
              decoration: BoxDecoration(
                gradient: const LinearGradient(
                  colors: [Color(0xFF1B0C0C), Color(0xFF5C2D2D)],
                ),
                borderRadius: BorderRadius.circular(16),
                boxShadow: [
                  BoxShadow(
                    color: Colors.black.withValues(alpha: 0.2),
                    blurRadius: 8,
                    offset: const Offset(0, 4),
                  ),
                ],
              ),
              child: const Center(
                child: Text(
                  'Container dengan Gradient + Shadow',
                  style: TextStyle(
                    color: Colors.white,
                    fontWeight: FontWeight.bold,
                    fontSize: 15,
                  ),
                ),
              ),
            ),
            const SizedBox(height: 16),
            const SectionTitle('Container dengan Padding & Margin'),
            const SizedBox(height: 12),
            Container(
              margin: const EdgeInsets.symmetric(horizontal: 20),
              padding: const EdgeInsets.all(20),
              decoration: BoxDecoration(
                color: const Color(0xFF2D4A5C),
                borderRadius: BorderRadius.circular(12),
                border: Border.all(color: const Color(0xFF4A8FAA), width: 2),
              ),
              child: const Text(
                'Ini Container dengan margin & padding.\n'
                'margin: 20px horizontal\npadding: 20px semua sisi',
                style: TextStyle(color: Colors.white, height: 1.6),
              ),
            ),
            const SizedBox(height: 16),
            const SectionTitle('Row berisi beberapa Container'),
            const SizedBox(height: 12),
            Row(
              mainAxisAlignment: MainAxisAlignment.spaceEvenly,
              children: [
                _ColorBox(label: 'Merah', color: const Color(0xFFE53935)),
                _ColorBox(label: 'Hijau', color: const Color(0xFF43A047)),
                _ColorBox(label: 'Biru', color: const Color(0xFF1E88E5)),
                _ColorBox(label: 'Kuning', color: const Color(0xFFFDD835)),
              ],
            ),
          ],
        ),
      ),
    );
  }
}

class _ColorBox extends StatelessWidget {
  final String label;
  final Color color;

  const _ColorBox({required this.label, required this.color});

  @override
  Widget build(BuildContext context) {
    return Column(
      children: [
        Container(
          width: 70,
          height: 70,
          decoration: BoxDecoration(
            color: color,
            borderRadius: BorderRadius.circular(10),
          ),
        ),
        const SizedBox(height: 6),
        Text(label,
            style: const TextStyle(fontSize: 12, fontWeight: FontWeight.w600)),
      ],
    );
  }
}
