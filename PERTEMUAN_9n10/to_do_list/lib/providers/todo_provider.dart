import 'package:flutter/material.dart';

import '../models/todo_model.dart';

class TodoProvider extends ChangeNotifier {
  final List<TodoModel> _todos = [];

  List<TodoModel> get todos => List.unmodifiable(_todos);

  int get totalTodos => _todos.length;

  void addTodo(String title) {
    final cleanedTitle = title.trim();

    if (cleanedTitle.isEmpty) return;

    final todo = TodoModel(
      id: DateTime.now().millisecondsSinceEpoch.toString(),
      title: cleanedTitle,
      isDone: false,
      createdAt: DateTime.now(),
    );

    _todos.add(todo);
    notifyListeners();
  }

  void toggleTodo(String id) {
    final index = _todos.indexWhere((todo) => todo.id == id);

    if (index == -1) return;

    final selectedTodo = _todos[index];

    _todos[index] = selectedTodo.copyWith(
      isDone: !selectedTodo.isDone,
    );

    notifyListeners();
  }

  void clearTodos() {
    _todos.clear();
    notifyListeners();
  }
}