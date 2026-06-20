import 'package:flutter/material.dart';
import 'package:provider/provider.dart';

import '../providers/todo_provider.dart';
import '../widgets/todo_input.dart';
import '../widgets/todo_list_item.dart';

class TodoPage extends StatelessWidget {
  const TodoPage({super.key});

  void _showClearDialog(BuildContext context) {
    showDialog(
      context: context,
      builder: (dialogContext) {
        return AlertDialog(
          title: const Text('Hapus Semua Tugas'),
          content: const Text(
            'Apakah kamu yakin ingin menghapus seluruh tugas?',
          ),
          actions: [
            TextButton(
              onPressed: () {
                Navigator.pop(dialogContext);
              },
              child: const Text('Batal'),
            ),
            FilledButton(
              onPressed: () {
                context.read<TodoProvider>().clearTodos();
                Navigator.pop(dialogContext);
              },
              child: const Text('Hapus'),
            ),
          ],
        );
      },
    );
  }

  @override
  Widget build(BuildContext context) {
    final todoProvider = context.watch<TodoProvider>();

    return Scaffold(
      appBar: AppBar(
        title: const Text('To-Do List Provider FCM'),
        centerTitle: true,
      ),
      body: Padding(
        padding: const EdgeInsets.all(16),
        child: Column(
          children: [
            const TodoInput(),
            const SizedBox(height: 16),

            Row(
              mainAxisAlignment: MainAxisAlignment.spaceBetween,
              children: [
                Text(
                  'Total tugas: ${todoProvider.totalTodos}',
                  style: Theme.of(context).textTheme.titleMedium,
                ),
                TextButton.icon(
                  onPressed: todoProvider.todos.isEmpty
                      ? null
                      : () => _showClearDialog(context),
                  icon: const Icon(Icons.delete_sweep),
                  label: const Text('Hapus Semua'),
                ),
              ],
            ),

            const SizedBox(height: 8),

            Expanded(
              child: todoProvider.todos.isEmpty
                  ? const Center(
                      child: Text(
                        'Belum ada tugas.\nTambahkan tugas terlebih dahulu.',
                        textAlign: TextAlign.center,
                      ),
                    )
                  : ListView.builder(
                      itemCount: todoProvider.todos.length,
                      itemBuilder: (context, index) {
                        final todo = todoProvider.todos[index];

                        return TodoListItem(todo: todo);
                      },
                    ),
            ),
          ],
        ),
      ),
    );
  }
}