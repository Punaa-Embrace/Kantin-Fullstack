import 'package:flutter/material.dart';
import '../../theme/app_theme.dart';

class CanteenCard extends StatelessWidget {
  final String name;
  final String image;

  const CanteenCard({
    Key? key,
    required this.name,
    required this.image,
  }) : super(key: key);

  @override
  Widget build(BuildContext context) {
    return GestureDetector(
      onTap: () {},
      child: Container(
        decoration: AppTheme.cardDecoration,
        child: Column(
          crossAxisAlignment: CrossAxisAlignment.start,
          children: [
            ClipRRect(
              borderRadius: const BorderRadius.vertical(top: Radius.circular(12)),
              child: Image.asset(
                image,
                height: 120,
                width: double.infinity,
                fit: BoxFit.cover,
              ),
            ),
            Padding(
              padding: const EdgeInsets.all(12),
              child: Row(
                children: [
                  Expanded(
                    child: Text(name, style: AppTheme.bodyStyle.copyWith(fontWeight: FontWeight.bold)),
                  ),
                  Text(
                    'GU',
                    style: AppTheme.bodyStyle.copyWith(
                      color: AppTheme.secondaryColor,
                      fontSize: 12,
                    ),
                  ),
                ],
              ),
            ),
          ],
        ),
      ),
    );
  }
}