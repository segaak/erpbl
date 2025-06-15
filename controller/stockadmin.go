package controller

import (
	"database/sql"
	"html/template"
	"net/http"
)

type StokProduk struct {
	IDProduk   int
	NamaProduk string
	Harga      int
	Kategori   string
	Stok       int
	Deskripsi  string
	Gambar     string
}

// StockAdminHandler handles the stock management page
func StockHandler(db *sql.DB) http.HandlerFunc {
	return func(w http.ResponseWriter, r *http.Request) {
		tmpl, err := template.ParseFiles(
			"views/admin/stock.html",
			"parts/admin/navbar.html",
			"parts/admin/sidebar.html",
		)
		if err != nil {
			http.Error(w, err.Error(), http.StatusInternalServerError)
			return
		}
		rows, err := db.Query("SELECT ID_Produk, nama_produk, harga, kategori, stok, deskripsi, gambar FROM produk")
		if err != nil {
			http.Error(w, err.Error(), http.StatusInternalServerError)
			return
		}
		defer rows.Close()
		var StockProduct []StokProduk
		for rows.Next() {
			var p StokProduk
			err := rows.Scan(&p.IDProduk, &p.NamaProduk, &p.Harga, &p.Kategori, &p.Stok, &p.Deskripsi, &p.Gambar)
			if err != nil {
				http.Error(w, err.Error(), http.StatusInternalServerError)
				return
			}
			StockProduct = append(StockProduct, p)
		}
		err = tmpl.ExecuteTemplate(w, "stock", map[string]interface{}{
			"CurrentPath": r.URL.Path,
			"stock":       StockProduct, // <-- PENTING
		})

	}
}
