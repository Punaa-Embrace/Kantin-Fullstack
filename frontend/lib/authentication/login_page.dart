import 'package:flutter/material.dart';
import 'register_page.dart';
import 'forgot_password_page.dart';
import '../widgets/custom_button.dart';
import '../theme/app_theme.dart';

class LoginPage extends StatefulWidget {
  const LoginPage({super.key});

  @override
  State<LoginPage> createState() => _LoginPageState();
}

class _LoginPageState extends State<LoginPage> {
  final TextEditingController _emailController = TextEditingController();
  final TextEditingController _passwordController = TextEditingController();
  bool _obscurePassword = true;
  bool _isLoading = false;

  // Validasi dummy untuk menentukan user type
  String _getUserType(String email) {
    if (email.contains('@tenant.') || email.endsWith('@tenant.com')) {
      return 'tenant';
    } else if (email.contains('@student.') || email.endsWith('@student.com')) {
      return 'student';
    } else {
      // Default ke student jika tidak ada pattern khusus
      return 'student';
    }
  }

  void _login() async {
    final email = _emailController.text.trim();
    final password = _passwordController.text.trim();

    if (email.isEmpty || password.isEmpty) {
      ScaffoldMessenger.of(context).showSnackBar(
        const SnackBar(
          content: Text('Harap isi email dan password'),
          backgroundColor: Colors.red,
        ),
      );
      return;
    }

    // Show loading
    setState(() {
      _isLoading = true;
    });

    try {
      // Simulasi proses login (delay 2 detik)
      await Future.delayed(const Duration(seconds: 2));

      // Tentukan user type berdasarkan email
      final userType = _getUserType(email);

      // Validasi dummy credentials
      if (_validateCredentials(email, password)) {
        // Login berhasil - navigasi berdasarkan user type
        if (userType == 'tenant') {
          // Cek dulu apakah route tersedia
          Navigator.of(context).pushReplacementNamed('/tenant_dashboard');
        } else {
          Navigator.of(context).pushReplacementNamed('/dashboard');
        }
        
        ScaffoldMessenger.of(context).showSnackBar(
          SnackBar(
            content: Text('Login berhasil sebagai $userType'),
            backgroundColor: Colors.green,
          ),
        );
      } else {
        // Login gagal
        ScaffoldMessenger.of(context).showSnackBar(
          const SnackBar(
            content: Text('Email atau password salah'),
            backgroundColor: Colors.red,
          ),
        );
      }
    } catch (e) {
      // Handle error navigasi
      ScaffoldMessenger.of(context).showSnackBar(
        SnackBar(
          content: Text('Error: $e'),
          backgroundColor: Colors.red,
        ),
      );
    } finally {
      if (mounted) {
        setState(() {
          _isLoading = false;
        });
      }
    }
  }

