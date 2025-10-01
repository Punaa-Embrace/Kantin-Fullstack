import 'package:flutter/material.dart';

class AppTheme {
  static const Color primaryColor = Color(0xFF3C7E01);
  static const Color secondaryColor = Color(0xFF64748B);
  static const Color backgroundColor = Color(0xFFF8FAFC);
  static const Color textColor = Color(0xFF1E293B);
  
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
}