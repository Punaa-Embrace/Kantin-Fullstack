import 'package:flutter/material.dart';
import '../../widgets/custom_button.dart';
import '../../theme/app_theme.dart';

class TambahMenuBottomSheet extends StatefulWidget {
  const TambahMenuBottomSheet({super.key});

  @override
  State<TambahMenuBottomSheet> createState() => _TambahMenuBottomSheetState();
}

class _TambahMenuBottomSheetState extends State<TambahMenuBottomSheet> {
  final TextEditingController _namaController = TextEditingController();
  final TextEditingController _hargaController = TextEditingController();
  final TextEditingController _deskripsiController = TextEditingController();
  final TextEditingController _kategoriController = TextEditingController();

  final List<String> _kategoriList = ['Ayam', 'Rendang', 'Minuman', 'Makanan Berat', 'Snack'];
  String? _selectedKategori;
  bool _isTersedia = true;
  bool _isLoading = false;

  @override
  Widget build(BuildContext context) {
    return Container(
      height: MediaQuery.of(context).size.height * 0.9,
      decoration: const BoxDecoration(
        color: Colors.white,
        borderRadius: BorderRadius.only(
          topLeft: Radius.circular(16),
          topRight: Radius.circular(16),
        ),
      ),
      child: Column(
        children: [
          // Header
          Container(
            padding: const EdgeInsets.all(16),
            decoration: BoxDecoration(
              border: Border(bottom: BorderSide(color: Colors.grey[300]!)),
            ),
            child: Row(
              children: [
                IconButton(
                  icon: const Icon(Icons.close),
                  onPressed: () => Navigator.pop(context),
                ),
                const SizedBox(width: 8),
                const Text(
                  'Tambah Menu Baru',
                  style: TextStyle(
                    fontSize: 16,
                    fontWeight: FontWeight.w600,
                  ),
                ),
                const Spacer(),
                SizedBox(
                  width: 120,
                  child: CustomButton(
                    text: 'Simpan',
                    onPressed: _simpanMenu,
                    isLoading: _isLoading,
                  ),
                ),
              ],
            ),
          ),

          Expanded(
            child: SingleChildScrollView(
              padding: const EdgeInsets.all(16),
              child: Column(
                crossAxisAlignment: CrossAxisAlignment.start,
                children: [
                  // Nama Menu
                  const Text(
                    'Nama Menu',
                    style: TextStyle(
                      fontSize: 14,
                      fontWeight: FontWeight.w500,
                      color: AppTheme.textColor,
                    ),
                  ),
                  const SizedBox(height: 8),
                  TextFormField(
                    controller: _namaController,
                    decoration: InputDecoration(
                      hintText: 'Masukkan nama menu',
                      border: OutlineInputBorder(
                        borderRadius: BorderRadius.circular(8),
                        borderSide: const BorderSide(color: AppTheme.secondaryColor),
                      ),
                      focusedBorder: OutlineInputBorder(
                        borderRadius: BorderRadius.circular(8),
                        borderSide: const BorderSide(color: AppTheme.primaryColor),
                      ),
                      filled: true,
                      fillColor: Colors.white,
                      contentPadding: const EdgeInsets.symmetric(horizontal: 16, vertical: 12),
                    ),
                  ),

                  const SizedBox(height: 16),

                  // Harga
                  const Text(
                    'Harga (Rp)',
                    style: TextStyle(
                      fontSize: 14,
                      fontWeight: FontWeight.w500,
                      color: AppTheme.textColor,
                    ),
                  ),
                  const SizedBox(height: 8),
                  TextFormField(
                    controller: _hargaController,
                    keyboardType: TextInputType.number,
                    decoration: InputDecoration(
                      hintText: 'Contoh: 25000',
                      border: OutlineInputBorder(
                        borderRadius: BorderRadius.circular(8),
                        borderSide: const BorderSide(color: AppTheme.secondaryColor),
                      ),
                      focusedBorder: OutlineInputBorder(
                        borderRadius: BorderRadius.circular(8),
                        borderSide: const BorderSide(color: AppTheme.primaryColor),
                      ),
                      filled: true,
                      fillColor: Colors.white,
                      contentPadding: const EdgeInsets.symmetric(horizontal: 16, vertical: 12),
                      prefixText: 'Rp ',
                    ),
                  ),

                  const SizedBox(height: 16),

                  // Deskripsi
                  const Text(
                    'Deskripsi',
                    style: TextStyle(
                      fontSize: 14,
                      fontWeight: FontWeight.w500,
                      color: AppTheme.textColor,
                    ),
                  ),
                  const SizedBox(height: 8),
                  TextFormField(
                    controller: _deskripsiController,
                    maxLines: 3,
                    decoration: InputDecoration(
                      hintText: 'Deskripsi menu...',
                      border: OutlineInputBorder(
                        borderRadius: BorderRadius.circular(8),
                        borderSide: const BorderSide(color: AppTheme.secondaryColor),
                      ),
                      focusedBorder: OutlineInputBorder(
                        borderRadius: BorderRadius.circular(8),
                        borderSide: const BorderSide(color: AppTheme.primaryColor),
                      ),
                      filled: true,
                      fillColor: Colors.white,
                      contentPadding: const EdgeInsets.symmetric(horizontal: 16, vertical: 12),
                    ),
                  ),

                  const SizedBox(height: 16),

                  // Kategori
                  const Text(
                    'Kategori',
                    style: TextStyle(
                      fontSize: 14,
                      fontWeight: FontWeight.w500,
                      color: AppTheme.textColor,
                    ),
                  ),
                  const SizedBox(height: 8),
                  Row(
                    children: [
                      Expanded(
                        child: Container(
                          padding: const EdgeInsets.symmetric(horizontal: 12),
                          decoration: BoxDecoration(
                            color: Colors.white,
                            borderRadius: BorderRadius.circular(8),
                            border: Border.all(color: AppTheme.primaryColor),
                          ),
                          child: DropdownButtonFormField<String>(
                            value: _selectedKategori,
                            items: _kategoriList
                                .map((e) => DropdownMenuItem<String>(
                                      value: e,
                                      child: Text(e),
                                    ))
                                .toList(),
                            onChanged: (v) => setState(() => _selectedKategori = v),
                            decoration: const InputDecoration(
                              border: InputBorder.none,
                              hintText: 'Pilih Kategori',
                            ),
                            isExpanded: true,
                          ),
                        ),
                      ),
                      const SizedBox(width: 12),
                      OutlinedButton(
                        onPressed: () {
                          _showTambahKategoriDialog();
                        },
                        style: OutlinedButton.styleFrom(
                          side: const BorderSide(color: AppTheme.primaryColor),
                          shape: RoundedRectangleBorder(
                            borderRadius: BorderRadius.circular(8),
                          ),
                        ),
                        child: const Text(
                          'Buat Baru',
                          style: TextStyle(color: AppTheme.primaryColor),
                        ),
                      ),
                    ],
                  ),

                  const SizedBox(height: 16),

                  // Ketersediaan
                  const Text(
                    'Ketersediaan',
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
                      borderRadius: BorderRadius.circular(8),
                      border: Border.all(color: AppTheme.primaryColor),
                    ),
                    child: DropdownButtonFormField<bool>(
                      value: _isTersedia,
                      items: const [
                        DropdownMenuItem<bool>(
                          value: true,
                          child: Text('Tersedia'),
                        ),
                        DropdownMenuItem<bool>(
                          value: false,
                          child: Text('Tidak Tersedia'),
                        ),
                      ],
                      onChanged: (v) => setState(() => _isTersedia = v!),
                      decoration: const InputDecoration(border: InputBorder.none),
                    ),
                  ),

                  const SizedBox(height: 16),

                  // Foto Menu
                  const Text(
                    'Foto Menu',
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
                      Container(
                        width: 84,
                        height: 84,
                        decoration: BoxDecoration(
                          color: Colors.white,
                          borderRadius: BorderRadius.circular(8),
                          border: Border.all(color: AppTheme.primaryColor, width: 1.6),
                        ),
                        child: const Center(
                          child: Icon(
                            Icons.fastfood,
                            color: AppTheme.secondaryColor,
                            size: 30,
                          ),
                        ),
                      ),
                      const SizedBox(width: 12),
                      Expanded(
                        child: Column(
                          crossAxisAlignment: CrossAxisAlignment.start,
                          children: [
                            SizedBox(
                              width: 140,
                              child: OutlinedButton(
                                onPressed: () {
                                  _pilihGambar();
                                },
                                style: OutlinedButton.styleFrom(
                                  side: const BorderSide(color: AppTheme.primaryColor),
                                  shape: RoundedRectangleBorder(
                                    borderRadius: BorderRadius.circular(8),
                                  ),
                                  backgroundColor: Colors.white,
                                ),
                                child: const Text(
                                  'Pilih Gambar',
                                  style: TextStyle(color: AppTheme.primaryColor),
                                ),
                              ),
                            ),
                            const SizedBox(height: 8),
                            const Text(
                              'PNG, JPG, WEBP hingga 2MB.',
                              style: TextStyle(fontSize: 12, color: AppTheme.secondaryColor),
                            ),
                          ],
                        ),
                      )
                    ],
                  ),
                ],
              ),
            ),
          ),
        ],
      ),
    );
  }

  void _showTambahKategoriDialog() {
    final TextEditingController kategoriController = TextEditingController();
    
    showDialog(
      context: context,
      builder: (context) => AlertDialog(
        title: const Text('Tambah Kategori Baru'),
        content: TextField(
          controller: kategoriController,
          decoration: const InputDecoration(
            hintText: 'Nama kategori baru',
            border: OutlineInputBorder(),
          ),
        ),
        actions: [
          TextButton(
            onPressed: () => Navigator.pop(context),
            child: const Text('Batal'),
          ),
          TextButton(
            onPressed: () {
              if (kategoriController.text.trim().isNotEmpty) {
                setState(() {
                  _kategoriList.add(kategoriController.text.trim());
                  _selectedKategori = kategoriController.text.trim();
                });
                Navigator.pop(context);
              }
            },
            child: const Text('Simpan'),
          ),
        ],
      ),
    );
  }

  void _pilihGambar() {
    // TODO: Implement image picker functionality
    // Untuk sementara, tampilkan snackbar
    ScaffoldMessenger.of(context).showSnackBar(
      const SnackBar(
        content: Text('Fitur pemilihan gambar akan diimplementasi kemudian'),
        duration: Duration(seconds: 2),
      ),
    );
  }

  Future<void> _simpanMenu() async {
    final nama = _namaController.text.trim();
    final harga = _hargaController.text.trim();
    final deskripsi = _deskripsiController.text.trim();

    // Validasi
    if (nama.isEmpty) {
      _showError('Nama menu tidak boleh kosong');
      return;
    }

    if (harga.isEmpty) {
      _showError('Harga tidak boleh kosong');
      return;
    }

    if (_selectedKategori == null) {
      _showError('Pilih kategori menu');
      return;
    }

    // Validasi harga harus angka
    final hargaNumber = int.tryParse(harga);
    if (hargaNumber == null) {
      _showError('Harga harus berupa angka');
      return;
    }

    if (hargaNumber <= 0) {
      _showError('Harga harus lebih dari 0');
      return;
    }

    setState(() {
      _isLoading = true;
    });

    try {
      // Simulasi proses simpan (delay 1.5 detik)
      await Future.delayed(const Duration(milliseconds: 1500));

      // TODO: Implement save to database/API here
      print('Menu disimpan:');
      print('Nama: $nama');
      print('Harga: $hargaNumber');
      print('Deskripsi: $deskripsi');
      print('Kategori: $_selectedKategori');
      print('Tersedia: $_isTersedia');

      // Tampilkan success message
      ScaffoldMessenger.of(context).showSnackBar(
        SnackBar(
          content: Text('Menu "$nama" berhasil ditambahkan'),
          backgroundColor: Colors.green,
          duration: const Duration(seconds: 2),
        ),
      );

      // Kembali ke halaman sebelumnya dengan status success
      if (mounted) {
        Navigator.pop(context, true);
      }
    } catch (e) {
      _showError('Terjadi kesalahan: $e');
    } finally {
      if (mounted) {
        setState(() {
          _isLoading = false;
        });
      }
    }
  }

  void _showError(String message) {
    ScaffoldMessenger.of(context).showSnackBar(
      SnackBar(
        content: Text(message),
        backgroundColor: Colors.red,
        duration: const Duration(seconds: 3),
      ),
    );
  }

  @override
  void dispose() {
    _namaController.dispose();
    _hargaController.dispose();
    _deskripsiController.dispose();
    _kategoriController.dispose();
    super.dispose();
  }
}