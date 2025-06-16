package controller

import (
	"database/sql"
	"net/http"
)

func UpdateStatusHandler(db *sql.DB) http.HandlerFunc {
	return func(w http.ResponseWriter, r *http.Request) {
		if r.Method != http.MethodPost {
			http.Error(w, "Invalid method", http.StatusMethodNotAllowed)
			return
		}

		id := r.FormValue("id")
		status := r.FormValue("status")

		_, err := db.Exec("UPDATE pesanan SET status = ? WHERE id_pembayaran = ?", status, id)
		if err != nil {
			http.Error(w, err.Error(), http.StatusInternalServerError)
			return
		}

		http.Redirect(w, r, "/order", http.StatusSeeOther)
	}
}
