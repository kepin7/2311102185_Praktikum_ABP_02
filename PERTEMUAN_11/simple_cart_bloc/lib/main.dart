import 'package:flutter/material.dart';
import 'package:flutter_bloc/flutter_bloc.dart';
import 'cubit/cart_cubit.dart';
import 'screens/home_screen.dart';

void main() {
  runApp(const MyApp());
}

class MyApp extends StatelessWidget {
  const MyApp({super.key});

  @override
  Widget build(BuildContext context) {
    // BlocProvider menyediakan satu instance CartCubit ke seluruh widget
    // tree di bawahnya, sehingga HomeScreen dan CartScreen membaca
    // CartCubit yang sama (state keranjang konsisten di seluruh aplikasi).
    return BlocProvider(
      create: (_) => CartCubit(),
      child: MaterialApp(
        title: 'Kasir Kopi Sederhana',
        debugShowCheckedModeBanner: false,
        theme: ThemeData(
          colorSchemeSeed: const Color(0xFF4C5C2D),
          useMaterial3: true,
        ),
        home: const HomeScreen(),
      ),
    );
  }
}
