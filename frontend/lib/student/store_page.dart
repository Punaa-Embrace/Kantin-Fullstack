import 'package:flutter/material.dart';
import 'store/building_card.dart';
import 'store/canteen_grid.dart';

class StorePage extends StatefulWidget {
  const StorePage({Key? key}) : super(key: key);

  @override
  State<StorePage> createState() => _StorePageState();
}

class _StorePageState extends State<StorePage> {
  String selectedBuilding = 'GU'; // Default selected building

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      body: SafeArea(
        child: Column(
          crossAxisAlignment: CrossAxisAlignment.start,
          children: [
            const Padding(
              padding: EdgeInsets.all(16.0),
              child: Text(
                'Ingin Pesan Makanan di Stand Mana?',
                style: TextStyle(
                  fontSize: 20,
                  fontWeight: FontWeight.bold,
                ),
              ),
            ),
            
            // Building Selection Cards
            Padding(
              padding: const EdgeInsets.symmetric(horizontal: 16.0),
              child: Row(
                children: [
                  Expanded(
                    child: BuildingCard(
                      image: 'assets/store/gedung-utama.jpg',
                      title: 'Gedung Utama',
                      isSelected: selectedBuilding == 'GU',
                      onTap: () => setState(() => selectedBuilding = 'GU'),
                    ),
                  ),
                  const SizedBox(width: 12),
                  Expanded(
                    child: BuildingCard(
                      image: 'assets/store/gedung-rtf.jpg',
                      title: 'Gedung RTF',
                      isSelected: selectedBuilding == 'RTF',
                      onTap: () => setState(() => selectedBuilding = 'RTF'),
                    ),
                  ),
                ],
              ),
            ),
            
            const SizedBox(height: 24),
            
            // Canteen Grid
            Expanded(
              child: CanteenGrid(buildingType: selectedBuilding),
            ),
          ],
        ),
      ),
    );
  }
}