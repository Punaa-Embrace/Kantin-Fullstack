import 'package:flutter/material.dart';

class SuccessMessage extends StatelessWidget {
  final String message;
  final bool isVisible;

  const SuccessMessage({
    super.key,
    required this.message,
    required this.isVisible,
  });

  @override
  Widget build(BuildContext context) {
    if (!isVisible) return const SizedBox.shrink();

    return Container(
      width: double.infinity,
      padding: const EdgeInsets.all(12),
      color: Colors.green[50],
      child: Row(
        mainAxisAlignment: MainAxisAlignment.center,
        children: [
          Icon(Icons.check_circle, color: Colors.green[700], size: 16),
          const SizedBox(width: 8),
          Text(
            message,
            style: TextStyle(
              color: Colors.green[700],
              fontWeight: FontWeight.w500,
            ),
          ),
        ],
      ),
    );
  }
}