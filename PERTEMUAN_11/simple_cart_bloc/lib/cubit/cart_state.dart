import 'package:equatable/equatable.dart';
import '../models/product.dart';

/// Representasi satu baris di keranjang: produk + jumlah (quantity).
class CartItem extends Equatable {
  final Product product;
  final int quantity;

  const CartItem({required this.product, required this.quantity});

  CartItem copyWith({int? quantity}) {
    return CartItem(
      product: product,
      quantity: quantity ?? this.quantity,
    );
  }

  int get subtotal => product.price * quantity;

  @override
  List<Object?> get props => [product, quantity];
}

/// State tunggal yang dipegang oleh CartCubit.
/// Cubit ini hanya memiliki SATU jenis state (bukan beberapa class state
/// seperti pada BLoC dengan Event), sehingga cukup satu class CartState
/// yang berisi daftar item di keranjang.
class CartState extends Equatable {
  final List<CartItem> items;

  const CartState({this.items = const []});

  /// Jumlah total item (akumulasi quantity semua produk) di keranjang.
  int get totalItemCount => items.fold(0, (sum, item) => sum + item.quantity);

  /// Total harga seluruh item di keranjang.
  int get totalPrice => items.fold(0, (sum, item) => sum + item.subtotal);

  /// Cari quantity produk tertentu, 0 jika belum ada di keranjang.
  int quantityOf(String productId) {
    final match = items.where((item) => item.product.id == productId);
    return match.isEmpty ? 0 : match.first.quantity;
  }

  @override
  List<Object?> get props => [items];
}
