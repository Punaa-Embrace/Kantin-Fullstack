import 'package:flutter/material.dart';

class AppTheme {
  // Primary Colors
  static const Color primaryColor = Color(0xFF3C7E01);
  static const Color secondaryColor = Color(0xFF64748B);
  static const Color accentColor = Colors.amber;

  // Background Colors
  static const Color backgroundColor = Color(0xFFF8FAFC);
  static const Color surfaceColor = Colors.white;

  // Text Colors
  static const Color textColor = Color(0xFF1E293B);
  static const Color textColorLight = Colors.white;

  // Status Colors
  static Color shadowColor = Colors.grey.withOpacity(0.1);

  static TextStyle headingStyle = const TextStyle(
    fontSize: 32,
    fontWeight: FontWeight.bold,
    color: textColor,
    letterSpacing: -0.5,
  );
  
  static TextStyle bodyStyle = const TextStyle(
    fontSize: 16,
    color: secondaryColor,
    height: 1.5,
  );
  
  static TextStyle linkStyle = const TextStyle(
    fontSize: 14,
    color: primaryColor,
    fontWeight: FontWeight.w500,
  );

    static const TextStyle priceStyle = TextStyle(
    fontSize: 14,
    fontWeight: FontWeight.bold,
    color: accentColor,
  );

    // Button Styles
  static final ButtonStyle primaryButtonStyle = ElevatedButton.styleFrom(
    backgroundColor: primaryColor,
    foregroundColor: textColorLight,
    elevation: 2,
    shape: RoundedRectangleBorder(
      borderRadius: BorderRadius.circular(8),
    ),
  );

  // Card Decoration
  static final BoxDecoration cardDecoration = BoxDecoration(
    color: surfaceColor,
    borderRadius: BorderRadius.circular(12),
    boxShadow: [
      BoxShadow(
        color: shadowColor,
        spreadRadius: 1,
        blurRadius: 4,
      ),
    ],
  );
}