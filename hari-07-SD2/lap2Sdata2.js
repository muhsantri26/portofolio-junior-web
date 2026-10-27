import {BinarySearchTree} from './structures.js'

const folder = { 
  nama: 'proyek', 
  anak: [ 
    { nama: 'css', anak: [] }, 
    { nama: 'js', anak: [{ nama: 'app.js', anak: [] }] } 
  ] 
}; 
 
function cetakPohon(node, tingkat = 0) { 
  console.log(' '.repeat(tingkat * 2) + node.nama); 
  for (const anak of node.anak) { 
    cetakPohon(anak, tingkat + 1); 
  } 
} 
 
function hitungNode(node) { 
  let total = 1; 
  for (const anak of node.anak) total += hitungNode(anak); 
  return total; 
} 

// Jalankan cetakPohon dan hitungNode pada struktur folder; tambahkan fungsi cariNode(node, nama) (rekursif) yang mengembalikan jalur lengkap, mis. proyek/js/app.js. 
function cariNode(node, nama){
    if(node.nama === nama){
        return [node.nama]
    }
    for (const anak of node.anak){
        const jalur = cariNode(anak, nama);
        if (jalur){
            return [node.nama].concat(jalur);
        }
    }
    return undefined;
}

cetakPohon(folder);
console.log("total node:", hitungNode(folder));
console.log("jalur ke app.js:", cariNode(folder, "app.js"));

// Masukkan data [50, 30, 70, 20, 40, 60, 80] ke BinarySearchTree; cetak inOrder() dan 
// uji has(60) dan has(65). Gambar pohon hasilnya. 
const bst = new BinarySearchTree();
const data = [50, 30, 70, 20, 40, 60, 80];
data.forEach(num => bst.insert(num));
console.log("In-Order traversal:", bst.inOrder());
console.log("Has 60:", bst.has(60));
console.log("Has 65:", bst.has(65));


// Adjacency list: tiap simpul menyimpan daftar tetangganya 
const graf = { 
  A: ['B', 'C'], 
  B: ['A', 'D'], 
  C: ['A', 'D'], 
  D: ['B', 'C', 'E'], 
  E: ['D'] 
}; 
 
// BFS (melebar) memakai Queue: menemukan jarak terpendek dalam jumlah sisi 
function bfs(graf, mulai) { 
  const dikunjungi = new Set([mulai]); 
  const antrean = [mulai]; 
  const urutan = []; 
 
  while (antrean.length > 0) { 
    const simpul = antrean.shift(); 
    urutan.push(simpul); 
    for (const tetangga of graf[simpul]) { 
      if (!dikunjungi.has(tetangga)) { 
        dikunjungi.add(tetangga); 
        antrean.push(tetangga); 
      } 
    } 
  } 
  return urutan; 
} 
 
// DFS (mendalam) memakai rekursi (Stack pemanggilan) 
function dfs(graf, simpul, dikunjungi = new Set()) { 
  dikunjungi.add(simpul); 
  for (const tetangga of graf[simpul]) { 
    if (!dikunjungi.has(tetangga)) dfs(graf, tetangga, dikunjungi); 
  } 
  return [...dikunjungi]; 
} 
 
console.log(bfs(graf, 'A')); // ['A', 'B', 'C', 'D', 'E'] 
console.log(dfs(graf, 'A')); // ['A', 'B', 'D', 'C', 'E']

// Buat graf jaringan 6 kota (adjacency list). Jalankan bfs dan dfs, lalu buat fungsi 
// jarakTerpendek(graf, asal, tujuan) dengan BFS yang mengembalikan jumlah sisi. 
function jarakTerpendek(graf, asal, tujuan){
    const dikunjungi = new Set([asal]);
    const antrean = [[asal, 0]]; //simpan pasangan [simpul, jarak]
    while (antrean.length > 0){
        const [simpul, jarak] = antrean.shift();
        if (simpul === tujuan) return jarak;
        for (const tetangga of graf[simpul]) {
            if (!dikunjungi.has(tetangga)){
                dikunjungi.add(tetangga);
                antrean.push([tetangga, jarak + 1]);
            }
        }
    }
    return -1;
}

const grafKota = {
    A: ['B', 'C'],
    B: ['A', 'D', 'E'],
    C: ['A', 'F'],
    D: ['B',],
    E: ['B', 'F'],
    F: ['C', 'E']
}

// kembalikan jumlah sisi terpendek dari A ke F (A -> C -> f)
console.log(jarakTerpendek(grafKota, 'A', 'F'));//2
const grafTerpendek = {
    A: ['C'],
    C: ['F'],
    F: ['C']
};
bfs(grafTerpendek, 'A');
