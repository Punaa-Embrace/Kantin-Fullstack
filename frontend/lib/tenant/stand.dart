import 'package:flutter/material.dart';
import 'package:image_picker/image_picker.dart';
import '../theme/app_theme.dart';
import '../widgets/custom_textfield.dart';
import '../widgets/custom_button.dart';

class StandEditPage extends StatefulWidget {
  const StandEditPage({super.key});

  @override
  State<StandEditPage> createState() => _StandEditPageState();
}


class _StandEditPageState extends State<StandEditPage> {
  final TextEditingController _nameController = TextEditingController(text: 'Aca Suka Robux');
  final TextEditingController _descController = TextEditingController(text: 'Aca Suka Robux, Nyanyi');
  final ImagePicker _imagePicker = ImagePicker();

  String? _selectedGedung = 'GU';
  String? _selectedStatus = 'Buka';
  XFile? _selectedImage;
  bool _isLoading = false;

  final List<String> _gedungOptions = const ['GU', 'LB', 'LT'];
  final List<String> _statusOptions = const ['Buka', 'Tutup'];

  @override
  void dispose() {
    _nameController.dispose();
    _descController.dispose();
    super.dispose();
  }

  Future<void> _pickImage() async {
    try {
      final XFile? image = await _imagePicker.pickImage(
        source: ImageSource.gallery,
        maxWidth: 1200,
        maxHeight: 1200,
        imageQuality: 80,
      );
      
      if (image != null) {
        // Check file size (2MB limit)
        final file = await image.readAsBytes();
        if (file.lengthInBytes > 2 * 1024 * 1024) {
          if (mounted) {
            ScaffoldMessenger.of(context).showSnackBar(
              const SnackBar(
                content: Text('Ukuran gambar melebihi 2MB'),
                backgroundColor: Colors.red,
              ),
            );
          }
          return;
        }

        setState(() {
          _selectedImage = image;
        });
      }
    } catch (e) {
      if (mounted) {
        ScaffoldMessenger.of(context).showSnackBar(
          SnackBar(
            content: Text('Gagal memilih gambar: $e'),
            backgroundColor: Colors.red,
          ),
        );
      }
    }
  }

  Future<void> _takePhoto() async {
    try {
      final XFile? image = await _imagePicker.pickImage(
        source: ImageSource.camera,
        maxWidth: 1200,
        maxHeight: 1200,
        imageQuality: 80,
      );
      
      if (image != null) {
        setState(() {
          _selectedImage = image;
        });
      }
    } catch (e) {
      if (mounted) {
        ScaffoldMessenger.of(context).showSnackBar(
          SnackBar(
            content: Text('Gagal mengambil foto: $e'),
            backgroundColor: Colors.red,
          ),
        );
      }
    }
  }

  Future<void> _saveChanges() async {
  if (_nameController.text.trim().isEmpty) {
    ScaffoldMessenger.of(context).showSnackBar(
      const SnackBar(
        content: Text('Nama stand tidak boleh kosong'),
        backgroundColor: Colors.red,
      ),
    );
    return;
  }

  setState(() {
    _isLoading = true;
  });

  // Simulasi API call yang singkat
  await Future.delayed(const Duration(milliseconds: 500)); // DIPERCEPAT

  setState(() {
    _isLoading = false;
  });

  if (mounted) {
    ScaffoldMessenger.of(context).showSnackBar(
      SnackBar(
        content: const Text('Perubahan berhasil disimpan'),
        backgroundColor: AppTheme.primaryColor,
        behavior: SnackBarBehavior.floating,
      ),
    );
  }
}

