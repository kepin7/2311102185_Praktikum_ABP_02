import 'package:flutter/material.dart';
import 'package:provider/provider.dart';

import 'pages/todo_page.dart';
import 'providers/todo_provider.dart';

class TodoApp extends StatelessWidget {
  const TodoApp({super.key});

  @override
  Widget build(BuildContext context) {
    return ChangeNotifierProvider(
      create: (_) => TodoProvider(),
      child: MaterialApp(
        debugShowCheckedModeBanner: false,
        title: 'Todo Provider FCM',
        theme: ThemeData(
          colorScheme: ColorScheme.fromSeed(seedColor: Colors.teal),
          useMaterial3: true,
        ),
        home: const TodoPage(),
      ),
    );
  }
}