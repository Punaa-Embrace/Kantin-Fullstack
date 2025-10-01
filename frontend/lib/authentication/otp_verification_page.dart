import 'package:flutter/material.dart';
import '../widgets/custom_button.dart';
import '../widgets/otp_fields.dart';
import '../theme/app_theme.dart';
import 'reset_password_page.dart';

class OTPVerificationPage extends StatefulWidget {
  final String phoneNumber;

  const OTPVerificationPage({
    super.key,
    required this.phoneNumber,
  });

  @override
  State<OTPVerificationPage> createState() => _OTPVerificationPageState();
}

class _OTPVerificationPageState extends State<OTPVerificationPage> {
  final TextEditingController _otpController = TextEditingController();
  bool _isLoading = false;
  int _countdown = 60;
  bool _canResend = false;

  @override
  void initState() {
    super.initState();
    _startCountdown();
  }

  void _startCountdown() {
    Future.delayed(const Duration(seconds: 1), () {
      if (_countdown > 0) {
        setState(() {
          _countdown--;
        });
        _startCountdown();
      } else {
        setState(() {
          _canResend = true;
        });
      }
    });
  }

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      backgroundColor: Colors.white,
      appBar: AppBar(
        backgroundColor: Colors.white,
        elevation: 0,
        leading: IconButton(
          icon: const Icon(Icons.arrow_back, color: Colors.black),
          onPressed: () => Navigator.pop(context),
        ),
        centerTitle: true,
        title: const Text(
          'Verifikasi OTP',
          style: TextStyle(
            color: Colors.black,
            fontSize: 18,
            fontWeight: FontWeight.w600,
          ),
        ),
      ),
      body: SafeArea(
        child: Padding(
          padding: const EdgeInsets.all(24.0),
          child: Column(
            crossAxisAlignment: CrossAxisAlignment.start,
            children: [
              const SizedBox(height: 20),
              
              // Subtitle
              Text(
                'Kami telah mengirimkan kode 6 digit ke nomor WhatsApp Anda yang terdaftar.',
                style: TextStyle(
                  fontSize: 14,
                  color: Colors.grey[700],
                  height: 1.5,
                ),
              ),
              
              const SizedBox(height: 24),
              
              // Informasi pengiriman OTP
              Container(
                padding: const EdgeInsets.all(16),
                decoration: BoxDecoration(
                  color: const Color(0xFFF0F7FF),
                  borderRadius: BorderRadius.circular(8),
                  border: Border.all(color: const Color(0xFFD6E8FF)),
                ),
                child: Row(
                  children: [
                    Icon(Icons.info_outline, color: AppTheme.primaryColor, size: 20),
                    const SizedBox(width: 12),
                    Expanded(
                      child: Text(
                        'Kode OTP untuk reset password telah dikirim',
                        style: TextStyle(
                          fontSize: 14,
                          color: AppTheme.primaryColor,
                          fontWeight: FontWeight.w500,
                        ),
                      ),
                    ),
                  ],
                ),
              ),
              
              const SizedBox(height: 32),
              
              // Label Kode OTP
              const Text(
                'Kode OTP',
                style: TextStyle(
                  fontSize: 14,
                  fontWeight: FontWeight.w600,
                  color: Colors.black,
                ),
              ),
              
              const SizedBox(height: 12),
              
              // Field OTP
              Center(
                child: OTPField(
                  onChanged: (otp) {
                    _otpController.text = otp;
                  },
                  onCompleted: (otp) {
                    _verifyOTP(otp);
                  },
                ),
              ),
              
              const SizedBox(height: 40),
              
              // Divider
              const Divider(color: Colors.grey),
              
              const SizedBox(height: 24),
              
              // Tombol Verifikasi
              _isLoading
                  ? const Center(child: CircularProgressIndicator())
                  : CustomButton(
                      text: 'Verifikasi',
                      onPressed: _otpController.text.length == 6 
                          ? () => _verifyOTP(_otpController.text)
                          : null,
                    ),
              
              const SizedBox(height: 24),
              
              // Tombol Kirim Ulang
              Center(
                child: _canResend
                    ? TextButton(
                        onPressed: _resendOTP,
                        child: Text(
                          'Kirim Ulang Kode OTP',
                          style: TextStyle(
                            color: AppTheme.primaryColor,
                            fontSize: 16,
                            fontWeight: FontWeight.w600,
                          ),
                        ),
                      )
                    : Text(
                        'Kirim ulang dalam $_countdown detik',
                        style: TextStyle(
                          color: Colors.grey[600],
                          fontSize: 14,
                        ),
                      ),
              ),
              
              const Spacer(),
            ],
          ),
        ),
      ),
    );
  }

  void _verifyOTP(String otp) {
    if (otp.length != 6) {
      ScaffoldMessenger.of(context).showSnackBar(
        const SnackBar(
          content: Text('Kode OTP harus 6 digit'),
        ),
      );
      return;
    }

    setState(() {
      _isLoading = true;
    });

    // Simulasi verifikasi OTP
    Future.delayed(const Duration(seconds: 2), () {
      setState(() {
        _isLoading = false;
      });

      // Navigasi ke halaman reset password
      Navigator.push(
        context,
        MaterialPageRoute(
          builder: (context) => ResetPasswordPage(
            phoneNumber: widget.phoneNumber,
          ),
        ),
      );
    });
  }

  void _resendOTP() {
    if (!_canResend) return;

    setState(() {
      _canResend = false;
      _countdown = 60;
    });

    _startCountdown();

    ScaffoldMessenger.of(context).showSnackBar(
      const SnackBar(
        content: Text('Kode OTP telah dikirim ulang'),
      ),
    );
  }
}