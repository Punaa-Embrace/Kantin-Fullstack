import 'package:flutter/material.dart';
import '../../theme/app_theme.dart';

class CategoryList extends StatefulWidget {
  const CategoryList({Key? key}) : super(key: key);

  @override
  State<CategoryList> createState() => _CategoryListState();
}

class _CategoryListState extends State<CategoryList> {
  int selectedIndex = 0;

  final categories = [
    {'icon': '🍜', 'name': 'Semua'},
    {'icon': '🥣', 'name': 'Sup'},
    {'icon': '🍝', 'name': 'Mie'},
    {'icon': '🐟', 'name': 'Ikan'},
  ];

  @override
  Widget build(BuildContext context) {
    return SizedBox(
      height: 90,
      child: ListView.builder(
        scrollDirection: Axis.horizontal,
        padding: const EdgeInsets.symmetric(horizontal: 16),
        itemCount: categories.length,
        itemBuilder: (context, index) {
          return CategoryItem(
            icon: categories[index]['icon']!,
            name: categories[index]['name']!,
            isSelected: selectedIndex == index,
            onTap: () {
              setState(() {
                selectedIndex = index;
              });
            },
          );
        },
      ),
    );
  }
}

class CategoryItem extends StatelessWidget {
  final String icon;
  final String name;
  final bool isSelected;
  final VoidCallback onTap;

  const CategoryItem({
    Key? key,
    required this.icon,
    required this.name,
    required this.isSelected,
    required this.onTap,
  }) : super(key: key);

  @override
  Widget build(BuildContext context) {
    return GestureDetector(
      onTap: onTap,
      child: Container(
        margin: const EdgeInsets.only(right: 12), 
        child: Column(
          mainAxisSize: MainAxisSize.min,
          children: [
            Container(
              padding: const EdgeInsets.all(15), 
              constraints: const BoxConstraints(
                minWidth: 70,
                minHeight: 70,
              ),
              decoration: BoxDecoration(
                color: Colors.white,
                borderRadius: BorderRadius.circular(7),
                border: Border.all(
                  color: isSelected ? AppTheme.primaryColor : Colors.grey[300]!,
                  width: 1.5,
                ),
              ),
              child: Text(
                icon,
                style: const TextStyle(fontSize: 20),
                textAlign: TextAlign.center,
              ),
            ),
            const SizedBox(height: 4), 
            Text(
              name,
              style: TextStyle(
                fontSize: 11, 
                color: isSelected ? AppTheme.primaryColor : AppTheme.textColor,
                fontWeight: isSelected ? FontWeight.bold : FontWeight.normal,
              ),
            ),
          ],
        ),
      ),
    );
  }
}
