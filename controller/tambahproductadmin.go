package controller

import (
	"database/sql"
	"html/template"
	"log"
	"net/http"
	"os"
	"path/filepath"
	"strconv"
)

func TambahProductHandler(db *sql.DB) func(http.ResponseWriter, *http.Request) {
	return func(w http.ResponseWriter, r *http.Request) {
		if r.Method == "POST" {
			// Parse multipart form untuk upload file
			err := r.ParseMultipartForm(10 << 20) // max 10MB
			if err != nil {
				http.Error(w, "Gagal parsing form", http.StatusBadRequest)
				return
			}

			namaProduk := r.FormValue("nama_produk")
			hargaStr := r.FormValue("harga")
			kategori := r.FormValue("kategori")
			stokStr := r.FormValue("stok")
			deskripsi := r.FormValue("deskripsi")
			satuan := r.FormValue("satuan")
			hargaDiskonStr := r.FormValue("harga_diskon")

			// Konversi harga dan stok ke int
			harga, err := strconv.Atoi(hargaStr)
			if err != nil {
				http.Error(w, "Harga tidak valid", http.StatusBadRequest)
				return
			}
			stok, err := strconv.Atoi(stokStr)
			if err != nil {
				http.Error(w, "Stok tidak valid", http.StatusBadRequest)
				return
			}

			// Upload file gambar
			file, handler, err := r.FormFile("gambar")
			if err != nil {
				http.Error(w, "Gagal upload gambar", http.StatusBadRequest)
				return
			}
			defer file.Close()

			uploadDir := "uploads"
			if _, err := os.Stat(uploadDir); os.IsNotExist(err) {
				os.Mkdir(uploadDir, os.ModePerm)
			}
			gambarPath := filepath.Join(uploadDir, handler.Filename)

			dst, err := os.Create(gambarPath)
			if err != nil {
				http.Error(w, "Gagal simpan gambar", http.StatusInternalServerError)
				return
			}
			defer dst.Close()
			_, err = dst.ReadFrom(file)
			if err != nil {
				http.Error(w, "Gagal membaca file gambar", http.StatusInternalServerError)
				return
			}

			// Insert ke database
			_, err = db.Exec(`
				INSERT INTO produk (nama_produk, harga, kategori, Stok, deskripsi, gambar, satuan, harga_diskon)
				VALUES (?, ?, ?, ?, ?, ?, ?, ?)`,
				namaProduk, harga, kategori, stok, deskripsi, handler.Filename, satuan, hargaDiskonStr,
			)
			if err != nil {
				log.Println("INSERT ERROR:", err)
				http.Error(w, "Gagal menyimpan data", http.StatusInternalServerError)
				return
			}

			http.Redirect(w, r, "/produk", http.StatusSeeOther)
			return

		} else if r.Method == "GET" {
			// Render form
			tmpl, err := template.ParseFiles(
				"views/admin/tambahproduct.html",
				"parts/admin/sidebar.html",
				"parts/admin/navbar.html",
			)

			if err != nil {
				http.Error(w, err.Error(), http.StatusInternalServerError)
				return
			}
			tmpl.Execute(w, nil)
		}
	}
}
