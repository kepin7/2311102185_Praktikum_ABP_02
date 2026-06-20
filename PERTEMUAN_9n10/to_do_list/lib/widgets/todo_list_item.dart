import 'package:flutter/material.dart';
import 'package:provider/provider.dart';

import '../models/todo_model.dart';
import '../providers/todo_provider.dart';

class TodoListItem extends StatelessWidget {
  final TodoModel todo;

  const TodoListItem({
    super.key,
    required this.todo,
  });

  @override
  Widget build(BuildContext context) {
    return Card(
      child: CheckboxListTile(
        value: todo.isDone,
        onChanged: (_) {
          context.read<TodoProvider>().toggleTodo(todo.id);
        },
        title: Text(
          todo.title,
          style: TextStyle(
            decoration: todo.isDone
                ? TextDecoration.lineThrough
                : TextDecoration.none,
          ),
        ),
        subtitle: Text(
          todo.isDone ? 'Selesai' : 'Belum selesai',
        ),
      ),
    );
  }
}