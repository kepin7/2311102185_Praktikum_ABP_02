const express = require('express');
const bodyParser = require('body-parser');
const cors = require('cors');
const fs = require('fs');
const path = require('path');
const { v4: uuidv4 } = require('uuid');

const app = express();
const PORT = 3000;
const DATA_FILE = path.join(__dirname, 'data', 'mahasiswa.json');

app.use(cors());
app.use(bodyParser.json());
app.use(bodyParser.urlencoded({ extended: true }));
app.use(express.static(path.join(__dirname, 'public')));

// Helper: read data
function readData() {
  const raw = fs.readFileSync(DATA_FILE, 'utf-8');
  return JSON.parse(raw);
}

// Helper: write data
function writeData(data) {
  fs.writeFileSync(DATA_FILE, JSON.stringify(data, null, 2));
}

// Serve pages
app.get('/', (req, res) => {
  res.sendFile(path.join(__dirname, 'public', 'index.html'));
});
app.get('/data', (req, res) => {
  res.sendFile(path.join(__dirname, 'public', 'data.html'));
});
app.get('/dashboard', (req, res) => {
  res.sendFile(path.join(__dirname, 'public', 'dashboard.html'));
});

// API: GET all
app.get('/api/mahasiswa', (req, res) => {
  const data = readData();
  res.json({ success: true, data });
});

// API: GET one
app.get('/api/mahasiswa/:id', (req, res) => {
  const data = readData();
  const item = data.find(m => m.id === req.params.id);
  if (!item) return res.status(404).json({ success: false, message: 'Data tidak ditemukan' });
  res.json({ success: true, data: item });
});

// API: POST create
app.post('/api/mahasiswa', (req, res) => {
  const data = readData();
  const { nim, nama, prodi, angkatan, ipk, status, email, no_hp } = req.body;

  // Validasi NIM unik
  if (data.find(m => m.nim === nim)) {
    return res.status(400).json({ success: false, message: 'NIM sudah terdaftar' });
  }

  const newItem = {
    id: uuidv4().substring(0, 8),
    nim, nama, prodi,
    angkatan: parseInt(angkatan),
    ipk: parseFloat(ipk),
    status, email, no_hp
  };

  data.push(newItem);
  writeData(data);
  res.json({ success: true, message: 'Data berhasil ditambahkan', data: newItem });
});

// API: PUT update
app.put('/api/mahasiswa/:id', (req, res) => {
  const data = readData();
  const idx = data.findIndex(m => m.id === req.params.id);
  if (idx === -1) return res.status(404).json({ success: false, message: 'Data tidak ditemukan' });

  const { nim, nama, prodi, angkatan, ipk, status, email, no_hp } = req.body;

  // Validasi NIM unik (kecuali diri sendiri)
  const nimConflict = data.find(m => m.nim === nim && m.id !== req.params.id);
  if (nimConflict) {
    return res.status(400).json({ success: false, message: 'NIM sudah digunakan mahasiswa lain' });
  }

  data[idx] = { ...data[idx], nim, nama, prodi, angkatan: parseInt(angkatan), ipk: parseFloat(ipk), status, email, no_hp };
  writeData(data);
  res.json({ success: true, message: 'Data berhasil diperbarui', data: data[idx] });
});

// API: DELETE
app.delete('/api/mahasiswa/:id', (req, res) => {
  const data = readData();
  const idx = data.findIndex(m => m.id === req.params.id);
  if (idx === -1) return res.status(404).json({ success: false, message: 'Data tidak ditemukan' });

  data.splice(idx, 1);
  writeData(data);
  res.json({ success: true, message: 'Data berhasil dihapus' });
});

// API: Stats for dashboard
app.get('/api/stats', (req, res) => {
  const data = readData();
  const stats = {
    total: data.length,
    aktif: data.filter(m => m.status === 'Aktif').length,
    cuti: data.filter(m => m.status === 'Cuti').length,
    lulus: data.filter(m => m.status === 'Lulus').length,
    avgIpk: data.length ? (data.reduce((s, m) => s + m.ipk, 0) / data.length).toFixed(2) : 0,
    byProdi: {},
    byAngkatan: {}
  };

  data.forEach(m => {
    stats.byProdi[m.prodi] = (stats.byProdi[m.prodi] || 0) + 1;
    stats.byAngkatan[m.angkatan] = (stats.byAngkatan[m.angkatan] || 0) + 1;
  });

  res.json({ success: true, data: stats });
});

app.listen(PORT, () => {
  console.log(`Server berjalan di http://localhost:${PORT}`);
});
