import 'dart:io';

import 'package:flutter/material.dart';
import 'package:image_picker/image_picker.dart';

import '../main.dart';
import '../services/notification_service.dart';
import '../widgets/action_button.dart';
import '../widgets/header_section.dart';
import '../widgets/photo_preview.dart';
import 'camera_page.dart';

class HomePage extends StatefulWidget {
  const HomePage({super.key});

  @override
  State<HomePage> createState() => _HomePageState();
}

class _HomePageState extends State<HomePage>
    with SingleTickerProviderStateMixin {
  final ImagePicker _picker = ImagePicker();

  File? _selectedImage;
  bool _isLoading = false;

  late final AnimationController _animController;
  late final Animation<double> _fadeAnim;

  @override
  void initState() {
    super.initState();
    _animController = AnimationController(
      vsync: this,
      duration: const Duration(milliseconds: 600),
    );
    _fadeAnim = CurvedAnimation(
      parent: _animController,
      curve: Curves.easeInOut,
    );
  }

  @override
  void dispose() {
    _animController.dispose();
    super.dispose();
  }

  Future<void> _openCamera() async {
    if (cameras.isEmpty) {
      _showSnackBar('Tidak ada kamera yang tersedia atau izin kamera belum diberikan.');
      return;
    }

    final String? imagePath = await Navigator.push<String>(
      context,
      MaterialPageRoute(
        builder: (_) => CameraPage(camera: cameras.first),
      ),
    );

    if (!mounted) return;

    if (imagePath != null && imagePath.isNotEmpty) {
      _setImage(File(imagePath));
      await NotificationService.showPhotoNotification(fromCamera: true);
    }
  }

  Future<void> _pickFromGallery() async {
    if (_isLoading) return;

    setState(() => _isLoading = true);

    try {
      final XFile? picked = await _picker.pickImage(
        source: ImageSource.gallery,
        imageQuality: 85,
      );

      if (!mounted) return;

      if (picked == null) {
        setState(() => _isLoading = false);
        return;
      }

      _setImage(File(picked.path));
      await NotificationService.showPhotoNotification(fromCamera: false);
    } catch (e) {
      if (!mounted) return;
      setState(() => _isLoading = false);
      _showSnackBar('Gagal memilih foto: $e');
    }
  }

  void _setImage(File file) {
    setState(() {
      _selectedImage = file;
      _isLoading = false;
    });
    _animController
      ..reset()
      ..forward();
  }

  void _showSnackBar(String message) {
    ScaffoldMessenger.of(context).showSnackBar(
      SnackBar(
        content: Text(message),
        behavior: SnackBarBehavior.floating,
        backgroundColor: const Color(0xFF2A2A4A),
      ),
    );
  }

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      appBar: AppBar(
        title: const Text(
          'Camera & Notifikasi',
          style: TextStyle(fontWeight: FontWeight.w600, letterSpacing: 0.5),
        ),
        centerTitle: true,
      ),
      body: SafeArea(
        child: SingleChildScrollView(
          padding: const EdgeInsets.symmetric(horizontal: 24, vertical: 20),
          child: Column(
            crossAxisAlignment: CrossAxisAlignment.stretch,
            children: [
              const HeaderSection(),
              const SizedBox(height: 32),
              ActionButton(
                icon: Icons.camera_alt_rounded,
                label: 'Buka Kamera',
                subtitle: 'Ambil foto langsung dari kamera',
                onTap: _isLoading ? null : _openCamera,
                color: const Color(0xFF4F46E5),
              ),
              const SizedBox(height: 16),
              ActionButton(
                icon: Icons.photo_library_rounded,
                label: 'Pilih dari Galeri',
                subtitle: 'Pilih foto yang sudah ada',
                onTap: _isLoading ? null : _pickFromGallery,
                color: const Color(0xFF0891B2),
              ),
              const SizedBox(height: 32),
              PhotoPreview(
                image: _selectedImage,
                isLoading: _isLoading,
                fadeAnim: _fadeAnim,
              ),
            ],
          ),
        ),
      ),
    );
  }
}
