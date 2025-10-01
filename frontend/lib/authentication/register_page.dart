import 'package:flutter/material.dart';
import '../widgets/custom_button.dart';
import '../widgets/custom_textfield.dart';
import '../theme/app_theme.dart';

class RegisterPage extends StatefulWidget {
  const RegisterPage({super.key});

  @override
  State<RegisterPage> createState() => _RegisterPageState();
}

class _RegisterPageState extends State<RegisterPage> {
  final TextEditingController _namaController = TextEditingController();
  final TextEditingController _emailController = TextEditingController();
  final TextEditingController _whatsappController = TextEditingController();
  final TextEditingController _passwordController = TextEditingController();
  final TextEditingController _confirmPasswordController = TextEditingController();

  bool _obscurePassword = true;
  bool _obscureConfirmPassword = true;
  bool _agreeToTerms = false;

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      backgroundColor: AppTheme.backgroundColor,
      appBar: AppBar(
        backgroundColor: Colors.transparent,
        elevation: 0,
        leading: IconButton(
          icon: const Icon(Icons.arrow_back, color: AppTheme.textColor),
          onPressed: () => Navigator.pop(context),
        ),
      ),
      body: SafeArea(
        child: Padding(
          padding: const EdgeInsets.all(24.0),
          child: SingleChildScrollView(
            child: Column(
              crossAxisAlignment: CrossAxisAlignment.start,
              children: [
                const SizedBox(height: 20),

              Center(
                child: Image.asset(
                  'assets/logo.png',
                  width: 180,
                  height: 180,
                  fit: BoxFit.contain,
                ),
              ),
              const SizedBox(height: 20),

                // Judul
                Text(
                  'Daftar Akun Baru',
                  style: AppTheme.headingStyle.copyWith(
                    fontSize: 28,
                  ),
                ),
                
                const SizedBox(height: 8),
                
                // Subtitle
                Text(
                  'Buat akun untuk mulai memesan',
                  style: AppTheme.bodyStyle,
                ),
                
                const SizedBox(height: 32),
                
                // Form Input
                _buildNamaField(),
                
                const SizedBox(height: 20),
                
                _buildEmailField(),
                
                const SizedBox(height: 20),
                
                _buildWhatsAppField(),
                
                const SizedBox(height: 20),
                
                _buildPasswordField(),
                
                const SizedBox(height: 20),
                
                _buildConfirmPasswordField(),
                
                const SizedBox(height: 20),
                
                // Checkbox Syarat & Ketentuan
                _buildTermsCheckbox(),
                
                const SizedBox(height: 8),
                
                // Link Lupa Password
                _buildForgotPasswordLink(),
                
                const SizedBox(height: 24),
                
                // Tombol Daftar
                CustomButton(
                  text: 'Daftar',
                  onPressed: _agreeToTerms ? _register : null,
                ),
                
                const SizedBox(height: 32),
                
                // Link ke Login
                _buildLoginLink(),
              ],
            ),
          ),
        ),
      ),
    );
  }

  Widget _buildNamaField() {
    return CustomTextField(
      label: 'Nama Lengkap',
      hintText: 'nama',
      controller: _namaController,
      prefixIcon: const Icon(Icons.person_outline, color: AppTheme.secondaryColor),
    );
  }

  Widget _buildEmailField() {
    return CustomTextField(
      label: 'Alamat Email',
      hintText: 'email',
      controller: _emailController,
      keyboardType: TextInputType.emailAddress,
      prefixIcon: const Icon(Icons.email_outlined, color: AppTheme.secondaryColor),
    );
  }

  Widget _buildWhatsAppField() {
    return Column(
      crossAxisAlignment: CrossAxisAlignment.start,
      children: [
        const Text(
          'Nomor WhatsApp',
          style: TextStyle(
            fontSize: 14,
            fontWeight: FontWeight.w500,
            color: AppTheme.textColor,
          ),
        ),
        const SizedBox(height: 8),
        Container(
          decoration: BoxDecoration(
            color: Colors.white,
            borderRadius: BorderRadius.circular(8),
            border: Border.all(color: AppTheme.secondaryColor),
          ),
          child: Row(
            children: [
              // Country Code
              Container(
                padding: const EdgeInsets.symmetric(horizontal: 12, vertical: 12),
                decoration: BoxDecoration(
                  border: Border(
                    right: BorderSide(color: AppTheme.secondaryColor.withOpacity(0.3)),
                  ),
                ),
                child: Row(
                  mainAxisSize: MainAxisSize.min,
                  children: [
                    Text(
                      '+62',
                      style: TextStyle(
                        color: AppTheme.textColor,
                        fontWeight: FontWeight.w500,
                      ),
                    ),
                    const SizedBox(width: 4),
                    const Icon(Icons.arrow_drop_down, size: 20),
                  ],
                ),
              ),
              // Phone Number Input
              Expanded(
                child: TextField(
                  controller: _whatsappController,
                  keyboardType: TextInputType.phone,
                  decoration: const InputDecoration(
                    hintText: '81234567890',
                    border: InputBorder.none,
                    contentPadding: EdgeInsets.symmetric(horizontal: 16),
                  ),
                ),
              ),
            ],
          ),
        ),
      ],
    );
  }

  Widget _buildPasswordField() {
    return CustomTextField(
      label: 'Kata Sandi',
      hintText: '******',
      controller: _passwordController,
      obscureText: _obscurePassword,
      prefixIcon: const Icon(Icons.lock_outline, color: AppTheme.secondaryColor),
      suffixIcon: IconButton(
        icon: Icon(
          _obscurePassword ? Icons.visibility_off : Icons.visibility,
          color: AppTheme.secondaryColor,
        ),
        onPressed: () {
          setState(() {
            _obscurePassword = !_obscurePassword;
          });
        },
      ),
    );
  }

  Widget _buildConfirmPasswordField() {
    return CustomTextField(
      label: 'Konfirmasi Kata Sandi',
      hintText: '******',
      controller: _confirmPasswordController,
      obscureText: _obscureConfirmPassword,
      prefixIcon: const Icon(Icons.lock_outline, color: AppTheme.secondaryColor),
      suffixIcon: IconButton(
        icon: Icon(
          _obscureConfirmPassword ? Icons.visibility_off : Icons.visibility,
          color: AppTheme.secondaryColor,
        ),
        onPressed: () {
          setState(() {
            _obscureConfirmPassword = !_obscureConfirmPassword;
          });
        },
      ),
    );
  }

  Widget _buildTermsCheckbox() {
    return Row(
      children: [
        Checkbox(
          value: _agreeToTerms,
          onChanged: (value) {
            setState(() {
              _agreeToTerms = value ?? false;
            });
          },
          activeColor: AppTheme.primaryColor,
        ),
        Expanded(
          child: RichText(
            text: TextSpan(
              style: AppTheme.bodyStyle.copyWith(fontSize: 14),
              children: [
                const TextSpan(text: 'Saya menyetujui '),
                TextSpan(
                  text: 'Syarat & Ketentuan',
                  style: const TextStyle(
                    color: AppTheme.primaryColor,
                    fontWeight: FontWeight.w500,
                  ),
                ),
                const TextSpan(text: ' dan '),
                TextSpan(
                  text: 'Kebijakan Privasi',
                  style: const TextStyle(
                    color: AppTheme.primaryColor,
                    fontWeight: FontWeight.w500,
                  ),
                ),
              ],
            ),
          ),
        ),
      ],
    );
  }

  Widget _buildForgotPasswordLink() {
    return Align(
      alignment: Alignment.centerRight,
      child: GestureDetector(
        onTap: _forgotPassword,
        child: Text(
          'Lupa Kata Sandi?',
          style: AppTheme.linkStyle.copyWith(
            fontSize: 14,
            fontWeight: FontWeight.w500,
          ),
        ),
      ),
    );
  }

  Widget _buildLoginLink() {
    return Center(
      child: Row(
        mainAxisAlignment: MainAxisAlignment.center,
        children: [
          Text(
            'Sudah punya akun? ',
            style: AppTheme.bodyStyle,
          ),
          GestureDetector(
            onTap: _goToLogin,
            child: Text(
              'Masuk di sini',
              style: AppTheme.linkStyle.copyWith(
                fontSize: 14,
                fontWeight: FontWeight.w600,
              ),
            ),
          ),
        ],
      ),
    );
  }

  void _register() {
    // Validasi form
    if (_namaController.text.isEmpty ||
        _emailController.text.isEmpty ||
        _whatsappController.text.isEmpty ||
        _passwordController.text.isEmpty ||
        _confirmPasswordController.text.isEmpty) {
      ScaffoldMessenger.of(context).showSnackBar(
        const SnackBar(
          content: Text('Harap isi semua field'),
        ),
      );
      return;
    }

    if (_passwordController.text != _confirmPasswordController.text) {
      ScaffoldMessenger.of(context).showSnackBar(
        const SnackBar(
          content: Text('Konfirmasi kata sandi tidak sesuai'),
        ),
      );
      return;
    }

    if (!_agreeToTerms) {
      ScaffoldMessenger.of(context).showSnackBar(
        const SnackBar(
          content: Text('Harap menyetujui syarat dan ketentuan'),
        ),
      );
      return;
    }

    // Implementasi registrasi logic di sini
    print('Register attempt:');
    print('Nama: ${_namaController.text}');
    print('Email: ${_emailController.text}');
    print('WhatsApp: +62${_whatsappController.text}');
    
    // Simulasi registrasi berhasil
    ScaffoldMessenger.of(context).showSnackBar(
      const SnackBar(
        content: Text('Registrasi berhasil!'),
      ),
    );
    
    // Navigasi kembali ke login setelah 2 detik
    Future.delayed(const Duration(seconds: 2), () {
      Navigator.pop(context);
    });
  }

  void _forgotPassword() {
    // Navigasi ke halaman lupa password
    ScaffoldMessenger.of(context).showSnackBar(
      const SnackBar(
        content: Text('Navigasi ke halaman lupa password'),
      ),
    );
  }

  void _goToLogin() {
    Navigator.pop(context);
  }

  @override
  void dispose() {
    _namaController.dispose();
    _emailController.dispose();
    _whatsappController.dispose();
    _passwordController.dispose();
    _confirmPasswordController.dispose();
    super.dispose();
  }
}