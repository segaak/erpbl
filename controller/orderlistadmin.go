package controller

import (
	"database/sql"
	"html/template"
	"net/http"
)

type Order struct {
	ID      int
	Nama    string
	Alamat  string
	Tanggal string
	Kontak  string
	Status  string
	Produk  []ProdukOrder
}

type ProdukOrder struct {
	NamaProduk string
	Jumlah     int
	Harga      int
	Subtotal   int
}

func OrderHandler(db *sql.DB) http.HandlerFunc {
	return func(w http.ResponseWriter, r *http.Request) {
		if r.Method != http.MethodGet {
			http.Error(w, "Method not allowed", http.StatusMethodNotAllowed)
			return
		}

		rows, err := db.Query(`
			SELECT 
				u.id, u.nama, u.alamat, pm.tanggal, u.no_hp, ps.status,
				pr.nama_produk, ps.jumlah, ps.harga_satuan, ps.subtotal
			FROM users u
			JOIN pembayaran pm ON u.id = pm.id
			JOIN pesanan ps ON pm.id = ps.id_pembayaran
			JOIN produk pr ON ps.ID_produk = pr.ID_Produk
			ORDER BY u.id;
		`)
		if err != nil {
			http.Error(w, err.Error(), http.StatusInternalServerError)
			return
		}
		defer rows.Close()

		orderMap := make(map[int]*Order)

		for rows.Next() {
			var (
				id                                                int
				nama, alamat, tanggal, kontak, status, namaProduk string
				jumlah, harga, subtotal                           int
			)
			err := rows.Scan(&id, &nama, &alamat, &tanggal, &kontak, &status, &namaProduk, &jumlah, &harga, &subtotal)
			if err != nil {
				http.Error(w, err.Error(), http.StatusInternalServerError)
				return
			}

			if orderMap[id] == nil {
				orderMap[id] = &Order{
					ID:      id,
					Nama:    nama,
					Alamat:  alamat,
					Tanggal: tanggal,
					Kontak:  kontak,
					Status:  status,
					Produk:  []ProdukOrder{},
				}
			}

			orderMap[id].Produk = append(orderMap[id].Produk, ProdukOrder{
				NamaProduk: namaProduk,
				Jumlah:     jumlah,
				Harga:      harga,
				Subtotal:   subtotal,
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
	}
}
