import 'package:flutter/material.dart';
import '../models/product.dart';

/// Daftar produk statis (minimal 5 produk sesuai ketentuan tugas).
/// Tema "kedai kopi" dipilih supaya konteksnya terasa nyata.
const List<Product> productList = [
  Product(
    id: 'p1',
    name: 'V60 Single Origin',
    category: 'Kopi Manual Brew',
    price: 25000,
    icon: Icons.coffee,
  ),
  Product(
    id: 'p2',
    name: 'Es Kopi Susu',
    category: 'Kopi Susu',
    price: 20000,
    icon: Icons.local_cafe,
  ),
  Product(
    id: 'p3',
    name: 'Cappuccino',
    category: 'Kopi Susu',
    price: 23000,
    icon: Icons.coffee_maker,
  ),
  Product(
    id: 'p4',
    name: 'Americano',
    category: 'Kopi Hitam',
    price: 18000,
    icon: Icons.local_drink,
  ),
  Product(
    id: 'p5',
    name: 'Croissant Butter',
    category: 'Pastry',
    price: 17000,
    icon: Icons.bakery_dining,
  ),
  Product(
    id: 'p6',
    name: 'Roti Bakar Coklat',
    category: 'Snack',
    price: 15000,
    icon: Icons.breakfast_dining,
  ),
];
