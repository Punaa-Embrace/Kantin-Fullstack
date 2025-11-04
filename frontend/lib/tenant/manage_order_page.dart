import 'package:flutter/material.dart';
import '../theme/app_theme.dart';

class ManajemenPesananPage extends StatefulWidget {
  const ManajemenPesananPage({super.key});

  @override
  State<ManajemenPesananPage> createState() => _ManajemenPesananPageState();
}

class _ManajemenPesananPageState extends State<ManajemenPesananPage> {
  final List<Map<String, dynamic>> _pesananList = [
    {
      'kode': 'JKA-250930-XKZD',
      'civitas': 'Puna',
      'total': 125000,
      'status': 'Pending Approval',
      'pembayaran': 'Paid',
      'tanggal': '30 Sep 2025, 17:24',
      'items': [
        {'nama': 'BAKSO', 'qty': 5, 'harga': 25000, 'catatan': 'saya mau pedas'}
      ],
      'metode_bayar': 'QRIS'
    },
    {
      'kode': 'JKA-250930-79BO',
      'civitas': 'Puna',
      'total': 25000,
      'status': 'Approved',
      'pembayaran': 'Paid',
      'tanggal': '30 Sep 2025, 16:30',
      'items': [
        {'nama': 'ES TEH', 'qty': 1, 'harga': 25000, 'catatan': ''}
      ],
      'metode_bayar': 'QRIS'
    },
    {
      'kode': 'JKA-250929-GFIN',
      'civitas': 'Puna',
      'total': 25000,
      'status': 'Rejected',
      'pembayaran': 'Paid',
      'tanggal': '29 Sep 2025, 15:45',
      'items': [
        {'nama': 'NASI GORENG', 'qty': 1, 'harga': 25000, 'catatan': 'tidak pakai kecap'}
      ],
      'metode_bayar': 'QRIS'
    },
  ];

