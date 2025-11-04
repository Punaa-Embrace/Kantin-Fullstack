import 'package:flutter/material.dart';
import '../theme/app_theme.dart';
import 'menu/menu_item.dart';
import 'menu/menu_header.dart';
import 'menu/success_message.dart';
import 'menu/search.dart';
import 'menu/tambah_bottom.dart';

class DaftarMenuPage extends StatefulWidget {
  const DaftarMenuPage({super.key});

  @override
  State<DaftarMenuPage> createState() => _DaftarMenuPageState();
}

class _DaftarMenuPageState extends State<DaftarMenuPage> {
  final List<Map<String, dynamic>> _menuList = [
    {
      'id': 1,
      'nama': 'Ayam Bakar',
      'harga': 25000,
      'deskripsi': 'Ayam bakar dengan bumbu spesial',
      'kategori': 'Ayam',
      'tersedia': true,
      'foto': null,
    },
    {
      'id': 2,
      'nama': 'Rendang',
      'harga': 35000,
      'deskripsi': 'Rendang daging sapi asli Padang',
      'kategori': 'Rendang',
      'tersedia': true,
      'foto': null,
    },
    {
      'id': 3,
      'nama': 'Es Teh Manis',
      'harga': 8000,
      'deskripsi': 'Es teh segar dengan gula pasir',
      'kategori': 'Minuman',
      'tersedia': false,
      'foto': null,
    },
  ];

  final TextEditingController _searchController = TextEditingController();
  bool _showSuccessMessage = false;

  @override
  void initState() {
    super.initState();
    if (_showSuccessMessage) {
      Future.delayed(const Duration(seconds: 3), () {
        setState(() {
          _showSuccessMessage = false;
        });
      });
    }
  }

  void _showTambahMenuForm() {
    showModalBottomSheet(
      context: context,
      isScrollControlled: true,
      backgroundColor: Colors.transparent,
      builder: (context) => const TambahMenuBottomSheet(),
    ).then((value) {
      if (value != null && value == true) {
        // Show success message when returning from form
        setState(() {
          _showSuccessMessage = true;
        });
        
        // Hide success message after 3 seconds
        Future.delayed(const Duration(seconds: 3), () {
          if (mounted) {
            setState(() {
              _showSuccessMessage = false;
            });
          }
        });
      }
    });
  }

  void _toggleKetersediaan(int id) {
    setState(() {
      final menu = _menuList.firstWhere((menu) => menu['id'] == id);
      menu['tersedia'] = !menu['tersedia'];
    });
  }

  void _editMenu(Map<String, dynamic> menu) {
    // Implement edit functionality here
    print('Edit menu: ${menu['nama']}');
  }

  void _deleteMenu(int id) {
    showDialog(
      context: context,
      builder: (context) => AlertDialog(
        title: const Text('Hapus Menu'),
        content: const Text('Apakah Anda yakin ingin menghapus menu ini?'),
        actions: [
          TextButton(
            onPressed: () => Navigator.pop(context),
            child: const Text('Batal'),
          ),
          TextButton(
            onPressed: () {
              setState(() {
                _menuList.removeWhere((menu) => menu['id'] == id);
              });
              Navigator.pop(context);
            },
            child: const Text('Hapus', style: TextStyle(color: Colors.red)),
          ),
        ],
      ),
    );
  }

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      backgroundColor: AppTheme.backgroundColor,
      appBar: AppBar(
        title: const Text(
          'Daftar Menu',
          style: TextStyle(
            fontSize: 18,
            fontWeight: FontWeight.w600,
            color: AppTheme.textColor,
          ),
        ),
        centerTitle: true,
        backgroundColor: Colors.white,
        elevation: 0,
      ),
      body: Column(
        children: [
          // Success Message
          SuccessMessage(
            message: 'Menu baru berhasil ditambahkan.',
            isVisible: _showSuccessMessage,
          ),

          // Header dengan Search dan Tambah Button
          SearchAddHeader(
            searchController: _searchController,
            onAddPressed: _showTambahMenuForm,
            onSearchChanged: (value) {
              setState(() {});
            },
          ),

          // Header Table
          const MenuTableHeader(),

          // List Menu
          Expanded(
            child: ListView.builder(
              itemCount: _menuList.length,
              itemBuilder: (context, index) {
                final menu = _menuList[index];
                return MenuItemCard(
                  menu: menu,
                  onToggleAvailability: () => _toggleKetersediaan(menu['id']),
                  onEdit: () => _editMenu(menu),
                  onDelete: () => _deleteMenu(menu['id']),
                );
              },
            ),
          ),
        ],
      ),
    );
  }
}