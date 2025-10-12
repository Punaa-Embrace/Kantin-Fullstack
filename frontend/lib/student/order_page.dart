import 'package:flutter/material.dart';
import '../theme/app_theme.dart';
import 'order/category_list.dart';
import 'order/menu_grid.dart';
import 'order/search_header.dart';

class OrderPage extends StatelessWidget {
  const OrderPage({Key? key}) : super(key: key);

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      backgroundColor: AppTheme.backgroundColor,
      body: SafeArea(
        child: Column(
          crossAxisAlignment: CrossAxisAlignment.start,
          children: [
            // Search Header
            const SearchHeader(),

            // Kategori Text
            Padding(
              padding: const EdgeInsets.all(16.0),
              child: Text(
                'Kategori',
                style: AppTheme.headingStyle.copyWith(
                  fontSize: 20,
                ),
              ),
            ),

            // Category List
            const CategoryList(),

            // Semua Menu Text
            Padding(
              padding: const EdgeInsets.all(16.0),
              child: Row(
                mainAxisAlignment: MainAxisAlignment.spaceBetween,
                children: [
                  Text(
                    'Semua Menu',
                    style: AppTheme.headingStyle.copyWith(
                      fontSize: 20,
                    ),
                  ),
                  Text(
                    'Lihat Semua',
                    style: AppTheme.linkStyle.copyWith(
                      color: AppTheme.accentColor,
                      fontWeight: FontWeight.w500,
                    ),
                  ),
                ],
              ),
            ),

            // Menu Grid
            const Expanded(
              child: MenuGrid(),
            ),
          ],
        ),
      ),
    );
  }
}
