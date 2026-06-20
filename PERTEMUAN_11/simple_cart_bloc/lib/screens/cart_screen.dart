import 'package:flutter/material.dart';
import 'package:flutter_bloc/flutter_bloc.dart';
import '../cubit/cart_cubit.dart';
import '../cubit/cart_state.dart';

/// Halaman keranjang: menampilkan rincian produk yang sudah ditambahkan,
/// tombol +/- per item, tombol kosongkan keranjang, dan total bayar.
/// Semua data diambil dari CartState lewat BlocBuilder.
class CartScreen extends StatelessWidget {
  const CartScreen({super.key});

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      appBar: AppBar(
        // Back button dibuat EKSPLISIT (tidak mengandalkan default AppBar)
        // agar selalu tampil dan pasti berfungsi menutup halaman keranjang.
        leading: IconButton(
          icon: const Icon(Icons.arrow_back),
          tooltip: 'Kembali',
          onPressed: () => Navigator.pop(context),
        ),
        title: const Text('Keranjang Saya'),
        actions: [
          BlocBuilder<CartCubit, CartState>(
            builder: (context, state) {
              if (state.items.isEmpty) return const SizedBox.shrink();
              return IconButton(
                icon: const Icon(Icons.delete_outline),
                tooltip: 'Kosongkan keranjang',
                onPressed: () => context.read<CartCubit>().clearCart(),
              );
            },
          ),
        ],
      ),
      // Seluruh isi halaman (daftar item + ringkasan total) sekarang berada
      // dalam SATU BlocBuilder + Column, supaya daftar produk yang dipilih
      // dan ringkasan total selalu tampil bersamaan dan konsisten.
      body: BlocBuilder<CartCubit, CartState>(
        builder: (context, state) {
          if (state.items.isEmpty) {
            return const Center(child: Text('Keranjang masih kosong'));
          }

          return Column(
            children: [
              // Daftar produk yang sudah dipilih/ditambahkan ke keranjang.
              Expanded(
                child: ListView.builder(
                  padding: const EdgeInsets.all(12),
                  itemCount: state.items.length,
                  itemBuilder: (context, index) {
                    final item = state.items[index];
                    return Card(
                      margin: const EdgeInsets.only(bottom: 10),
                      child: ListTile(
                        leading: CircleAvatar(child: Icon(item.product.icon)),
                        title: Text(
                          item.product.name,
                          style: const TextStyle(fontWeight: FontWeight.w600),
                        ),
                        subtitle: Text(
                          'Rp ${item.product.price} x ${item.quantity} = Rp ${item.subtotal}',
                        ),
                        trailing: Row(
                          mainAxisSize: MainAxisSize.min,
                          children: [
                            IconButton(
                              icon: const Icon(Icons.remove_circle_outline),
                              onPressed: () =>
                                  context.read<CartCubit>().removeFromCart(item.product),
                            ),
                            Text(
                              '${item.quantity}',
                              style: const TextStyle(fontWeight: FontWeight.bold),
                            ),
                            IconButton(
                              icon: const Icon(Icons.add_circle_outline),
                              onPressed: () =>
                                  context.read<CartCubit>().addToCart(item.product),
                            ),
                          ],
                        ),
                      ),
                    );
                  },
                ),
              ),
              // Ringkasan total, menyatu langsung di bawah daftar item.
              Container(
                width: double.infinity,
                padding: const EdgeInsets.all(16),
                decoration: BoxDecoration(
                  color: Theme.of(context).colorScheme.surface,
                  boxShadow: const [BoxShadow(blurRadius: 6, color: Colors.black12)],
                ),
                child: SafeArea(
                  top: false,
                  child: Row(
                    mainAxisAlignment: MainAxisAlignment.spaceBetween,
                    children: [
                      Column(
                        crossAxisAlignment: CrossAxisAlignment.start,
                        children: [
                          Text('Total Item: ${state.totalItemCount}'),
                          Text(
                            'Total Bayar: Rp ${state.totalPrice}',
                            style: const TextStyle(fontWeight: FontWeight.bold, fontSize: 16),
                          ),
                        ],
                      ),
                    ],
                  ),
                ),
              ),
            ],
          );
        },
      ),
    );
  }
}
