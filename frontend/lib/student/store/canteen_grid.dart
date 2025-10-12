import 'package:flutter/material.dart';
import 'canteen_card.dart';

class CanteenGrid extends StatelessWidget {
  final String buildingType;

  const CanteenGrid({
    Key? key,
    required this.buildingType,
  }) : super(key: key);

  @override
  Widget build(BuildContext context) {
    // Dummy data - ganti dengan data sesuai gedung
    final canteens = buildingType == 'GU' 
        ? [
            {'name': '3K Kitchen', 'image': 'assets/images/3k-kitchen.jpg'},
            // Tambahkan kantin lain untuk Gedung Utama
          ]
        : [
            // Data kantin untuk RTF
          ];

    return GridView.builder(
      padding: const EdgeInsets.all(16),
      gridDelegate: const SliverGridDelegateWithFixedCrossAxisCount(
        crossAxisCount: 2,
        childAspectRatio: 1,
        crossAxisSpacing: 16,
        mainAxisSpacing: 16,
      ),
      itemCount: canteens.length,
      itemBuilder: (context, index) {
        final canteen = canteens[index];
        return CanteenCard(
          name: canteen['name']!,
          image: canteen['image']!,
        );
      },
    );
  }
}