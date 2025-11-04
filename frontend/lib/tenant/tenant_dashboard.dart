import 'package:flutter/material.dart';
import '../theme/app_theme.dart';
import '../tenant/stand.dart';
import '../tenant/manage_order_page.dart';
import '../tenant/daftar_page.dart';
import '../student/profile_page.dart';

class TenantDashboardPage extends StatefulWidget {
  const TenantDashboardPage({super.key});

  @override
  State<TenantDashboardPage> createState() => _TenantDashboardPageState();
}

class _TenantDashboardPageState extends State<TenantDashboardPage> {
  int _currentIndex = 0;
  
  final List<Widget> _pages = [
    const DashboardContent(), 
    const StandEditPage(),
    const ManajemenPesananPage(),
    const DaftarMenuPage(),
    const ProfilePage(),
  ];

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      backgroundColor: AppTheme.backgroundColor,
      body: _pages[_currentIndex],
      bottomNavigationBar: BottomNavigationBar(
        currentIndex: _currentIndex,
        onTap: (index) {
          setState(() {
            _currentIndex = index;
          });
        },
        type: BottomNavigationBarType.fixed,
        selectedItemColor: AppTheme.primaryColor,
        unselectedItemColor: Colors.grey,
        items: const [
          BottomNavigationBarItem(icon: Icon(Icons.dashboard_outlined), label: 'Dashboard'),
          BottomNavigationBarItem(icon: Icon(Icons.edit_note), label: 'Edit Stand'),
          BottomNavigationBarItem(icon: Icon(Icons.list_alt), label: 'Pesanan'),
          BottomNavigationBarItem(icon: Icon(Icons.restaurant_menu), label: 'Daftar Menu'),
          BottomNavigationBarItem(icon: Icon(Icons.person_outline), label: 'Profile'),
        ],
      ),
    );
  }
}

class DashboardContent extends StatelessWidget {
  const DashboardContent({super.key});

  @override
  Widget build(BuildContext context) {
    final List<Map<String, String>> _orders = [
      {
        'kode': 'JKA-250930-XKZD',
        'civitas': 'Puna',
        'status': 'Selesai',
        'total': 'Rp 55.000'
      },
      {
        'kode': 'JKA-250930-XKZD',
        'civitas': 'Puna',
        'status': 'Menunggu',
        'total': 'Rp 45.000'
      },
      {
        'kode': 'JKA-250930-XKZD',
        'civitas': 'Alca',
        'status': 'Diproses',
        'total': 'Rp 75.000'
      },
      {
        'kode': 'JKA-250930-XKZD',
        'civitas': 'Ata',
        'status': 'Batal',
        'total': 'Rp 95.000'
      },
      {
        'kode': 'JKA-250930-XKZD',
        'civitas': 'Andra',
        'status': 'Diproses',
        'total': 'Rp 35.000'
      },
    ];
    
    return SafeArea(
      child: SingleChildScrollView(
        padding: const EdgeInsets.symmetric(horizontal: 20, vertical: 18),
        child: Column(
          crossAxisAlignment: CrossAxisAlignment.start,
          children: [
            _buildStatsSection(),
            const SizedBox(height: 24),
            _buildOrdersSection(_orders),
          ],
        ),
      ),
    );
  }

  Widget _buildStatsSection() {
    return Container(
      width: double.infinity,
      decoration: AppTheme.cardDecoration,
      padding: const EdgeInsets.all(18),
      child: Row(
        mainAxisAlignment: MainAxisAlignment.spaceAround,
        children: [
          _buildStatItem('Total Pesanan', '15', Icons.shopping_bag, AppTheme.successColor),
          _buildStatItem('Batal Pesanan', '2', Icons.cancel, AppTheme.errorColor),
          _buildStatItem('Pendapatan', 'Rp 675k', Icons.attach_money, AppTheme.infoColor),
        ],
      ),
    );
  }

  Widget _buildOrdersSection(List<Map<String, String>> orders) {
    return Column(
      crossAxisAlignment: CrossAxisAlignment.start,
      children: [
        Text(
          'Pesanan Terbaru',
          style: AppTheme.headingStyle.copyWith(fontSize: 18),
        ),
        const SizedBox(height: 16),
        _buildHorizontalScrollTable(orders),
      ],
    );
  }

