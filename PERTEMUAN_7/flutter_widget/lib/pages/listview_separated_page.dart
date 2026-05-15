import 'package:flutter/material.dart';
import '../widgets/custom_app_bar.dart';
import '../widgets/section_title.dart';
import '../data/menu_data.dart';

class ListViewSeparatedPage extends StatelessWidget {
  const ListViewSeparatedPage({super.key});

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      backgroundColor: const Color(0xFFF5F3EE),
      appBar: buildAppBar('ListView.separated'),
      body: Column(
        crossAxisAlignment: CrossAxisAlignment.start,
        children: [
          const Padding(
            padding: EdgeInsets.fromLTRB(16, 16, 16, 0),
            child: SectionTitle('Menu Kantin — dengan Divider'),
          ),
          const SizedBox(height: 8),
          Expanded(
            child: Container(
              margin: const EdgeInsets.all(16),
              decoration: BoxDecoration(
                color: Colors.white,
                borderRadius: BorderRadius.circular(14),
                boxShadow: [
                  BoxShadow(
                    color: Colors.black.withValues(alpha: 0.07),
                    blurRadius: 8,
                  ),
                ],
              ),
              child: ClipRRect(
                borderRadius: BorderRadius.circular(14),
                child: ListView.separated(
                  itemCount: menuKantin.length,
                  separatorBuilder: (_, _) => const Divider(
                    height: 1,
                    thickness: 1,
                    color: Color(0xFFEEEEEE),
                    indent: 60,
                  ),
                  itemBuilder: (context, index) {
                    final item = menuKantin[index];
                    return ListTile(
                      contentPadding: const EdgeInsets.symmetric(
                          horizontal: 16, vertical: 6),
                      leading: Container(
                        width: 44,
                        height: 44,
                        decoration: BoxDecoration(
                          color: const Color(0xFF2D5C4A).withValues(alpha: 0.08),
                          borderRadius: BorderRadius.circular(10),
                        ),
                        child: Center(
                          child: Text(item['icon']!,
                              style: const TextStyle(fontSize: 22)),
                        ),
                      ),
                      title: Text(
                        item['name']!,
                        style: const TextStyle(
                            fontWeight: FontWeight.w600, fontSize: 14),
                      ),
                      subtitle: const Text(
                        'Tersedia',
                        style: TextStyle(fontSize: 11, color: Colors.green),
                      ),
                      trailing: Text(
                        item['harga']!,
                        style: const TextStyle(
                          fontWeight: FontWeight.bold,
                          fontSize: 13,
                          color: Color(0xFF2D5C4A),
                        ),
                      ),
                    );
                  },
                ),
              ),
            ),
          ),
        ],
      ),
    );
  }
}