  // Validasi dummy credentials
  bool _validateCredentials(String email, String password) {
    // Credentials untuk testing
    final validCredentials = {
      'puna@student.com': 'puna123',
      'alca@tenant.com': 'alca123',
      'user@student.com': 'password123',
      'tenant@tenant.com': 'password123',
      'test@student.com': 'test123',
      'test@tenant.com': 'test123',
    };

    return validCredentials[email] == password;
  }

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      backgroundColor: AppTheme.backgroundColor,
      body: SafeArea(
        child: LayoutBuilder(
          builder: (context, constraints) {
            return SingleChildScrollView(
              padding: const EdgeInsets.all(24.0),
              child: ConstrainedBox(
                constraints: BoxConstraints(
                  minHeight: constraints.maxHeight,
                ),
                child: IntrinsicHeight(
                  child: Column(
                    crossAxisAlignment: CrossAxisAlignment.start,
                    children: [
                      // Logo dengan jarak yang lebih kecil
                      Center(
                        child: Image.asset(
                          'assets/logo.png',
                          width: 120, // Diperkecil
                          height: 120, // Diperkecil
                          fit: BoxFit.contain,
                          errorBuilder: (context, error, stackTrace) {
                            return Container(
                              width: 120,
                              height: 120,
                              decoration: BoxDecoration(
                                color: Colors.grey[200],
                                borderRadius: BorderRadius.circular(12),
                              ),
                              child: const Icon(
                                Icons.restaurant,
                                size: 40, // Diperkecil
                                color: Colors.grey,
                              ),
                            );
                          },
                        ),
                      ),
                      const SizedBox(height: 30),

                      // Judul Masuk
                      Text(
                        'Masuk',
                        style: AppTheme.headingStyle.copyWith(
                          fontSize: 28,
                        ),
                      ),

                      const SizedBox(height: 8),

                      // Subtitle
                      Text(
                        'Silakan masuk untuk melanjutkan',
                        style: AppTheme.bodyStyle,
                      ),

                      const SizedBox(height: 24),

                      // Form Input
                      _buildEmailField(),

                      const SizedBox(height: 16),

                      _buildPasswordField(),

                      const SizedBox(height: 20),

                      // Tombol Masuk
                      _isLoading
                          ? const Center(child: CircularProgressIndicator())
                          : CustomButton(
                              text: 'Masuk',
                              onPressed: _login,
                            ),

                      const SizedBox(height: 20),

                      // Divider atau separator
                      _buildDivider(),

                      const SizedBox(height: 20),

                      // Link Daftar
                      _buildRegisterSection(),

                      // Spacer dihapus, diganti dengan SizedBox flexible
                      const SizedBox(height: 20),
                    ],
                  ),
                ),
              ),
            );
          },
        ),
      ),
    );
  }

  Widget _buildEmailField() {
    return TextField(
      controller: _emailController,
      decoration: InputDecoration(
        labelText: 'Email',
        hintText: 'Masukan email Anda',
        border: OutlineInputBorder(
          borderRadius: BorderRadius.circular(8),
          borderSide: const BorderSide(color: AppTheme.secondaryColor),
        ),
        focusedBorder: OutlineInputBorder(
          borderRadius: BorderRadius.circular(8),
          borderSide: const BorderSide(color: Color.fromARGB(255, 69, 198, 34)),
        ),
        prefixIcon: const Icon(Icons.email_outlined),
      ),
      keyboardType: TextInputType.emailAddress,
    );
  }

  Widget _buildPasswordField() {
    return Column(
      crossAxisAlignment: CrossAxisAlignment.start,
      children: [
        TextField(
          controller: _passwordController,
          obscureText: _obscurePassword,
          decoration: InputDecoration(
            labelText: 'Password',
            hintText: 'Masukkan password Anda',
            border: OutlineInputBorder(
              borderRadius: BorderRadius.circular(8),
              borderSide: const BorderSide(color: AppTheme.secondaryColor),
            ),
            focusedBorder: OutlineInputBorder(
              borderRadius: BorderRadius.circular(8),
              borderSide: const BorderSide(color: Color.fromARGB(255, 143, 235, 37)),
            ),
            prefixIcon: const Icon(Icons.lock_outline),
            suffixIcon: IconButton(
              icon: Icon(
                _obscurePassword ? Icons.visibility_off : Icons.visibility,
              ),
              onPressed: () {
                setState(() {
                  _obscurePassword = !_obscurePassword;
                });
              },
            ),
          ),
        ),
        const SizedBox(height: 8),
        Align(
          alignment: Alignment.centerRight,
          child: GestureDetector(
            onTap: _goToForgotPassword,
            child: Text(
              'Lupa Password?',
              style: AppTheme.linkStyle.copyWith(
                fontSize: 14,
                fontWeight: FontWeight.w500,
              ),
            ),
          ),
        ),
      ],
    );
  }

  Widget _buildDivider() {
    return Row(
      children: [
        Expanded(
          child: Divider(
            color: AppTheme.secondaryColor.withOpacity(0.3),
          ),
        ),
        Padding(
          padding: const EdgeInsets.symmetric(horizontal: 16),
          child: Text(
            'atau',
            style: AppTheme.bodyStyle.copyWith(fontSize: 14),
          ),
        ),
        Expanded(
          child: Divider(
            color: AppTheme.secondaryColor.withOpacity(0.3),
          ),
        ),
      ],
    );
  }

  Widget _buildRegisterSection() {
    return Row(
      mainAxisAlignment: MainAxisAlignment.center,
      mainAxisSize: MainAxisSize.min,
      children: [
        Text(
          'Belum punya akun?',
          style: AppTheme.bodyStyle,
          softWrap: true,
          overflow: TextOverflow.visible,
        ),
        const SizedBox(width: 8),
        GestureDetector(
          onTap: _goToRegister,
          child: Text(
            'Daftar di sini',
            style: AppTheme.linkStyle.copyWith(
              color: Colors.green,
              fontSize: 16,
              fontWeight: FontWeight.w600,
            ),
            softWrap: true,
            overflow: TextOverflow.visible,
          ),
        ),
      ],
    );
  }

  void _goToRegister() {
    Navigator.push(
      context,
      MaterialPageRoute(builder: (context) => const RegisterPage()),
    );
  }

  void _goToForgotPassword() {
    Navigator.push(
      context,
      MaterialPageRoute(builder: (context) => const ForgotPasswordPage()),
    );
  }

  @override
  void dispose() {
    _emailController.dispose();
    _passwordController.dispose();
    super.dispose();
  }
}