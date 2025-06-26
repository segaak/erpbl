package controller

import (
	"database/sql"
	"html/template"
	"log"
	"net/http"
)

type Order struct {
	IDPembayaran int
	Nama         string
	Alamat       string
	Tanggal      string
	Kontak       string
	Status       string
	Produk       []ProdukOrder
}

type ProdukOrder struct {
	ID         int
	NamaProduk string
	Jumlah     int
	Harga      int
	Subtotal   int
	Status     string
}

func OrderHandler(db *sql.DB) http.HandlerFunc {
	return func(w http.ResponseWriter, r *http.Request) {
		if r.Method != http.MethodGet {
			http.Error(w, "Method not allowed", http.StatusMethodNotAllowed)
			return
		}

		// Ambil semua data pesanan bergabung dengan data pembayaran dan produk
		rows, err := db.Query(`
			SELECT 
	pm.id, u.nama, u.alamat, pm.tanggal, u.no_hp, ps.status, ps.id,
	pr.nama_produk, ps.jumlah, ps.harga_satuan, ps.subtotal
FROM pembayaran pm
JOIN users u ON u.id = pm.user_id
JOIN pesanan ps ON pm.id = ps.id_pembayaran
JOIN produk pr ON ps.ID_produk = pr.ID_Produk
ORDER BY pm.id;

		`)
		if err != nil {
			http.Error(w, err.Error(), http.StatusInternalServerError)
			return
		}
		defer rows.Close()

		orderMap := make(map[int]*Order)

		for rows.Next() {
			var (
				idPembayaran                                      int
				nama, alamat, tanggal, kontak, status, namaProduk string
				jumlah, harga, subtotal, idPesanan                int
			)
			err := rows.Scan(&idPembayaran, &nama, &alamat, &tanggal, &kontak, &status, &idPesanan, &namaProduk, &jumlah, &harga, &subtotal)
			if err != nil {
				http.Error(w, err.Error(), http.StatusInternalServerError)
				return
			}

			if orderMap[idPembayaran] == nil {
				orderMap[idPembayaran] = &Order{
					IDPembayaran: idPembayaran,
					Nama:         nama,
					Alamat:       alamat,
					Tanggal:      tanggal,
					Kontak:       kontak,
					Status:       status,
					Produk:       []ProdukOrder{},
				}
			}

			orderMap[idPembayaran].Produk = append(orderMap[idPembayaran].Produk, ProdukOrder{
				ID:         idPesanan,
				NamaProduk: namaProduk,
				Jumlah:     jumlah,
				Harga:      harga,
				Subtotal:   subtotal,
				Status:     status,
			})
		}

		var orders []Order
		for _, order := range orderMap {
			orders = append(orders, *order)
		}

		tmpl, err := template.ParseFiles(
			"views/admin/orderlist.html",
			"parts/admin/navbar.html",
			"parts/admin/sidebar.html",
		)
		if err != nil {
			http.Error(w, err.Error(), http.StatusInternalServerError)
			return
		}

		err = tmpl.ExecuteTemplate(w, "order", map[string]interface{}{
			"CurrentPath": r.URL.Path,
			"Orders":      orders,
		})
		if err != nil {
			log.Println("Template execution error:", err)
		}
	}
}
