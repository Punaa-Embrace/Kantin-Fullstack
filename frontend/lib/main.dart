import 'package:flutter/material.dart';
import 'authentication/login_page.dart';
import 'authentication/register_page.dart';
import 'authentication/forgot_password_page.dart';
import 'authentication/otp_verification_page.dart';
import 'authentication/reset_password_page.dart';

void main() {
  runApp(const MyApp());
}

class MyApp extends StatelessWidget {
  const MyApp({super.key});

  @override
  Widget build(BuildContext context) {
    return MaterialApp(
      title: 'JAKA',
      theme: ThemeData(
        primarySwatch: Colors.blue,
        fontFamily: 'Inter',
        scaffoldBackgroundColor: const Color(0xFFF8FAFC),
        appBarTheme: const AppBarTheme(
          backgroundColor: Colors.white,
          elevation: 0,
          iconTheme: IconThemeData(color: Colors.black),
          titleTextStyle: TextStyle(
            color: Colors.black,
            fontSize: 18,
            fontWeight: FontWeight.w600,
          ),
        ),
      ),
      initialRoute: '/login',
      routes: {
        '/login': (context) => const LoginPage(),
        '/register': (context) => const RegisterPage(),
        '/forgot-password': (context) => const ForgotPasswordPage(),
        '/otp-verification': (context) => const OTPVerificationPage(phoneNumber: ''),
        '/reset-password': (context) => const ResetPasswordPage(phoneNumber: ''),
      },
      debugShowCheckedModeBanner: false,
    );
  }
}

// Optional: Jika ingin menggunakan home-based navigation instead of routes
/*
class MyApp extends StatelessWidget {
  const MyApp({super.key});

  @override
  Widget build(BuildContext context) {
    return MaterialApp(
      title: 'JAKA',
      theme: ThemeData(
        primarySwatch: Colors.blue,
        fontFamily: 'Inter',
        scaffoldBackgroundColor: const Color(0xFFF8FAFC),
      ),
      home: const LoginPage(), // Set home langsung ke LoginPage
      debugShowCheckedModeBanner: false,
    );
  }
}
*/