  Widget _buildHorizontalScrollTable(List<Map<String, String>> orders) {
    return Container(
      decoration: AppTheme.cardDecoration,
      child: SingleChildScrollView(
        scrollDirection: Axis.horizontal,
        child: SizedBox(
          width: 510, // Lebar total tabel (sedikit lebih besar dari konten)
          child: Column(
            crossAxisAlignment: CrossAxisAlignment.start,
            children: [
              // Header
              Container(
                width: 510,
                padding: const EdgeInsets.symmetric(vertical: 12, horizontal: 16),
                decoration: BoxDecoration(
                  color: AppTheme.primaryColor.withOpacity(0.1),
                  borderRadius: const BorderRadius.only(
                    topLeft: Radius.circular(12),
                    topRight: Radius.circular(12),
                  ),
                ),
                child: Row(
                  children: [
                    SizedBox(
                      width: 110,
                      child: _TableHeaderText('KODE'),
                    ),
                    SizedBox(
                      width: 130,
                      child: _TableHeaderText('CIVITAS'),
                    ),
                    SizedBox(
                      width: 130,
                      child: _TableHeaderText('STATUS'),
                    ),
                    SizedBox(
                      width: 100,
                      child: _TableHeaderText('TOTAL'),
                    ),
                  ],
                ),
              ),
              // Rows
              ...orders.asMap().entries.map((entry) {
                final index = entry.key;
                final order = entry.value;
                return Container(
                  width: 510, // Pastikan setiap row lebar penuh
                  padding: const EdgeInsets.symmetric(vertical: 10, horizontal: 16),
                  color: index.isEven ? Colors.white : Colors.grey.shade50,
                  child: Row(
                    children: [
                      SizedBox(
                        width: 110,
                        child: _TableRowText(order['kode']!),
                      ),
                      SizedBox(
                        width: 110,
                        child: _TableRowText(order['civitas']!),
                      ),
                      SizedBox(
                        width: 110,
                        child: _StatusBadge(order['status']!),
                      ),
                      SizedBox(
                        width: 100,
                        child: _TotalText(order['total']!),
                      ),
                    ],
                  ),
                );
              }).toList(),
            ],
          ),
        ),
      ),
    );
  }

  Widget _buildStatItem(String title, String value, IconData icon, Color color) {
    return Column(
      children: [
        Container(
          padding: const EdgeInsets.all(12),
          decoration: BoxDecoration(
            color: color.withOpacity(0.1),
            shape: BoxShape.circle,
          ),
          child: Icon(icon, color: color, size: 24),
        ),
        const SizedBox(height: 8),
        Text(
          value,
          style: TextStyle(
            fontSize: 20,
            fontWeight: FontWeight.bold,
            color: color,
          ),
        ),
        Text(
          title,
          style: const TextStyle(
            fontSize: 12,
            color: Colors.grey,
          ),
        ),
      ],
    );
  }
}

class _TableHeaderText extends StatelessWidget {
  final String text;
  const _TableHeaderText(this.text);

  @override
  Widget build(BuildContext context) {
    return Text(
      text,
      style: TextStyle(
        fontSize: 12,
        fontWeight: FontWeight.bold,
        color: AppTheme.primaryColor,
      ),
    );
  }
}

class _TableRowText extends StatelessWidget {
  final String text;
  const _TableRowText(this.text);

  @override
  Widget build(BuildContext context) {
    return Text(
      text,
      style: const TextStyle(
        fontSize: 11,
        color: Colors.grey,
      ),
    );
  }
}

class _StatusBadge extends StatelessWidget {
  final String status;
  const _StatusBadge(this.status);

  @override
  Widget build(BuildContext context) {
    return Container(
      padding: const EdgeInsets.symmetric(horizontal: 8, vertical: 4),
      decoration: BoxDecoration(
        color: _getStatusColor(status),
        borderRadius: BorderRadius.circular(6),
      ),
      child: Text(
        status,
        style: const TextStyle(
          fontSize: 10,
          color: Colors.white,
          fontWeight: FontWeight.w600,
        ),
        textAlign: TextAlign.center,
      ),
    );
  }

  Color _getStatusColor(String status) {
    switch (status) {
      case 'Selesai':
        return AppTheme.successColor;
      case 'Diproses':
        return AppTheme.warningColor;
      case 'Menunggu':
        return AppTheme.infoColor;
      case 'Batal':
        return AppTheme.errorColor;
      default:
        return AppTheme.primaryColor;
    }
  }
}

class _TotalText extends StatelessWidget {
  final String text;
  const _TotalText(this.text);

  @override
  Widget build(BuildContext context) {
    return Text(
      text,
      style: const TextStyle(
        fontSize: 11,
        fontWeight: FontWeight.w600,
        color: AppTheme.primaryColor,
      ),
      textAlign: TextAlign.right,
    );
  }
}

// Placeholder widget for unimplemented pages
class PlaceholderWidget extends StatelessWidget {
  final String title;
  const PlaceholderWidget({super.key, required this.title});

  @override
  Widget build(BuildContext context) {
    return Center(
      child: Text(
        title,
        style: AppTheme.headingStyle,
      ),
    );
  }
}