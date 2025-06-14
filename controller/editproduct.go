package controller

import (
	"database/sql"
	"html/template"
	"net/http"
	"strconv"
)

type Product struct {
	ID_Produk  int
	NamaProduk string
	Harga      int
	Kategori   string
	Stok       int
	Deskripsi  string
	Gambar     string
}

func EditProductHandler(db *sql.DB) http.HandlerFunc {
	return func(w http.ResponseWriter, r *http.Request) {
		idStr := r.URL.Query().Get("id")
		if idStr == "" {
			http.Error(w, "Missing product ID", http.StatusBadRequest)
			return
		}

		id, err := strconv.Atoi(idStr)
		if err != nil {
			http.Error(w, "Invalid product ID", http.StatusBadRequest)
			return
		}

		var p Product
		query := `SELECT ID_Produk, nama_produk, harga, kategori, stok, deskripsi, gambar FROM produk WHERE ID_Produk = ?`
		err = db.QueryRow(query, id).Scan(
			&p.ID_Produk,
			&p.NamaProduk,
			&p.Harga,
			&p.Kategori,
			&p.Stok,
			&p.Deskripsi,
			&p.Gambar,
		)
		if err != nil {
			http.Error(w, "Product not found", http.StatusNotFound)
			return
		}

		tmpl, err := template.ParseFiles(
			"views/admin/editproduct.html",
			"parts/admin/navbar.html",
			"parts/admin/sidebar.html",
		)
		if err != nil {
			http.Error(w, err.Error(), http.StatusInternalServerError)
			return
		}

		err = tmpl.ExecuteTemplate(w, "editproduct", map[string]interface{}{
			"Product":     p,
			"CurrentPath": r.URL.Path,
		})
		if err != nil {
			http.Error(w, err.Error(), http.StatusInternalServerError)
		}
	}
}
