import 'package:flutter/material.dart';

class ProfilePage extends StatelessWidget {
  const ProfilePage({super.key});

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      backgroundColor: const Color(0xFFF8FAFC),
      body: SafeArea(
        child: SingleChildScrollView(
          padding: const EdgeInsets.all(16),
          child: Column(
            children: [
              // Header Profile
              _buildProfileHeader(),
              const SizedBox(height: 24),

              // Menu Settings
              _buildMenuSection(),
              const SizedBox(height: 24),

              // Support Section
              _buildSupportSection(context), // ✅ PASS CONTEXT KE METHOD
            ],
          ),
        ),
      ),
    );
  }

  Widget _buildProfileHeader() {
    return Card(
      elevation: 2,
      shape: RoundedRectangleBorder(borderRadius: BorderRadius.circular(12)),
      child: Padding(
        padding: const EdgeInsets.all(20),
        child: Row(
          children: [
            // Profile Picture
            Container(
              width: 80,
              height: 80,
              decoration: BoxDecoration(
                shape: BoxShape.circle,
                color: const Color(0xFF3C7E01).withOpacity(0.1),
                border: Border.all(
                  color: const Color(0xFF3C7E01),
                  width: 2,
                ),
              ),
              child: const Icon(
                Icons.person,
                size: 40,
                color: Color(0xFF3C7E01),
              ),
            ),
            const SizedBox(width: 16),

            // Profile Info
            Expanded(
              child: Column(
                crossAxisAlignment: CrossAxisAlignment.start,
                children: [
                  const Text(
                    'Ahmad Student',
                    style: TextStyle(
                      fontSize: 20,
                      fontWeight: FontWeight.bold,
                      color: Colors.black87,
                    ),
                  ),
                  const SizedBox(height: 4),
                  const Text(
                    'ahmad@student.com',
                    style: TextStyle(
                      color: Colors.grey,
                      fontSize: 14,
                    ),
                  ),
                  const SizedBox(height: 8),
                  Container(
                    padding: const EdgeInsets.symmetric(
                      horizontal: 12,
                      vertical: 4,
                    ),
                    decoration: BoxDecoration(
                      color: const Color(0xFF3C7E01).withOpacity(0.1),
                      borderRadius: BorderRadius.circular(12),
                    ),
                    child: const Text(
                      'Student Account',
                      style: TextStyle(
                        color: Color(0xFF3C7E01),
                        fontSize: 12,
                        fontWeight: FontWeight.w500,
                      ),
                    ),
                  ),
                ],
              ),
            ),

            // Edit Button
            IconButton(
              onPressed: () {
                // Navigate to edit profile
              },
              icon: const Icon(
                Icons.edit,
                color: Color(0xFF3C7E01),
              ),
            ),
          ],
        ),
      ),
    );
  }

  Widget _buildMenuSection() {
    return Column(
      crossAxisAlignment: CrossAxisAlignment.start,
      children: [
        const Padding(
          padding: EdgeInsets.only(left: 8, bottom: 8),
          child: Text(
            'Akun & Settings',
            style: TextStyle(
              fontSize: 16,
              fontWeight: FontWeight.w600,
              color: Colors.black87,
            ),
          ),
        ),
        Card(
          elevation: 2,
          shape: RoundedRectangleBorder(borderRadius: BorderRadius.circular(12)),
          child: Column(
            children: [
              _buildMenuTile(
                icon: Icons.person_outline,
                title: 'Edit Profil',
                subtitle: 'Ubah data pribadi Anda',
                onTap: () {
                  // Navigate to edit profile
                },
              ),
              _buildDivider(),
              _buildMenuTile(
                icon: Icons.location_on_outlined,
                title: 'Alamat Saya',
                subtitle: 'Kelola alamat pengiriman',
                onTap: () {
                  // Navigate to address management
                },
              ),
              _buildDivider(),
              _buildMenuTile(
                icon: Icons.payment_outlined,
                title: 'Metode Pembayaran',
                subtitle: 'Kartu & dompet digital',
                onTap: () {
                  // Navigate to payment methods
                },
              ),
              _buildDivider(),
              _buildMenuTile(
                icon: Icons.notifications_outlined,
                title: 'Notifikasi',
                subtitle: 'Pengaturan notifikasi',
                onTap: () {
                  // Navigate to notification settings
                },
              ),
              _buildDivider(),
              _buildMenuTile(
                icon: Icons.security_outlined,
                title: 'Privasi & Keamanan',
                subtitle: 'Keamanan akun Anda',
                onTap: () {
                  // Navigate to privacy settings
                },
              ),
            ],
          ),
        ),
      ],
    );
  }

  // ✅ PERBAIKAN: TAMBAHKAN PARAMETER CONTEXT
  Widget _buildSupportSection(BuildContext context) {
    return Column(
      crossAxisAlignment: CrossAxisAlignment.start,
      children: [
        const Padding(
          padding: EdgeInsets.only(left: 8, bottom: 8),
          child: Text(
            'Bantuan & Dukungan',
            style: TextStyle(
              fontSize: 16,
              fontWeight: FontWeight.w600,
              color: Colors.black87,
            ),
          ),
        ),
        Card(
          elevation: 2,
          shape: RoundedRectangleBorder(borderRadius: BorderRadius.circular(12)),
          child: Column(
            children: [
              _buildMenuTile(
                icon: Icons.history_outlined,
                title: 'Riwayat Pesanan',
                subtitle: 'Lihat semua pesanan Anda',
                onTap: () {
                  // Navigate to order history
                },
              ),
              _buildDivider(),
              _buildMenuTile(
                icon: Icons.help_outline,
                title: 'Pusat Bantuan',
                subtitle: 'Pertanyaan umum & solusi',
                onTap: () {
                  // Navigate to help center
                },
              ),
              _buildDivider(),
              _buildMenuTile(
                icon: Icons.support_agent_outlined,
                title: 'Hubungi Kami',
                subtitle: 'Customer service 24/7',
                onTap: () {
                  // Navigate to contact us
                },
              ),
              _buildDivider(),
              _buildMenuTile(
                icon: Icons.info_outline,
                title: 'Tentang Aplikasi',
                subtitle: 'Versi 1.0.0',
                onTap: () {
                  // Navigate to about app
                },
              ),
            ],
          ),
        ),
        const SizedBox(height: 24),

        // Logout Button
        SizedBox(
          width: double.infinity,
          child: ElevatedButton(
            onPressed: () {
              _showLogoutConfirmation(context); // ✅ SEKSUDAH BISA DIPANGGIL
            },
            style: ElevatedButton.styleFrom(
              backgroundColor: Colors.red,
              foregroundColor: Colors.white,
              padding: const EdgeInsets.symmetric(vertical: 16),
              shape: RoundedRectangleBorder(
                borderRadius: BorderRadius.circular(12),
              ),
              elevation: 0,
            ),
            child: const Row(
              mainAxisAlignment: MainAxisAlignment.center,
              children: [
                Icon(Icons.logout, size: 20),
                SizedBox(width: 8),
                Text(
                  'Keluar',
                  style: TextStyle(
                    fontSize: 16,
                    fontWeight: FontWeight.w600,
                  ),
                ),
              ],
            ),
          ),
        ),
      ],
    );
  }

  Widget _buildMenuTile({
    required IconData icon,
    required String title,
    required String subtitle,
    required VoidCallback onTap,
  }) {
    return ListTile(
      leading: Container(
        width: 40,
        height: 40,
        decoration: BoxDecoration(
          color: const Color(0xFF3C7E01).withOpacity(0.1),
          shape: BoxShape.circle,
        ),
        child: Icon(
          icon,
          color: const Color(0xFF3C7E01),
          size: 20,
        ),
      ),
      title: Text(
        title,
        style: const TextStyle(
          fontWeight: FontWeight.w500,
          fontSize: 16,
        ),
      ),
      subtitle: Text(
        subtitle,
        style: const TextStyle(
          color: Colors.grey,
          fontSize: 12,
        ),
      ),
      trailing: const Icon(
        Icons.arrow_forward_ios,
        size: 16,
        color: Colors.grey,
      ),
      onTap: onTap,
    );
  }

  Widget _buildDivider() {
    return Padding(
      padding: const EdgeInsets.only(left: 72, right: 16),
      child: Divider(
        height: 1,
        color: Colors.grey[300],
      ),
    );
  }

  // ✅ METHOD INI SEKARANG BISA DIAKSES
  void _showLogoutConfirmation(BuildContext context) {
    showDialog(
      context: context,
      builder: (BuildContext context) {
        return AlertDialog(
          title: const Text(
            'Keluar Akun',
            style: TextStyle(
              fontWeight: FontWeight.bold,
            ),
          ),
          content: const Text(
            'Apakah Anda yakin ingin keluar dari akun?',
            style: TextStyle(
              color: Colors.grey,
            ),
          ),
          actions: [
            TextButton(
              onPressed: () {
                Navigator.of(context).pop();
              },
              child: const Text(
                'Batal',
                style: TextStyle(
                  color: Colors.grey,
                ),
              ),
            ),
            ElevatedButton(
              onPressed: () {
                Navigator.of(context).pop();
                Navigator.pushReplacementNamed(context, '/login');
              },
              style: ElevatedButton.styleFrom(
                backgroundColor: Colors.red,
                foregroundColor: Colors.white,
              ),
              child: const Text('Keluar'),
            ),
          ],
        );
      },
    );
  }
}