import 'package:flutter/material.dart';
import '../widgets/custom_button.dart';
import '../widgets/custom_textfield.dart';
import '../theme/app_theme.dart';
import 'otp_verification_page.dart';

class ForgotPasswordPage extends StatefulWidget {
  const ForgotPasswordPage({super.key});

  @override
  State<ForgotPasswordPage> createState() => _ForgotPasswordPageState();
}

class _ForgotPasswordPageState extends State<ForgotPasswordPage> {
  final TextEditingController _whatsappController = TextEditingController();
  bool _isLoading = false;

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
                'Lupa Kata Sandi',
                style: AppTheme.headingStyle.copyWith(
                  fontSize: 28,
                ),
              ),

              const SizedBox(height: 8),

              // Subtitle
              Text(
                'Masukkan nomor WhatsApp Anda, kami akan mengirimkan kode OTP untuk reset kata sandi.',
                style: AppTheme.bodyStyle,
              ),

              const SizedBox(height: 32),

              // Input WhatsApp (pakai CustomTextField)
              CustomTextField(
                label: 'Nomor WhatsApp',
                hintText: '81234567890',
                controller: _whatsappController,
                keyboardType: TextInputType.phone,
                prefixIcon: Container(
                  width: 70,
                  alignment: Alignment.center,
                  decoration: BoxDecoration(
                    border: Border(
                      right: BorderSide(
                        color: AppTheme.secondaryColor.withOpacity(0.3),
                      ),
                    ),
                  ),
                  child: Row(
                    mainAxisSize: MainAxisSize.min,
                    children: const [
                      Text(
                        '+62',
                        style: TextStyle(
                          fontWeight: FontWeight.w500,
                          color: AppTheme.textColor,
                        ),
                      ),
                      SizedBox(width: 4),
                      Icon(Icons.arrow_drop_down, size: 20),
                    ],
                  ),
                ),
              ),

              const SizedBox(height: 32),

              // Tombol Kirim OTP
              _isLoading
                  ? const Center(child: CircularProgressIndicator())
                  : CustomButton(
                      text: 'Kirim Kode OTP',
                      onPressed: _sendOTP,
                    ),

              const Spacer(),

              // Link kembali ke login
              _buildBackToLoginLink(),
            ],
          ),
        ),
      ),
    );
  }

  Widget _buildBackToLoginLink() {
    return Center(
      child: GestureDetector(
        onTap: _goBackToLogin,
        child: RichText(
          text: TextSpan(
            style: AppTheme.bodyStyle,
            children: [
              const TextSpan(text: 'Ingat kata sandi Anda? '),
              TextSpan(
                text: 'Kembali ke halaman Masuk',
                style: AppTheme.linkStyle.copyWith(
                  fontSize: 14,
                  fontWeight: FontWeight.w600,
                ),
              ),
            ],
          ),
        ),
      ),
    );
  }

  void _sendOTP() {
    final whatsapp = _whatsappController.text.trim();

    if (whatsapp.isEmpty) {
      ScaffoldMessenger.of(context).showSnackBar(
        const SnackBar(
          content: Text('Harap masukkan nomor WhatsApp'),
        ),
      );
      return;
    }

    if (whatsapp.length < 10) {
      ScaffoldMessenger.of(context).showSnackBar(
        const SnackBar(
          content: Text('Nomor WhatsApp tidak valid'),
        ),
      );
      return;
    }

    setState(() {
      _isLoading = true;
    });

    // Simulasi pengiriman OTP
    Future.delayed(const Duration(seconds: 2), () {
      setState(() {
        _isLoading = false;
      });

      // Navigasi ke halaman verifikasi OTP
      Navigator.push(
        context,
        MaterialPageRoute(
          builder: (context) => OTPVerificationPage(
            phoneNumber: '+62$whatsapp',
          ),
        ),
      );
    });
  }

  void _goBackToLogin() {
    Navigator.pop(context);
  }

  @override
  void dispose() {
    _whatsappController.dispose();
    super.dispose();
  }
}
