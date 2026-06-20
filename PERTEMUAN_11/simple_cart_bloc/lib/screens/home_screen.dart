import 'package:flutter/material.dart';
import 'package:flutter_bloc/flutter_bloc.dart';
import '../cubit/cart_cubit.dart';
import '../cubit/cart_state.dart';
import '../data/products.dart';
import '../widgets/product_card.dart';
import 'cart_screen.dart';

/// Halaman utama: menampilkan daftar produk dan ikon keranjang
/// dengan badge jumlah item yang update secara real-time.
class HomeScreen extends StatelessWidget {
  const HomeScreen({super.key});

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      appBar: AppBar(
        title: const Text('Daftar Produk'),
        actions: [
          Padding(
            padding: const EdgeInsets.only(right: 8),
            child: Stack(
              clipBehavior: Clip.none,
              children: [
                IconButton(
                  icon: const Icon(Icons.shopping_cart),
                  onPressed: () => _openCart(context),
                ),
                // BlocBuilder di sini HANYA membangun ulang badge kecil ini,
                // bukan seluruh AppBar, sehingga rebuild lebih efisien.
                Positioned(
                  right: 2,
                  top: 2,
                  child: BlocBuilder<CartCubit, CartState>(
                    builder: (context, state) {
                      if (state.totalItemCount == 0) {
                        return const SizedBox.shrink();
                      }
                      return Container(
                        padding: const EdgeInsets.all(4),
                        decoration: const BoxDecoration(
                          color: Colors.red,
                          shape: BoxShape.circle,
                        ),
                        constraints: const BoxConstraints(minWidth: 18, minHeight: 18),
                        child: Text(
                          '${state.totalItemCount}',
                          textAlign: TextAlign.center,
                          style: const TextStyle(
                            color: Colors.white,
                            fontSize: 11,
                            fontWeight: FontWeight.bold,
                          ),
                        ),
                      );
                    },
                  ),
                ),
              ],
            ),
          ),
        ],
      ),
      body: ListView.builder(
        padding: const EdgeInsets.all(12),
        itemCount: productList.length,
        itemBuilder: (context, index) => ProductCard(product: productList[index]),
      ),
      // Bar bawah ringkasan keranjang, hanya muncul jika ada item.
      bottomNavigationBar: BlocBuilder<CartCubit, CartState>(
        builder: (context, state) {
          if (state.totalItemCount == 0) return const SizedBox.shrink();
          return SafeArea(
            child: Padding(
              padding: const EdgeInsets.all(12),
              child: ElevatedButton(
                onPressed: () => _openCart(context),
                style: ElevatedButton.styleFrom(padding: const EdgeInsets.symmetric(vertical: 14)),
                child: Text(
                  'Lihat Keranjang (${state.totalItemCount} item) • Rp ${state.totalPrice}',
                ),
              ),
            ),
          );
        },
      ),
    );
  }

  void _openCart(BuildContext context) {
    Navigator.push(context, MaterialPageRoute(builder: (_) => const CartScreen()));
  }
}
