import 'dart:io';

import 'package:flutter/material.dart';

class PhotoPreview extends StatelessWidget {
  final File? image;
  final bool isLoading;
  final Animation<double> fadeAnim;

  const PhotoPreview({
    super.key,
    required this.image,
    required this.isLoading,
    required this.fadeAnim,
  });

  @override
  Widget build(BuildContext context) {
    return Column(
      crossAxisAlignment: CrossAxisAlignment.start,
      children: [
        const Text(
          'PRATINJAU FOTO',
          style: TextStyle(
            color: Colors.white38,
            fontSize: 11,
            fontWeight: FontWeight.w600,
            letterSpacing: 1.2,
          ),
        ),
        const SizedBox(height: 10),
        Container(
          width: double.infinity,
          height: 300,
          clipBehavior: Clip.hardEdge,
          decoration: BoxDecoration(
            color: const Color(0xFF1A1A2E),
            borderRadius: BorderRadius.circular(16),
            border: Border.all(color: Colors.white.withOpacity(0.08)),
          ),
          child: _buildContent(),
        ),
      ],
    );
  }

  Widget _buildContent() {
    if (isLoading) {
      return const Center(
        child: CircularProgressIndicator(
          color: Color(0xFF818CF8),
          strokeWidth: 2.5,
        ),
      );
    }

    if (image == null) {
      return const _EmptyPlaceholder();
    }

    return FadeTransition(
      opacity: fadeAnim,
      child: Stack(
        fit: StackFit.expand,
        children: [
          Image.file(image!, fit: BoxFit.cover),
          const Positioned(
            bottom: 12,
            right: 12,
            child: _SuccessBadge(),
          ),
        ],
      ),
    );
  }
}

class _EmptyPlaceholder extends StatelessWidget {
  const _EmptyPlaceholder();

  @override
  Widget build(BuildContext context) {
    return Column(
      mainAxisAlignment: MainAxisAlignment.center,
      children: [
        Icon(Icons.image_outlined, size: 48, color: Colors.white.withOpacity(0.12)),
        const SizedBox(height: 12),
        Text(
          'Belum ada foto',
          style: TextStyle(color: Colors.white.withOpacity(0.3), fontSize: 14),
        ),
        const SizedBox(height: 4),
        Text(
          'Gunakan tombol di atas untuk memulai',
          style: TextStyle(color: Colors.white.withOpacity(0.18), fontSize: 12),
        ),
      ],
    );
  }
}

class _SuccessBadge extends StatelessWidget {
  const _SuccessBadge();

  @override
  Widget build(BuildContext context) {
    return Container(
      padding: const EdgeInsets.symmetric(horizontal: 10, vertical: 6),
      decoration: BoxDecoration(
        color: Colors.black54,
        borderRadius: BorderRadius.circular(8),
      ),
      child: const Row(
        mainAxisSize: MainAxisSize.min,
        children: [
          Icon(Icons.check_circle_rounded, color: Color(0xFF4ADE80), size: 14),
          SizedBox(width: 4),
          Text(
            'Berhasil',
            style: TextStyle(
              color: Colors.white,
              fontSize: 11,
              fontWeight: FontWeight.w500,
            ),
          ),
        ],
      ),
    );
  }
}
