import 'package:flutter/material.dart';
import '../../theme/app_theme.dart';

class MenuItemCard extends StatelessWidget {
  final Map<String, dynamic> menu;
  final VoidCallback onToggleAvailability;
  final VoidCallback onEdit;
  final VoidCallback onDelete;

  const MenuItemCard({
    super.key,
    required this.menu,
    required this.onToggleAvailability,
    required this.onEdit,
    required this.onDelete,
  });

  @override
  Widget build(BuildContext context) {
    return Container(
      margin: const EdgeInsets.symmetric(horizontal: 16, vertical: 6),
      decoration: BoxDecoration(
        color: Colors.white,
        borderRadius: BorderRadius.circular(12),
        boxShadow: [
          BoxShadow(
            color: Colors.black.withOpacity(0.05),
            blurRadius: 8,
            offset: const Offset(0, 2),
          ),
        ],
        border: Border.all(
          color: Colors.grey.withOpacity(0.2),
          width: 1,
        ),
      ),
      child: Padding(
        padding: const EdgeInsets.all(16),
        child: Row(
          children: [
            // Foto Menu dengan Badge Status
            _buildMenuImage(),
            const SizedBox(width: 12),
            
            // Informasi Menu
            Expanded(
              child: _buildMenuInfo(),
            ),
            
            // Aksi
            _buildActionButtons(),
          ],
        ),
      ),
    );
  }

  Widget _buildMenuImage() {
    return Stack(
      children: [
        Container(
          width: 60,
          height: 60,
          decoration: BoxDecoration(
            color: AppTheme.primaryColor.withOpacity(0.1),
            borderRadius: BorderRadius.circular(10),
            image: menu['foto'] != null
                ? DecorationImage(
                    image: MemoryImage(menu['foto']!),
                    fit: BoxFit.cover,
                  )
                : null,
          ),
          child: menu['foto'] == null
              ? Center(
                  child: Icon(
                    Icons.restaurant_menu,
                    color: AppTheme.primaryColor,
                    size: 24,
                  ),
                )
              : null,
        ),
        // Badge Status
        Positioned(
          top: -4,
          right: -4,
          child: Container(
            padding: const EdgeInsets.symmetric(horizontal: 6, vertical: 2),
            decoration: BoxDecoration(
              color: menu['tersedia'] ? Colors.green : Colors.red,
              borderRadius: BorderRadius.circular(8),
            ),
            child: Text(
              menu['tersedia'] ? '✓' : '✗',
              style: const TextStyle(
                color: Colors.white,
                fontSize: 10,
                fontWeight: FontWeight.bold,
              ),
            ),
          ),
        ),
      ],
    );
  }

  Widget _buildMenuInfo() {
    return Column(
      crossAxisAlignment: CrossAxisAlignment.start,
      children: [
        // Nama Menu
        Text(
          menu['nama'],
          style: const TextStyle(
            fontSize: 16,
            fontWeight: FontWeight.w600,
            color: AppTheme.textColor,
          ),
          maxLines: 1,
          overflow: TextOverflow.ellipsis,
        ),
        
        const SizedBox(height: 4),
        
        // Kategori dan Harga
        Row(
          children: [
            // Kategori
            Container(
              padding: const EdgeInsets.symmetric(horizontal: 8, vertical: 4),
              decoration: BoxDecoration(
                color: AppTheme.primaryColor.withOpacity(0.1),
                borderRadius: BorderRadius.circular(6),
              ),
              child: Text(
                menu['kategori'],
                style: TextStyle(
                  fontSize: 11,
                  color: AppTheme.primaryColor,
                  fontWeight: FontWeight.w500,
                ),
              ),
            ),
            
            const SizedBox(width: 8),
            
            // Harga
            Text(
              'Rp ${_formatCurrency(menu['harga'])}',
              style: const TextStyle(
                fontSize: 14,
                fontWeight: FontWeight.w600,
                color: AppTheme.textColor,
              ),
            ),
          ],
        ),
        
        const SizedBox(height: 6),
        
        // Deskripsi
        if (menu['deskripsi'] != null && menu['deskripsi'].isNotEmpty)
          Text(
            menu['deskripsi'],
            style: TextStyle(
              fontSize: 12,
              color: Colors.grey[600],
              height: 1.3,
            ),
            maxLines: 2,
            overflow: TextOverflow.ellipsis,
          ),
        
        const SizedBox(height: 8),
        
        // Status Toggle
        _buildStatusToggle(),
      ],
    );
  }

  Widget _buildStatusToggle() {
    return GestureDetector(
      onTap: onToggleAvailability,
      child: Container(
        padding: const EdgeInsets.symmetric(horizontal: 12, vertical: 6),
        decoration: BoxDecoration(
          color: menu['tersedia'] 
              ? Colors.green.withOpacity(0.1) 
              : Colors.red.withOpacity(0.1),
          borderRadius: BorderRadius.circular(20),
          border: Border.all(
            color: menu['tersedia'] ? Colors.green : Colors.red,
            width: 1,
          ),
        ),
        child: Row(
          mainAxisSize: MainAxisSize.min,
          children: [
            Icon(
              menu['tersedia'] ? Icons.check_circle : Icons.cancel,
              size: 14,
              color: menu['tersedia'] ? Colors.green : Colors.red,
            ),
            const SizedBox(width: 6),
            Text(
              menu['tersedia'] ? 'Tersedia' : 'Habis',
              style: TextStyle(
                fontSize: 12,
                fontWeight: FontWeight.w500,
                color: menu['tersedia'] ? Colors.green : Colors.red,
              ),
            ),
            const SizedBox(width: 4),
            Icon(
              Icons.swap_horiz,
              size: 14,
              color: menu['tersedia'] ? Colors.green : Colors.red,
            ),
          ],
        ),
      ),
    );
  }

  Widget _buildActionButtons() {
    return Column(
      children: [
        // Edit Button
        Container(
          width: 36,
          height: 36,
          decoration: BoxDecoration(
            color: Colors.blue.withOpacity(0.1),
            borderRadius: BorderRadius.circular(8),
            border: Border.all(color: Colors.blue.withOpacity(0.3)),
          ),
          child: IconButton(
            icon: const Icon(Icons.edit, size: 16),
            color: Colors.blue,
            padding: EdgeInsets.zero,
            onPressed: onEdit,
          ),
        ),
        
        const SizedBox(height: 8),
        
        // Delete Button
        Container(
          width: 36,
          height: 36,
          decoration: BoxDecoration(
            color: Colors.red.withOpacity(0.1),
            borderRadius: BorderRadius.circular(8),
            border: Border.all(color: Colors.red.withOpacity(0.3)),
          ),
          child: IconButton(
            icon: const Icon(Icons.delete_outline, size: 16),
            color: Colors.red,
            padding: EdgeInsets.zero,
            onPressed: onDelete,
          ),
        ),
      ],
    );
  }

  String _formatCurrency(int amount) {
    return amount.toString().replaceAllMapped(
      RegExp(r'(\d{1,3})(?=(\d{3})+(?!\d))'),
      (Match m) => '${m[1]}.',
    );
  }
}