  final TextEditingController _searchController = TextEditingController();

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      backgroundColor: AppTheme.backgroundColor,
      appBar: AppBar(
        title: const Text(
          'Manajemen Pesanan',
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
          // Search Bar
          Container(
            padding: const EdgeInsets.all(16),
            color: Colors.white,
            child: TextField(
              controller: _searchController,
              decoration: InputDecoration(
                hintText: 'Search',
                prefixIcon: const Icon(Icons.search, color: Colors.grey),
                filled: true,
                fillColor: Colors.grey[50],
                border: OutlineInputBorder(
                  borderRadius: BorderRadius.circular(8),
                  borderSide: BorderSide.none,
                ),
                contentPadding: const EdgeInsets.symmetric(horizontal: 16),
              ),
              onChanged: (value) {
                setState(() {});
              },
            ),
          ),

          // Header Table
          Container(
            padding: const EdgeInsets.symmetric(horizontal: 16, vertical: 12),
            decoration: const BoxDecoration(
              color: Colors.white,
              border: Border(bottom: BorderSide(color: Colors.grey, width: 0.5)),
            ),
            child: const Row(
              children: [
                Expanded(
                  flex: 2,
                  child: Text(
                    'KODE',
                    style: TextStyle(
                      fontWeight: FontWeight.w600,
                      fontSize: 12,
                      color: Colors.grey,
                    ),
                  ),
                ),
                Expanded(
                  flex: 2,
                  child: Text(
                    'CIVITAS',
                    style: TextStyle(
                      fontWeight: FontWeight.w600,
                      fontSize: 12,
                      color: Colors.grey,
                    ),
                  ),
                ),
                Expanded(
                  flex: 2,
                  child: Text(
                    'TOTAL',
                    style: TextStyle(
                      fontWeight: FontWeight.w600,
                      fontSize: 12,
                      color: Colors.grey,
                    ),
                  ),
                ),
                Expanded(
                  flex: 2,
                  child: Text(
                    'PEMBAYARAN',
                    style: TextStyle(
                      fontWeight: FontWeight.w600,
                      fontSize: 12,
                      color: Colors.grey,
                    ),
                  ),
                ),
                Expanded(
                  flex: 2,
                  child: Text(
                    'STATUS',
                    style: TextStyle(
                      fontWeight: FontWeight.w600,
                      fontSize: 12,
                      color: Colors.grey,
                    ),
                  ),
                ),
                Expanded(
                  flex: 1,
                  child: Text(
                    'AKSI',
                    style: TextStyle(
                      fontWeight: FontWeight.w600,
                      fontSize: 12,
                      color: Colors.grey,
                    ),
                  ),
                ),
              ],
            ),
          ),

          // List Pesanan
          Expanded(
            child: ListView.builder(
              itemCount: _pesananList.length,
              itemBuilder: (context, index) {
                final pesanan = _pesananList[index];
                return _buildPesananItem(pesanan);
              },
            ),
          ),
        ],
      ),
    );
  }

  Widget _buildPesananItem(Map<String, dynamic> pesanan) {
    Color statusColor = Colors.orange;
    if (pesanan['status'] == 'Approved') {
      statusColor = Colors.green;
    } else if (pesanan['status'] == 'Rejected') {
      statusColor = Colors.red;
    }

    return Container(
      padding: const EdgeInsets.symmetric(horizontal: 16, vertical: 12),
      decoration: const BoxDecoration(
        color: Colors.white,
        border: Border(bottom: BorderSide(color: Colors.grey, width: 0.3)),
      ),
      child: Row(
        children: [
          Expanded(
            flex: 2,
            child: Text(
              pesanan['kode'],
              style: const TextStyle(fontSize: 12),
            ),
          ),
          Expanded(
            flex: 2,
            child: Text(
              pesanan['civitas'],
              style: const TextStyle(fontSize: 12),
            ),
          ),
          Expanded(
            flex: 2,
            child: Text(
              'Rp ${pesanan['total'].toString()}',
              style: const TextStyle(fontSize: 12),
            ),
          ),
          Expanded(
            flex: 2,
            child: Container(
              padding: const EdgeInsets.symmetric(horizontal: 8, vertical: 4),
              decoration: BoxDecoration(
                color: pesanan['pembayaran'] == 'Paid' ? Colors.green[50] : Colors.orange[50],
                borderRadius: BorderRadius.circular(4),
              ),
              child: Text(
                pesanan['pembayaran'],
                style: TextStyle(
                  fontSize: 10,
                  color: pesanan['pembayaran'] == 'Paid' ? Colors.green : Colors.orange,
                  fontWeight: FontWeight.w500,
                ),
                textAlign: TextAlign.center,
              ),
            ),
          ),
          Expanded(
            flex: 2,
            child: Container(
              padding: const EdgeInsets.symmetric(horizontal: 8, vertical: 4),
              decoration: BoxDecoration(
                color: statusColor.withOpacity(0.1),
                borderRadius: BorderRadius.circular(4),
              ),
              child: Text(
                pesanan['status'],
                style: TextStyle(
                  fontSize: 10,
                  color: statusColor,
                  fontWeight: FontWeight.w500,
                ),
                textAlign: TextAlign.center,
              ),
            ),
          ),
          Expanded(
            flex: 1,
            child: IconButton(
              icon: const Icon(Icons.visibility, size: 18),
              onPressed: () {
                _showDetailPesanan(pesanan);
              },
            ),
          ),
        ],
      ),
    );
  }

  void _showDetailPesanan(Map<String, dynamic> pesanan) {
    showModalBottomSheet(
      context: context,
      isScrollControlled: true,
      backgroundColor: Colors.transparent,
      builder: (context) => DetailPesananBottomSheet(
        pesanan: pesanan,
        onStatusChanged: (newStatus) {
          setState(() {
            pesanan['status'] = newStatus;
          });
        },
      ),
    );
  }
}

class DetailPesananBottomSheet extends StatefulWidget {
  final Map<String, dynamic> pesanan;
  final Function(String) onStatusChanged;

  const DetailPesananBottomSheet({
    super.key,
    required this.pesanan,
    required this.onStatusChanged,
  });

  @override
  State<DetailPesananBottomSheet> createState() => _DetailPesananBottomSheetState();
}

