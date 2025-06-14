package controller

import (
	"database/sql"
	"html/template"
	"net/http"
)

type Produk struct {
	IDProduk   int
	NamaProduk string
	Harga      int
	Kategori   string
	Stok       int
	Deskripsi  string
	Gambar     string
}

func ProductHandler(db *sql.DB) func(http.ResponseWriter, *http.Request) {
	return func(w http.ResponseWriter, r *http.Request) {
		tmpl, err := template.ParseFiles(
			"views/admin/product.html",
			"parts/admin/navbar.html",
			"parts/admin/sidebar.html",
		)
		if err != nil {
			http.Error(w, err.Error(), http.StatusInternalServerError)
			return
		}

		// Query produk dari database
		rows, err := db.Query("SELECT ID_Produk, nama_produk, harga, kategori, stok, deskripsi, gambar FROM produk")
		if err != nil {
			http.Error(w, err.Error(), http.StatusInternalServerError)
			return
		}
		defer rows.Close()

		var products []Produk
		for rows.Next() {
			var p Produk
			err := rows.Scan(&p.IDProduk, &p.NamaProduk, &p.Harga, &p.Kategori, &p.Stok, &p.Deskripsi, &p.Gambar)
			if err != nil {
				http.Error(w, err.Error(), http.StatusInternalServerError)
				return
			}
			products = append(products, p)
		}

		err = tmpl.ExecuteTemplate(w, "product", map[string]interface{}{
			"CurrentPath": r.URL.Path,
			"Products":    products, // <-- PENTING
		})
		if err != nil {
			http.Error(w, err.Error(), http.StatusInternalServerError)
			return
		}
	}
}
