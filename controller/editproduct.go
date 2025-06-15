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
		var idStr string
		if r.Method == http.MethodPost {
			idStr = r.FormValue("id") // ambil dari form POST
		} else {
			idStr = r.URL.Query().Get("id") // ambil dari query GET
		}

		id, err := strconv.Atoi(idStr)
		if err != nil {
			http.Error(w, "Invalid product ID", http.StatusBadRequest)
			return
		}

		if r.Method == http.MethodPost {
			// Handle form submission (update product)
			nama := r.FormValue("nama_produk")
			harga, _ := strconv.Atoi(r.FormValue("harga"))
			kategori := r.FormValue("kategori")
			stok, _ := strconv.Atoi(r.FormValue("stok"))
			deskripsi := r.FormValue("deskripsi")

			// TODO: handle upload file gambar kalau perlu

			_, err := db.Exec(`
				UPDATE produk SET nama_produk=?, harga=?, kategori=?, stok=?, deskripsi=? WHERE ID_Produk=?
			`, nama, harga, kategori, stok, deskripsi, id)
			if err != nil {
				http.Error(w, "Failed to update product", http.StatusInternalServerError)
				return
			}

			// Redirect biar gak looping
			http.Redirect(w, r, "/admin/stock", http.StatusSeeOther)
			return
		}

		// GET method: fetch product data dan tampilkan form
		var p Product
		query := `SELECT ID_Produk, nama_produk, harga, kategori, stok, deskripsi, gambar FROM produk WHERE ID_Produk = ?`
		err = db.QueryRow(query, id).Scan(&p.ID_Produk, &p.NamaProduk, &p.Harga, &p.Kategori, &p.Stok, &p.Deskripsi, &p.Gambar)
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
