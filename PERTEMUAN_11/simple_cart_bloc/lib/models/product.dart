import 'package:equatable/equatable.dart';
import 'package:flutter/material.dart';

/// Model sederhana untuk satu produk pada daftar menu.
class Product extends Equatable {
  final String id;
  final String name;
  final String category;
  final int price; // harga dalam Rupiah
  final IconData icon;

  const Product({
    required this.id,
    required this.name,
    required this.category,
    required this.price,
    required this.icon,
  });

  @override
  List<Object?> get props => [id, name, category, price];
}