  void _showImageSourceDialog() {
    showDialog(
      context: context,
      builder: (context) => AlertDialog(
        title: const Text(
          'Pilih Sumber Gambar',
          style: TextStyle(fontSize: 16, fontWeight: FontWeight.w600),
        ),
        content: const Text('Pilih metode untuk menambahkan foto stand'),
        actions: [
          TextButton(
            onPressed: () {
              Navigator.pop(context);
              _pickImage();
            },
            child: const Text('Galeri'),
          ),
          TextButton(
            onPressed: () {
              Navigator.pop(context);
              _takePhoto();
            },
            child: const Text('Kamera'),
          ),
        ],
      ),
    );
  }

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      backgroundColor: AppTheme.backgroundColor,
      body: SafeArea(
        child: SingleChildScrollView(
          padding: const EdgeInsets.symmetric(horizontal: 20, vertical: 18),
          child: Column(
            crossAxisAlignment: CrossAxisAlignment.start,
            children: [
              Container(
                width: double.infinity,
                decoration: AppTheme.cardDecoration,
                padding: const EdgeInsets.all(20),
                child: Column(
                  crossAxisAlignment: CrossAxisAlignment.start,
                  children: [
                    // Nama Stand
                    CustomTextField(
                      label: 'Nama Stand',
                      hintText: 'Masukkan nama stand',
                      controller: _nameController,
                    ),

                    const SizedBox(height: 20),

                    // Deskripsi (multiline)
                    const Text(
                      'Deskripsi Stand',
                      style: TextStyle(
                        fontSize: 14,
                        fontWeight: FontWeight.w500,
                        color: AppTheme.textColor,
                      ),
                    ),
                    const SizedBox(height: 8),
                    TextFormField(
                      controller: _descController,
                      maxLines: 5,
                      decoration: InputDecoration(
                        hintText: 'Deskripsi singkat tentang stand',
                        border: OutlineInputBorder(
                          borderRadius: BorderRadius.circular(12),
                          borderSide: const BorderSide(color: AppTheme.secondaryColor),
                        ),
                        focusedBorder: OutlineInputBorder(
                          borderRadius: BorderRadius.circular(12),
                          borderSide: const BorderSide(color: AppTheme.primaryColor),
                        ),
                        filled: true,
                        fillColor: Colors.white,
                        contentPadding: const EdgeInsets.symmetric(horizontal: 16, vertical: 16),
                      ),
                    ),

                    const SizedBox(height: 20),

                    // Gedung dropdown
                    const Text(
                      'Gedung',
                      style: TextStyle(
                        fontSize: 14,
                        fontWeight: FontWeight.w500,
                        color: AppTheme.textColor,
                      ),
                    ),
                    const SizedBox(height: 8),
                    Container(
                      padding: const EdgeInsets.symmetric(horizontal: 12),
                      decoration: BoxDecoration(
                        color: Colors.white,
                        borderRadius: BorderRadius.circular(12),
                        border: Border.all(color: AppTheme.primaryColor),
                      ),
                      child: DropdownButtonFormField<String>(
                        value: _selectedGedung,
                        items: _gedungOptions
                            .map((e) => DropdownMenuItem<String>(
                                  value: e,
                                  child: Text(
                                    e,
                                    style: const TextStyle(fontSize: 14),
                                  ),
                                ))
                            .toList(),
                        onChanged: (v) => setState(() => _selectedGedung = v),
                        decoration: const InputDecoration(
                          border: InputBorder.none,
                          contentPadding: EdgeInsets.symmetric(horizontal: 8),
                        ),
                        icon: const Icon(Icons.arrow_drop_down, color: AppTheme.primaryColor),
                      ),
                    ),

                    const SizedBox(height: 16),

                    // Status buka dropdown
                    const Text(
                      'Status Buka',
                      style: TextStyle(
                        fontSize: 14,
                        fontWeight: FontWeight.w500,
                        color: AppTheme.textColor,
                      ),
                    ),
                    const SizedBox(height: 8),
                    Container(
                      padding: const EdgeInsets.symmetric(horizontal: 12),
                      decoration: BoxDecoration(
                        color: Colors.white,
                        borderRadius: BorderRadius.circular(12),
                        border: Border.all(color: AppTheme.primaryColor),
                      ),
                      child: DropdownButtonFormField<String>(
                        value: _selectedStatus,
                        items: _statusOptions
                            .map((e) => DropdownMenuItem<String>(
                                  value: e,
                                  child: Text(
                                    e,
                                    style: const TextStyle(fontSize: 14),
                                  ),
                                ))
                            .toList(),
                        onChanged: (v) => setState(() => _selectedStatus = v),
                        decoration: const InputDecoration(
                          border: InputBorder.none,
                          contentPadding: EdgeInsets.symmetric(horizontal: 8),
                        ),
                        icon: const Icon(Icons.arrow_drop_down, color: AppTheme.primaryColor),
                      ),
                    ),

                    const SizedBox(height: 20),

                    // Foto Stand
                    const Text(
                      'Foto Stand',
                      style: TextStyle(
                        fontSize: 14,
                        fontWeight: FontWeight.w500,
                        color: AppTheme.textColor,
                      ),
                    ),
                    const SizedBox(height: 8),
                    
                    Row(
                      crossAxisAlignment: CrossAxisAlignment.start,
                      children: [
                        // Image Preview
                        GestureDetector(
                          onTap: _showImageSourceDialog,
                          child: Container(
                            width: 100,
                            height: 100,
                            decoration: BoxDecoration(
                              color: Colors.white,
                              borderRadius: BorderRadius.circular(12),
                              border: Border.all(
                                color: AppTheme.primaryColor,
                                width: 2,
                              ),
                            ),
                            child: _selectedImage != null
                                ? ClipRRect(
                                    borderRadius: BorderRadius.circular(10),
                                    child: FutureBuilder(
                                      future: _selectedImage!.readAsBytes(),
                                      builder: (context, snapshot) {
                                        if (snapshot.hasData) {
                                          return Image.memory(
                                            snapshot.data!,
                                            width: 100,
                                            height: 100,
                                            fit: BoxFit.cover,
                                          );
                                        }
                                        return const Center(
                                          child: CircularProgressIndicator(),
                                        );
                                      },
                                    ),
                                  )
                                : const Center(
                                    child: Column(
                                      mainAxisAlignment: MainAxisAlignment.center,
                                      children: [
                                        Icon(
                                          Icons.image,
                                          color: AppTheme.secondaryColor,
                                          size: 30,
                                        ),
                                        SizedBox(height: 4),
                                        Text(
                                          'Foto',
                                          style: TextStyle(
                                            fontSize: 12,
                                            color: AppTheme.secondaryColor,
                                          ),
                                        ),
                                      ],
                                    ),
                                  ),
                          ),
                        ),

                        const SizedBox(width: 16),

                        // Upload Buttons
                        Expanded(
                          child: Column(
                            crossAxisAlignment: CrossAxisAlignment.start,
                            children: [
                              Wrap(
                                spacing: 12,
                                runSpacing: 8,
                                children: [
                                  ElevatedButton(
                                    onPressed: _pickImage,
                                    style: ElevatedButton.styleFrom(
                                      backgroundColor: AppTheme.primaryColor,
                                      foregroundColor: Colors.white,
                                      shape: RoundedRectangleBorder(
                                        borderRadius: BorderRadius.circular(8),
                                      ),
                                      padding: const EdgeInsets.symmetric(horizontal: 16, vertical: 8),
                                    ),
                                    child: const Text(
                                      'Pilih dari Galeri',
                                      style: TextStyle(fontSize: 13),
                                    ),
                                  ),
                                  OutlinedButton(
                                    onPressed: _takePhoto,
                                    style: OutlinedButton.styleFrom(
                                      side: const BorderSide(color: AppTheme.primaryColor),
                                      shape: RoundedRectangleBorder(
                                        borderRadius: BorderRadius.circular(8),
                                      ),
                                      padding: const EdgeInsets.symmetric(horizontal: 16, vertical: 8),
                                    ),
                                    child: const Text(
                                      'Ambil Foto',
                                      style: TextStyle(
                                        fontSize: 13,
                                        color: AppTheme.primaryColor,
                                      ),
                                    ),
                                  ),
                                ],
                              ),
                              const SizedBox(height: 8),
                              const Text(
                                'Format: PNG, JPG, WEBP. Maksimal 2MB',
                                style: TextStyle(
                                  fontSize: 12,
                                  color: AppTheme.secondaryColor,
                                ),
                              ),
                              if (_selectedImage != null) ...[
                                const SizedBox(height: 8),
                                Text(
                                  'File: ${_selectedImage!.name}',
                                  style: const TextStyle(
                                    fontSize: 11,
                                    color: Colors.green,
                                    fontWeight: FontWeight.w500,
                                  ),
                                  maxLines: 1,
                                  overflow: TextOverflow.ellipsis,
                                ),
                              ],
                            ],
                          ),
                        ),
                      ],
                    ),

                    const SizedBox(height: 24),

                    // Save button
                    CustomButton(
                      text: 'Simpan Perubahan',
                      onPressed: _isLoading ? null : _saveChanges,
                      isLoading: _isLoading,
                    ),
                  ],
                ),
              ),
            ],
          ),
        ),
      ),
    );
  }
}