import 'package:flutter/material.dart';
import '../widgets/custom_app_bar.dart';
import '../widgets/section_title.dart';
import '../widgets/static_tile.dart';

class ListViewPage extends StatelessWidget {
  const ListViewPage({super.key});

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      backgroundColor: const Color(0xFFF5F3EE),
      appBar: buildAppBar('ListView (Statis)'),
      body: Padding(
        padding: const EdgeInsets.all(16),
        child: Column(
          crossAxisAlignment: CrossAxisAlignment.start,
          children: [
            const SectionTitle('3 Item Statis: A, B, C'),
            const SizedBox(height: 12),
            Expanded(
              child: ListView(
                children: [
                  StaticTile(
                    label: 'A',
                    title: 'Item A — Statis',
                    subtitle: 'Ini adalah item pertama dalam ListView statis.',
                    color: Color(0xFF4C5C2D),
                  ),
                  const SizedBox(height: 8),
                  StaticTile(
                    label: 'B',
                    title: 'Item B — Statis',
                    subtitle: 'Ini adalah item kedua dalam ListView statis.',
                    color: Color(0xFF2D4A5C),
                  ),
                  const SizedBox(height: 8),
                  StaticTile(
                    label: 'C',
                    title: 'Item C — Statis',
                    subtitle: 'Ini adalah item ketiga dalam ListView statis.',
                    color: Color(0xFF5C2D2D),
                  ),
                ],
              ),
            ),
          ],
        ),
      ),
    );
  }
}