class _DetailPesananBottomSheetState extends State<DetailPesananBottomSheet> {
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
                  'Manajemen Pesanan',
                  style: TextStyle(
                    fontSize: 16,
                    fontWeight: FontWeight.w600,
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
                  // Header Pesanan
                  Center(
                    child: Text(
                      'Pesanan #${widget.pesanan['kode']}',
                      style: const TextStyle(
                        fontSize: 18,
                        fontWeight: FontWeight.w600,
                      ),
                    ),
                  ),
                  const SizedBox(height: 16),

                  // Info Pengirim
                  _buildInfoRow('Dari:', widget.pesanan['civitas']),
                  _buildInfoRow('Tanggal:', widget.pesanan['tanggal']),
                  const SizedBox(height: 16),

                  // Action Buttons (hanya untuk pending)
                  if (widget.pesanan['status'] == 'Pending Approval') ...[
                    Row(
                      children: [
                        Expanded(
                          child: OutlinedButton(
                            onPressed: () {
                              widget.onStatusChanged('Rejected');
                              Navigator.pop(context);
                            },
                            style: OutlinedButton.styleFrom(
                              side: const BorderSide(color: Colors.red),
                              padding: const EdgeInsets.symmetric(vertical: 12),
                            ),
                            child: const Text(
                              'Tolak',
                              style: TextStyle(color: Colors.red),
                            ),
                          ),
                        ),
                        const SizedBox(width: 12),
                        Expanded(
                          child: ElevatedButton(
                            onPressed: () {
                              widget.onStatusChanged('Approved');
                              Navigator.pop(context);
                            },
                            style: ElevatedButton.styleFrom(
                              backgroundColor: const Color.fromARGB(255, 86, 235, 37),
                              padding: const EdgeInsets.symmetric(vertical: 12),
                            ),
                            child: const Text(
                              'Terima',
                              style: TextStyle(color: Colors.white),
                            ),
                          ),
                        ),
                      ],
                    ),
                    const SizedBox(height: 16),
                  ],

                  // Rincian Item
                  const Text(
                    'Rincian Item',
                    style: TextStyle(
                      fontSize: 16,
                      fontWeight: FontWeight.w600,
                    ),
                  ),
                  const SizedBox(height: 8),

                  ...widget.pesanan['items'].map<Widget>((item) {
                    return Container(
                      margin: const EdgeInsets.only(bottom: 8),
                      padding: const EdgeInsets.all(12),
                      decoration: BoxDecoration(
                        border: Border.all(color: Colors.grey[300]!),
                        borderRadius: BorderRadius.circular(8),
                      ),
                      child: Column(
                        crossAxisAlignment: CrossAxisAlignment.start,
                        children: [
                          Row(
                            mainAxisAlignment: MainAxisAlignment.spaceBetween,
                            children: [
                              Text(
                                item['nama'],
                                style: const TextStyle(fontWeight: FontWeight.w600),
                              ),
                              Text(
                                'Rp ${(item['qty'] * item['harga']).toString()}',
                                style: const TextStyle(fontWeight: FontWeight.w600),
                              ),
                            ],
                          ),
                          Text('${item['qty']} x Rp ${item['harga'].toString()}'),
                          if (item['catatan'].isNotEmpty) ...[
                            const SizedBox(height: 4),
                            Text(
                              'Catatan: ${item['catatan']}',
                              style: TextStyle(
                                fontSize: 12,
                                color: Colors.grey[600],
                                fontStyle: FontStyle.italic,
                              ),
                            ),
                          ],
                        ],
                      ),
                    );
                  }).toList(),

                  const SizedBox(height: 16),

                  // Total Pesanan
                  Container(
                    padding: const EdgeInsets.all(12),
                    decoration: BoxDecoration(
                      border: Border.all(color: Colors.grey[300]!),
                      borderRadius: BorderRadius.circular(8),
                    ),
                    child: Row(
                      mainAxisAlignment: MainAxisAlignment.spaceBetween,
                      children: [
                        const Text(
                          'Total Pesanan',
                          style: TextStyle(
                            fontSize: 16,
                            fontWeight: FontWeight.w600,
                          ),
                        ),
                        Text(
                          'Rp ${widget.pesanan['total'].toString()}',
                          style: const TextStyle(
                            fontSize: 16,
                            fontWeight: FontWeight.w600,
                          ),
                        ),
                      ],
                    ),
                  ),

                  const SizedBox(height: 24),

                  // Detail Status & Pembayaran
                  const Text(
                    'Detail Status & Pembayaran',
                    style: TextStyle(
                      fontSize: 16,
                      fontWeight: FontWeight.w600,
                    ),
                  ),
                  const SizedBox(height: 12),

                  _buildDetailRow('Status Pesanan:', widget.pesanan['status']),
                  _buildDetailRow('Metode Bayar:', widget.pesanan['metode_bayar']),
                  _buildDetailRow('Status Bayar:', widget.pesanan['pembayaran']),

                  // Bukti Pembayaran
                  const SizedBox(height: 8),
                  const Text(
                    'Bukti Pembayaran:',
                    style: TextStyle(fontWeight: FontWeight.w500),
                  ),
                  const SizedBox(height: 4),
                  Container(
                    width: double.infinity,
                    padding: const EdgeInsets.all(12),
                    decoration: BoxDecoration(
                      border: Border.all(color: Colors.grey[300]!),
                      borderRadius: BorderRadius.circular(8),
                    ),
                    child: const Row(
                      children: [
                        Icon(Icons.receipt, color: Colors.green),
                        SizedBox(width: 8),
                        Text('Bukti Pembayaran'),
                        Spacer(),
                        Icon(Icons.visibility, color: Colors.blue),
                      ],
                    ),
                  ),

                  const SizedBox(height: 24),

                  // Button Kembali
                  Container(
                    width: double.infinity,
                    decoration: BoxDecoration(
                      border: Border.all(color: const Color.fromARGB(255, 86, 235, 37)),
                      borderRadius: BorderRadius.circular(8),
                    ),
                    child: TextButton(
                      onPressed: () => Navigator.pop(context),
                      child: const Row(
                        mainAxisAlignment: MainAxisAlignment.center,
                        children: [
                          Icon(Icons.check, color: Color.fromARGB(255, 86, 235, 37)),
                          SizedBox(width: 8),
                          Text(
                            'Kembali ke Daftar Pesanan',
                            style: TextStyle(color: Color.fromARGB(255, 86, 235, 37)),
                          ),
                        ],
                      ),
                    ),
                  ),
                ],
              ),
            ),
          ),
        ],
      ),
    );
  }

  Widget _buildInfoRow(String label, String value) {
    return Padding(
      padding: const EdgeInsets.symmetric(vertical: 4),
      child: Row(
        children: [
          SizedBox(
            width: 80,
            child: Text(
              label,
              style: const TextStyle(fontWeight: FontWeight.w500),
            ),
          ),
          Text(value),
        ],
      ),
    );
  }

  Widget _buildDetailRow(String label, String value) {
    return Padding(
      padding: const EdgeInsets.symmetric(vertical: 6),
      child: Row(
        children: [
          SizedBox(
            width: 120,
            child: Text(
              label,
              style: const TextStyle(fontWeight: FontWeight.w500),
            ),
          ),
          Container(
            padding: const EdgeInsets.symmetric(horizontal: 8, vertical: 4),
            decoration: BoxDecoration(
              color: _getStatusColor(value).withOpacity(0.1),
              borderRadius: BorderRadius.circular(4),
            ),
            child: Text(
              value,
              style: TextStyle(
                color: _getStatusColor(value),
                fontWeight: FontWeight.w500,
                fontSize: 12,
              ),
            ),
          ),
        ],
      ),
    );
  }

  Color _getStatusColor(String status) {
    switch (status) {
      case 'Pending Approval':
        return Colors.orange;
      case 'Approved':
        return Colors.green;
      case 'Rejected':
        return Colors.red;
      case 'Paid':
        return Colors.green;
      default:
        return Colors.grey;
    }
  }
}