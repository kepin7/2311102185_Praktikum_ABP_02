import 'package:flutter_bloc/flutter_bloc.dart';
import '../models/product.dart';
import 'cart_state.dart';

/// CartCubit mengatur seluruh logika keranjang belanja:
/// - menambah produk ke keranjang
/// - mengurangi / menghapus produk dari keranjang
/// - mengosongkan keranjang
///
/// Setiap method memanggil `emit()` dengan CartState yang baru, sehingga
/// setiap widget yang mendengarkan (BlocBuilder/BlocListener) otomatis
/// rebuild dengan data terbaru.
class CartCubit extends Cubit<CartState> {
  CartCubit() : super(const CartState());

  /// Menambahkan satu unit produk ke keranjang.
  /// Jika produk sudah ada di keranjang, quantity-nya akan bertambah 1.
  void addToCart(Product product) {
    final items = List<CartItem>.from(state.items);
    final index = items.indexWhere((item) => item.product.id == product.id);

    if (index >= 0) {
      items[index] = items[index].copyWith(quantity: items[index].quantity + 1);
    } else {
      items.add(CartItem(product: product, quantity: 1));
    }

    emit(CartState(items: items));
  }

  /// Mengurangi satu unit produk dari keranjang.
  /// Jika quantity tersisa 1, produk akan dihapus seluruhnya dari keranjang.
  void removeFromCart(Product product) {
    final items = List<CartItem>.from(state.items);
    final index = items.indexWhere((item) => item.product.id == product.id);

    if (index < 0) return; // produk tidak ada di keranjang, tidak ada perubahan

    if (items[index].quantity > 1) {
      items[index] = items[index].copyWith(quantity: items[index].quantity - 1);
    } else {
      items.removeAt(index);
    }

    emit(CartState(items: items));
  }

  /// Menghapus seluruh quantity produk tertentu dari keranjang sekaligus.
  void removeAllOfProduct(Product product) {
    final items = List<CartItem>.from(state.items)
      ..removeWhere((item) => item.product.id == product.id);
    emit(CartState(items: items));
  }

  /// Mengosongkan seluruh keranjang.
  void clearCart() {
    emit(const CartState());
  }
}
