package controller

import (
	"database/sql"
	"html/template"
	"log"
	"net/http"
	"strconv"
)

type Product struct {
	ID_Produk    int
	NamaProduk   string
	Harga        int
	Kategori     string
	Stok         int
	Deskripsi    string
	Gambar       string
	Satuan       string
	Harga_Diskon int
}

func EditProductHandler(db *sql.DB) http.HandlerFunc {
	return func(w http.ResponseWriter, r *http.Request) {
		var idStr string
		if r.Method == http.MethodPost {
			idStr = r.FormValue("id") // dari form POST
		} else {
			idStr = r.URL.Query().Get("id") // dari query GET
		}

		id, err := strconv.Atoi(idStr)
		if err != nil {
			http.Error(w, "Invalid product ID", http.StatusBadRequest)
			return
		}

		if r.Method == http.MethodPost {
			// Ambil data form
			nama := r.FormValue("nama_produk")
			harga, _ := strconv.Atoi(r.FormValue("harga"))
			kategori := r.FormValue("kategori")
			stok, _ := strconv.Atoi(r.FormValue("stok"))
			deskripsi := r.FormValue("deskripsi")
			satuan := r.FormValue("satuan")
			hargaDiskon, _ := strconv.Atoi(r.FormValue("harga_diskon"))
			// TODO: upload file gambar

			// Update ke database
			_, err := db.Exec(`
				UPDATE produk SET nama_produk=?, harga=?, kategori=?, stok=?, deskripsi=?, satuan=?, harga_diskon=? WHERE ID_Produk=? 
			`, nama, harga, kategori, stok, deskripsi, satuan, hargaDiskon, id)
			if err != nil {
				http.Error(w, "Failed to update product", http.StatusInternalServerError)
				return
			}

			http.Redirect(w, r, "/admin/stock", http.StatusSeeOther)
			return
		}

		// GET method: ambil data produk
		var p Product
		query := `
			SELECT ID_Produk, nama_produk, harga, kategori, stok, deskripsi, gambar, satuan, harga_diskon 
			FROM produk WHERE ID_Produk = ?
		`
		err = db.QueryRow(query, id).Scan(&p.ID_Produk, &p.NamaProduk, &p.Harga, &p.Kategori, &p.Stok, &p.Deskripsi, &p.Gambar, &p.Satuan, &p.Harga_Diskon)
		if err != nil {
			http.Error(w, "Product not found", http.StatusNotFound)
			return
		}

		// Load templates ke buffer dulu
		tmpl, err := template.ParseFiles(
			"views/admin/editproduct.html",
			"parts/admin/navbar.html",
			"parts/admin/sidebar.html",
		)
		if err != nil {
			log.Println("Template parsing error:", err)
			http.Error(w, "Template error", http.StatusInternalServerError)
			return
		}

		// Execute template ke response
		data := map[string]interface{}{
			"Product":     p,
			"CurrentPath": r.URL.Path,
		}
		err = tmpl.ExecuteTemplate(w, "editproduct", data)
		if err != nil {
			log.Println("Template execution error:", err)
			// Jangan kirim http.Error karena kemungkinan response sudah ditulis
		}
	}
}
