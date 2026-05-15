import 'package:flutter/material.dart';
import 'container_page.dart';
import 'gridview_page.dart';
import 'listview_page.dart';
import 'listview_builder_page.dart';
import 'listview_separated_page.dart';
import 'stack_page.dart';

class HomePage extends StatelessWidget {
  const HomePage({super.key});

  @override
  Widget build(BuildContext context) {
    final menus = [
      {
        'title': 'Container',
        'subtitle': 'Kotak berwarna',
        'icon': Icons.crop_square_rounded,
        'color': const Color(0xFF4C5C2D),
        'page': const ContainerPage(),
      },
      {
        'title': 'GridView',
        'subtitle': '6 item dalam grid',
        'icon': Icons.grid_view_rounded,
        'color': const Color(0xFF2D4A5C),
        'page': const GridViewPage(),
      },
      {
        'title': 'ListView',
        'subtitle': '3 item statis (A, B, C)',
        'icon': Icons.list_rounded,
        'color': const Color(0xFF5C2D2D),
        'page': const ListViewPage(),
      },
      {
        'title': 'ListView.builder',
        'subtitle': 'List dari array data',
        'icon': Icons.format_list_bulleted_rounded,
        'color': const Color(0xFF5C4A2D),
        'page': const ListViewBuilderPage(),
      },
      {
        'title': 'ListView.separated',
        'subtitle': 'List + garis pembatas',
        'icon': Icons.horizontal_rule_rounded,
        'color': const Color(0xFF2D5C4A),
        'page': const ListViewSeparatedPage(),
      },
      {
        'title': 'Stack',
        'subtitle': 'Tampilan bertumpuk',
        'icon': Icons.layers_rounded,
        'color': const Color(0xFF4A2D5C),
        'page': const StackPage(),
      },
    ];

    return Scaffold(
      backgroundColor: const Color(0xFFF5F3EE),
      appBar: AppBar(
        backgroundColor: const Color(0xFF1B0C0C),
        foregroundColor: Colors.white,
        title: const Text(
          'Widget UI',
          style: TextStyle(fontWeight: FontWeight.w600, fontSize: 16),
        ),
        centerTitle: true,
      ),
      body: ListView.separated(
        padding: const EdgeInsets.all(16),
        itemCount: menus.length,
        separatorBuilder: (_, _) => const SizedBox(height: 12),
        itemBuilder: (context, index) {
          final menu = menus[index];
          return Material(
            color: Colors.white,
            borderRadius: BorderRadius.circular(12),
            elevation: 1,
            shadowColor: Colors.black12,
            child: InkWell(
              borderRadius: BorderRadius.circular(12),
              onTap: () => Navigator.push(
                context,
                MaterialPageRoute(builder: (_) => menu['page'] as Widget),
              ),
              child: Padding(
                padding: const EdgeInsets.all(16),
                child: Row(
                  children: [
                    Container(
                      width: 48,
                      height: 48,
                      decoration: BoxDecoration(
                        color: (menu['color'] as Color).withValues(alpha: 0.12),
                        borderRadius: BorderRadius.circular(10),
                      ),
                      child: Icon(
                        menu['icon'] as IconData,
                        color: menu['color'] as Color,
                        size: 24,
                      ),
                    ),
                    const SizedBox(width: 16),
                    Expanded(
                      child: Column(
                        crossAxisAlignment: CrossAxisAlignment.start,
                        children: [
                          Text(
                            menu['title'] as String,
                            style: const TextStyle(
                              fontSize: 15,
                              fontWeight: FontWeight.bold,
                              color: Color(0xFF1B0C0C),
                            ),
                          ),
                          const SizedBox(height: 2),
                          Text(
                            menu['subtitle'] as String,
                            style: const TextStyle(fontSize: 13, color: Colors.grey),
                          ),
                        ],
                      ),
                    ),
                    const Icon(Icons.arrow_forward_ios_rounded,
                        size: 14, color: Colors.grey),
                  ],
                ),
              ),
            ),
          );
        },
      ),
    );
  }
}
