import 'package:flutter/material.dart';
import '../widgets/custom_app_bar.dart';

class GridViewPage extends StatelessWidget {
  const GridViewPage({super.key});

  static const _items = [
    {'label': 'Apel', 'emoji': '🍎', 'color': Color(0xFFFFCDD2)},
    {'label': 'Pisang', 'emoji': '🍌', 'color': Color(0xFFFFF9C4)},
    {'label': 'Jeruk', 'emoji': '🍊', 'color': Color(0xFFFFE0B2)},
    {'label': 'Anggur', 'emoji': '🍇', 'color': Color(0xFFE1BEE7)},
    {'label': 'Mangga', 'emoji': '🥭', 'color': Color(0xFFF8BBD9)},
    {'label': 'Semangka', 'emoji': '🍉', 'color': Color(0xFFC8E6C9)},
    {'label': 'Stroberi', 'emoji': '🍓', 'color': Color(0xFFFFCDD2)},
    {'label': 'Melon', 'emoji': '🍈', 'color': Color(0xFFDCEDC8)},
  ];

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      backgroundColor: const Color(0xFFF5F3EE),
      appBar: buildAppBar('GridView'),
      body: Padding(
        padding: const EdgeInsets.all(16),
        child: GridView.builder(
          gridDelegate: const SliverGridDelegateWithFixedCrossAxisCount(
            crossAxisCount: 2,
            crossAxisSpacing: 12,
            mainAxisSpacing: 12,
            childAspectRatio: 1.1,
          ),
          itemCount: _items.length,
          itemBuilder: (context, index) {
            final item = _items[index];
            return Container(
              decoration: BoxDecoration(
                color: item['color'] as Color,
                borderRadius: BorderRadius.circular(14),
                boxShadow: [
                  BoxShadow(
                    color: Colors.black.withValues(alpha: 0.07),
                    blurRadius: 6,
                    offset: const Offset(0, 2),
                  ),
                ],
              ),
              child: Column(
                mainAxisAlignment: MainAxisAlignment.center,
                children: [
                  Text(item['emoji'] as String,
                      style: const TextStyle(fontSize: 36)),
                  const SizedBox(height: 8),
                  Text(
                    item['label'] as String,
                    style: const TextStyle(
                      fontSize: 14,
                      fontWeight: FontWeight.bold,
                      color: Color(0xFF1B0C0C),
                    ),
                  ),
                  Text(
                    'Item ${index + 1}',
                    style: const TextStyle(fontSize: 11, color: Colors.black45),
                  ),
                ],
              ),
            );
          },
        ),
      ),
    );
  }
}
