class TodoModel {
  final String id;
  final String title;
  final bool isDone;
  final DateTime createdAt;

  TodoModel({
    required this.id,
    required this.title,
    required this.isDone,
    required this.createdAt,
  });

  TodoModel copyWith({
    String? id,
    String? title,
    bool? isDone,
    DateTime? createdAt,
  }) {
    return TodoModel(
      id: id ?? this.id,
      title: title ?? this.title,
      isDone: isDone ?? this.isDone,
      createdAt: createdAt ?? this.createdAt,
    );
  }
}