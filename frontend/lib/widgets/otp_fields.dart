import 'package:flutter/material.dart';
import '../theme/app_theme.dart';

class OTPField extends StatefulWidget {
  final int length;
  final ValueChanged<String> onChanged;
  final ValueChanged<String>? onCompleted;

  const OTPField({
    super.key,
    this.length = 6,
    required this.onChanged,
    this.onCompleted,
  });

  @override
  State<OTPField> createState() => _OTPFieldState();
}

class _OTPFieldState extends State<OTPField> {
  final List<TextEditingController> _controllers = [];
  final List<FocusNode> _focusNodes = [];

  @override
  void initState() {
    super.initState();
    for (int i = 0; i < widget.length; i++) {
      _controllers.add(TextEditingController());
      _focusNodes.add(FocusNode());
    }
  }

  @override
  void dispose() {
    for (var controller in _controllers) {
      controller.dispose();
    }
    for (var node in _focusNodes) {
      node.dispose();
    }
    super.dispose();
  }

  @override
  Widget build(BuildContext context) {
    return Row(
      mainAxisAlignment: MainAxisAlignment.spaceBetween,
      children: List.generate(widget.length, (index) {
        return SizedBox(
          width: 50,
          height: 50,
          child: TextField(
            controller: _controllers[index],
            focusNode: _focusNodes[index],
            textAlign: TextAlign.center,
            keyboardType: TextInputType.number,
            maxLength: 1,
            style: const TextStyle(
              fontSize: 18,
              fontWeight: FontWeight.bold,
              color: Colors.black,
            ),
            decoration: InputDecoration(
              counterText: '',
              filled: true,
              fillColor: Colors.grey[100],
              border: OutlineInputBorder(
                borderRadius: BorderRadius.circular(8),
                borderSide: BorderSide.none,
              ),
              focusedBorder: OutlineInputBorder(
                borderRadius: BorderRadius.circular(8),
                borderSide: const BorderSide(color: AppTheme.primaryColor, width: 2),
              ),
            ),
            onChanged: (value) {
              if (value.length == 1) {
                // Pindah ke field berikutnya
                if (index < widget.length - 1) {
                  _focusNodes[index + 1].requestFocus();
                }
                
                // Kumpulkan semua nilai OTP
                String otp = _getOTPValue();
                widget.onChanged(otp);
                
                // Jika OTP lengkap
                if (otp.length == widget.length) {
                  widget.onCompleted?.call(otp);
                }
              } else if (value.isEmpty) {
                // Pindah ke field sebelumnya
                if (index > 0) {
                  _focusNodes[index - 1].requestFocus();
                }
              }
            },
          ),
        );
      }),
    );
  }

  String _getOTPValue() {
    String otp = '';
    for (var controller in _controllers) {
      otp += controller.text;
    }
    return otp;
  }
}