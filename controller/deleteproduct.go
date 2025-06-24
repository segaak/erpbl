package controller

import (
	"database/sql"
	"net/http"
	"strconv"
)

func DeleteProductHandler(db *sql.DB) http.HandlerFunc {
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

		// Langkah 1: Hapus dulu semua pesanan yang menggunakan produk ini
		_, err = db.Exec(`DELETE FROM pesanan WHERE id_produk = ?`, id)
		if err != nil {
			http.Error(w, "Gagal menghapus data pesanan terkait produk", http.StatusInternalServerError)
			return
		}

		// Langkah 2: Baru hapus produknya
		_, err = db.Exec(`DELETE FROM produk WHERE ID_Produk = ?`, id)
		if err != nil {
			http.Error(w, "Gagal menghapus produk", http.StatusInternalServerError)
			return
		}

		// Redirect ke halaman produk
		http.Redirect(w, r, "/admin/product", http.StatusSeeOther)
	}
}
