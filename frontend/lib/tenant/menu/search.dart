import 'package:flutter/material.dart';
import '../../widgets/custom_button.dart';

class SearchAddHeader extends StatelessWidget {
  final TextEditingController searchController;
  final VoidCallback onAddPressed;
  final ValueChanged<String> onSearchChanged;

  const SearchAddHeader({
    super.key,
    required this.searchController,
    required this.onAddPressed,
    required this.onSearchChanged,
  });

  @override
  Widget build(BuildContext context) {
    return Container(
      padding: const EdgeInsets.all(16),
      color: Colors.white,
      child: Row(
        children: [
          Expanded(
            child: TextField(
              controller: searchController,
              decoration: InputDecoration(
                hintText: 'Cari menu...',
                prefixIcon: const Icon(Icons.search, color: Colors.grey),
                filled: true,
                fillColor: Colors.grey[50],
                border: OutlineInputBorder(
                  borderRadius: BorderRadius.circular(8),
                  borderSide: BorderSide.none,
                ),
                contentPadding: const EdgeInsets.symmetric(horizontal: 16),
              ),
              onChanged: onSearchChanged,
            ),
          ),
          const SizedBox(width: 12),
          SizedBox(
            width: 140,
            child: CustomButton(
              text: 'Tambah Menu',
              onPressed: onAddPressed,
              isPrimary: true,
            ),
          ),
        ],
      ),
    );
  }
}